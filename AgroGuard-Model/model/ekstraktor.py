import cv2
import numpy as np
import pandas as pd
from datetime import datetime

from skimage.feature import graycomatrix, graycoprops

MIN_LEAF_AREA_RATIO = 0.035
MIN_LARGEST_CONTOUR_RATIO = 0.02
MIN_GREEN_DOMINANCE_RATIO = 1.04

def get_timestamp(full: bool = False):
    now = int(datetime.now().timestamp())
    then = datetime.fromtimestamp(now)
    hasil = then.strftime("%Y%m%d") if not full else then.strftime("%Y%m%d-%H%M%S")
    return hasil


def validate_leaf_image(img, mask_solid) -> dict:
    height, width = mask_solid.shape
    total_pixels = height * width
    leaf_pixels = cv2.countNonZero(mask_solid)
    leaf_area_ratio = leaf_pixels / total_pixels if total_pixels else 0

    contours, _ = cv2.findContours(mask_solid, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    largest_contour_ratio = 0

    if contours:
        largest_contour_ratio = cv2.contourArea(max(contours, key=cv2.contourArea)) / total_pixels

    if leaf_area_ratio < MIN_LEAF_AREA_RATIO or largest_contour_ratio < MIN_LARGEST_CONTOUR_RATIO:
        return {
            'success': False,
            'message': 'Foto tidak terdeteksi sebagai daun. Pastikan daun terlihat jelas dan tidak terlalu kecil.'
        }

    leaf = img[mask_solid > 0]
    mean_bgr = np.mean(leaf, axis=0)
    b, g, r = mean_bgr[0], mean_bgr[1], mean_bgr[2]
    green_dominance = g / max((r + b) / 2, 1)

    if green_dominance < MIN_GREEN_DOMINANCE_RATIO:
        return {
            'success': False,
            'message': 'Foto tidak terdeteksi sebagai daun. Warna objek tidak cukup menyerupai daun.'
        }

    return {'success': True}


def extract_features(image_path) ->list:
    img = cv2.imread(image_path)
    if img is None:
        return {'success':False, 'message':'Foto tidak ditemukan / tidak valid di direktori projek'}

    lab = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)
    l, a, b = cv2.split(lab)

    clahe = cv2.createCLAHE(clipLimit=3, tileGridSize=(8,8))
    cl = clahe.apply(l)

    limg = cv2.merge((cl,a,b))
    img = cv2.cvtColor(limg, cv2.COLOR_LAB2BGR)

    img = cv2.resize(img, (256, 256))
    hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

    lower_green = np.array([20,60,60]) #kecoklatan/kekuningan
    lower_healthy = np.array([25,50,50]) #kecoklatan/kekuningan
    upper_green = np.array([90,255,255]) #hijau pekat

    mask_for_disease = cv2.inRange(hsv_img, lower_healthy, upper_green)
    mask = cv2.inRange(hsv_img, lower_green, upper_green)
    kernel = np.ones((5,5), np.uint8)
    mask_dilated = cv2.dilate(mask, kernel, iterations=2)

    contours, _ = cv2.findContours(mask_dilated, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    mask_solid = np.zeros_like(mask)

    if contours:
        c= max(contours, key=cv2.contourArea)
        cv2.drawContours(mask_solid, [c], -1, 255, -1)
        mask_solid = cv2.medianBlur(mask_solid, 5)

    leaf = img[mask_solid >0]

    if len(leaf)==0:
        return {'success':False, 'message' :f"gagal memotong gambar {image_path}. Kemungkinan background menyatu dengan objek"}

    leaf_validation = validate_leaf_image(img, mask_solid)
    if not leaf_validation['success']:
        return leaf_validation
    
    # ini batas kode opsional
    # mask_disease = cv2.bitwise_and(cv2.bitwise_not(mask_for_disease), mask_solid)
    # disease_contours, _ = cv2.findContours(mask_disease, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    # aspect_ratios = []

    # for cnt in disease_contours:
    #     area = cv2.contourArea(cnt)
    #     x, y, w, h = cv2.boundingRect(cnt)
    #     ratio = float(w) / h if h > 0 else 0
    #     if 650 > area > 6: # Filter agar noise kecil tidak ikut
    #         if 0.2 < ratio < 5.0:
    #             aspect_ratios.append(ratio)

    # avg_aspect_ratio = np.mean(aspect_ratios) if aspect_ratios else 0.0
    #batas kode opsional


    mean_bgr = np.mean(leaf, axis=0)
    b, g, r = mean_bgr[0], mean_bgr[1], mean_bgr[2]
    
    green_channel = leaf[:,1]
    g_std = np.std(green_channel) # Indeks 1 adalah kanal Green
    
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    gray_leaf = cv2.bitwise_and(gray, gray, mask=mask_solid)
    glcm = graycomatrix(gray_leaf, distances=[5], angles=[0], levels=256, symmetric=True, normed=True)
    contrast = graycoprops(glcm, 'contrast')[0, 0]

    exg = (2 * g) - r - b

    return {'success':True, 'result': [r, g, b, exg, g_std, contrast]}


# Simpan ke CSV
def save_to_csv(data_list, path, label:str):
    columns = ['mean_r', 'mean_g', 'mean_b', 'exg', 'g_std', 'contrast', 'Label']
    df = pd.DataFrame(data_list, columns=columns)
    name = f"{get_timestamp()}_{label}.csv"
    output_path = f"{path}/{name}"

    df.to_csv(output_path, index=False)

    return name

# Proses Dataset
def dataset_processor(label: str, data_path: list, output_path: str, data_train:bool=True):
    data_list = []
    status = True
    num = 0
    
    for filename in data_path:
        if filename.lower().endswith(('.jpg', '.png', '.jpeg')):
            features = extract_features(filename)

            if features['success']:
                feature_list = features['result']
                num +=1
                feature_list.append(label)
                data_list.append(feature_list)
            else:
                return {'success': False, 'message': features['message']}
    else:
        print(f"{get_timestamp(True)} : {label} selesai diproses")
        hasil = save_to_csv(data_list=data_list, path=output_path, label=label)
        return {'success':status, 'message':f"data disimpan sebagai '{hasil}' untuk label '{label}'", 'count':num, 'name':hasil}
