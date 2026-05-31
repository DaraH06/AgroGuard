import cv2
import numpy as np
import os
import glob
from model.ekstraktor import get_timestamp

def save_extracted_leaf(image_path, output_name = get_timestamp(), output_folder="hasil"):
    # Buat folder jika belum ada
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)

    img = cv2.imread(image_path)
    if img is None: 
        print(f"Error: Gambar tidak ditemukan di {image_path}")
        return None
    
    # --- PENERAPAN CLAHE PADA KANAL L (LAB) ---
    # Ini dilakukan sebelum konversi ke HSV untuk menonjolkan fitur lesi
    lab = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)
    l, a, b_lab = cv2.split(lab)
    clahe = cv2.createCLAHE(clipLimit=1, tileGridSize=(4,4))
    cl = clahe.apply(l)
    img = cv2.cvtColor(cv2.merge((cl, a, b_lab)), cv2.COLOR_LAB2BGR)
    
    imggray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    
    img = cv2.resize(img, (256, 256))
    hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
    # h, s, v = cv2.split(hsv_img) # Split HSV channels for later use

    # 1. Masker Daun (Sangat Luas): Menangkap hijau, kuning, cokelat, dan abu-abu tulang daun
    lower_leaf = np.array([20, 60, 60]) 
    upper_green = np.array([90, 255, 255]) # Batas atas untuk hijau, saturasi dan value penuh

    # 2. Masker Sehat (Ketat): Hanya hijau yang benar-benar sehat
    # Perluas cakupan sehat agar bayangan/hijau gelap tidak masuk kategori penyakit
    lower_healthy = np.array([25, 50, 50]) 

    mask_for_disease = cv2.inRange(hsv_img, lower_healthy, upper_green)

    mask = cv2.inRange(hsv_img, lower_leaf, upper_green)
    
    kernel = np.ones((5,5), np.uint8)
    
    mask_dilated = cv2.dilate(mask, kernel, iterations=2)

    contours, _ = cv2.findContours(mask_dilated, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    mask_solid = np.zeros_like(mask)

    if contours:
        c = max(contours, key=cv2.contourArea)
        cv2.drawContours(mask_solid, [c], -1, 255, -1)
        # mask_solid = cv2.medianBlur(mask_solid, 5)

    hsv_masked = cv2.bitwise_and(hsv_img, hsv_img, mask=mask_solid)
    h, s, v = cv2.split(hsv_masked)

    # not_healthy = cv2.bitwise_and(cv2.bitwise_not(mask_for_disease), mask_solid)
    not_healthy = cv2.bitwise_not(mask_for_disease)
    
    _, mask_v = cv2.threshold(v, 70, 255, cv2.THRESH_BINARY)
    _, mask_s = cv2.threshold(s, 70, 255, cv2.THRESH_BINARY)
    
    mask_inner = cv2.erode(mask_solid, np.ones((4,4), np.uint8), iterations=1)

    mask_disease_raw = cv2.bitwise_and(not_healthy, mask_inner)
    mask_disease_raw = cv2.bitwise_and(mask_disease_raw, mask_v)
    mask_disease_raw = cv2.bitwise_and(mask_disease_raw, mask_s)
    
    # Hapus bintik piksel kecil
    mask_disease_raw = cv2.medianBlur(mask_disease_raw, 3)

    mask_disease = np.zeros_like(mask_for_disease)
    disease_contours, _ = cv2.findContours(mask_disease_raw, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    
    print(f"jumlah : {len(disease_contours)}")
    for cnt in disease_contours:
        area = cv2.contourArea(cnt)
        # Fokus pada bercak dengan ukuran yang masuk akal (buang noise sangat kecil)
        x, y, w, h = cv2.boundingRect(cnt)
        ratio = float(w) / h if h > 0 else 0
        if 650 > area > 12 and 0.2 < ratio < 5.0:
            print(f"area : {area}")
            print(f"ratio : {ratio}")
            cv2.drawContours(mask_disease, [cnt], -1, 255, -1)

    # PENAMAAN FILE YANG BENAR
    path_4dis = os.path.join(output_folder, f"mask for disease {output_name}.jpg")
    path_seg = os.path.join(output_folder, f"segmentasi {output_name}.jpg")
    path_dis = os.path.join(output_folder, f"mask_disease {output_name}.jpg")
    path_rawdis = os.path.join(output_folder, f"mask_disease_raw {output_name}.jpg") # Ini akan menyimpan mask_disease_raw, bukan mask_combined

    # Simpan dan Cek Status
    s1 = cv2.imwrite(path_4dis, mask_for_disease)
    s2 = cv2.imwrite(path_seg, imggray)
    s3 = cv2.imwrite(path_dis, mask_disease)
    s4 = cv2.imwrite(path_rawdis, mask_disease_raw)

    if s1 and s3 and s2:
        print(f"✅ Berhasil! File disimpan di folder '{output_folder}'")
    else:
        print("❌ Gagal menyimpan. Pastikan nama file/path benar.")

