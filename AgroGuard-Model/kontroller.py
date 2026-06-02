import os
from pymongo import MongoClient
from model.knn import initiate
import joblib


def getConnection():
    db_HOST = os.getenv("DB_HOST")
    db_PORT = int(os.getenv("DB_PORT"))
    db_DATABASE = os.getenv("DB_DATABASE")
    db_USER = os.getenv("DB_USER")
    db_PASSWORD = os.getenv("DB_PASSWORD")

    if db_USER and db_PASSWORD:
        uri = f"mongodb://{db_USER}:{db_PASSWORD}@{db_HOST}:{db_PORT}/{db_DATABASE}?authSource=admin"
    else:
        uri = f"mongodb://{db_HOST}:{db_PORT}/"
    return MongoClient(uri)

def load_data(refresh:bool = False)->dict:
    lengkap = os.path.exists('model/knn_model.joblib') and os.path.exists('model/label.joblib') and os.path.exists('model/scaler.joblib')
    if refresh or not lengkap:
        try:
            db_DATABASE = os.getenv("DB_DATABASE")
            conn = getConnection()
            db = conn[db_DATABASE]
            collection = db['data_ekstraksis']
            dataset = list(collection.find())


            respon = initiate(dataset)
            if respon['success']:
                model = joblib.load('model/knn_model.joblib')
                message = f"Berhasil memuat {len(dataset)} data ke memori"
            else:
                message = respon['message']

            print(message, flush=True)
            return {"success" : True, 'model': model, 'dataset': dataset}
    
        except Exception as e:
            print(f"Koneksi ke database gagal : {e}", flush=True)
            return {"success" : False, "message" : e}
    else:
        model = joblib.load('model/knn_model.joblib')
        message = f"Berhasil memuat joblib"

        print(message, flush=True)
        return {"success" : True, 'model': model}
