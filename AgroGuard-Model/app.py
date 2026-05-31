from flask import Flask, request, jsonify, abort
import os
import joblib
from functools import wraps
from kontroller import getConnection, load_data
from dotenv import load_dotenv
from model.knn import classify
from model.ekstraktor import dataset_processor, extract_features
from model.bgremover import save_extracted_leaf


load_dotenv()
app = Flask(__name__)

def require_api_key(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        api_key = request.headers.get('X-API-KEY')
        if api_key and api_key == os.getenv('INTERNAL_API_KEY'):
            return f(*args, **kwargs)
        else:
            abort(401)
    return decorated_function

model = None

def preparation():
    global model
    getConnection()
    load = load_data()
    if load['success']:
        model = load['model']
    else:
        return

@app.route('/ekstrak', methods=['POST'])
@require_api_key
def mengekstrak():
    global model

    if model is None:
        load = load_data()
        if load['success']:
            model = load['model']

    path_foto = request.json.get('path_foto')

    abs_path = os.path.abspath(path_foto)

    if not os.path.exists(path_foto) :
        return jsonify({
            'success':False,
            'hasil':'Bukan path ini woy',
            'kamu ngirim di ': path_foto,
            'lokasi Flask' : os.getcwd()
        })
    
    X_feature = extract_features(path_foto)

    save_extracted_leaf(path_foto)

    if X_feature['success'] and len(X_feature['result'])==6:
        hasil = classify(model,
                         joblib.load('model/scaler.joblib'),
                         joblib.load('model/label.joblib'),
                         X_feature=X_feature['result'])
        return jsonify(hasil)
    elif X_feature['success'] and len(X_feature['result']) != 6:
        print(X_feature, flush=True)
        message = "Ketidakcocokan data ekstrak, hubungi Admin"
        return jsonify({'success':False, 'message':message})
    else:
        return jsonify({'success':False, 'message':X_feature['message']})

@app.route('/refresh_model', methods=['POST'])
@require_api_key
def update():
    global model
    load = load_data(refresh=True)
    if load['success']:
        model = load['model']
        return jsonify({'success': True, 'message': f'Model berhasil di-refresh'})
    return jsonify({'success': False, 'message': load['message']})


@app.route('/proses-dataset', methods=['POST'])
@require_api_key
def proses_dataset():
    global model

    label = request.json.get('label')
    path_folder = request.json.get('path_folder')
    path_result = request.json.get('path_result')

    if not label or not path_folder:
        return jsonify({'success': False, 'message': 'label dan path_folder wajib diisi'})

    if not os.path.exists(path_folder):
        return jsonify({'success': False, 'message': f'Folder tidak ditemukan: {path_folder}'})

    # Cari semua gambar (termasuk di subfolder)
    image_files = []
    for root, dirs, files in os.walk(path_folder):
        for f in files:
            if f.lower().endswith(('.jpg', '.png', '.jpeg')):
                image_files.append(os.path.join(root, f))

    if not image_files:
        return jsonify({'success': False, 'message': 'Tidak ada gambar ditemukan di folder'})
    hasil = dataset_processor(label=label, data_path=image_files, output_path=path_result)
    
    if hasil['success']:
        return jsonify({
            'success': True,
            'message': hasil['message'],
            'jumlah' : hasil['count'],
            'nama': hasil['name']
        })
    else:
        return jsonify({
            'success': False,
            'message': hasil['message']
        })




preparation()