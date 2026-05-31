from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.neighbors import KNeighborsClassifier
import numpy as np

def classify(knn, scaler, le, X_feature:list)->dict:
    try:
        X_new = np.array(X_feature).reshape(1, -1)
        X_new_scaled = scaler.transform(X=X_new)

        prediksi = knn.predict(X=X_new_scaled)
        probabilistik = knn.predict_proba(X_new_scaled)[0]

        classes = le.classes_
        hasil = le.inverse_transform(prediksi)[0]

        label = []
        for i, cls in enumerate(classes):
            label.append({cls : probabilistik[i]})

        return {
            'success':True,
                'data': {
                    'hasil' : hasil,
                    'tingkat_keyakinan' : label
                    }
                }
    except Exception as e:
        return {'success':False,
                'message':f'Terjadi kesalahan pada model : {str(e)}'}


def initiate(dataset:list):
    scaler = StandardScaler()
    le = LabelEncoder()

    if not dataset:
        return {'success':False, 'message': "Dataset kosong, perlu restart model"}
    X_train = np.array([[
        data['mean_r'], data['mean_g'], data['mean_b'],
             data['exg'], data['g_std'], data['contrast']
             ] for data in dataset
        ])
    Y_train = np.array([data['Label'] for data in dataset])

    # import pandas as pd

    # df_train = pd.read_csv('model/files/train_388.csv')
    # df_valid = pd.read_csv('model/files/val_388.csv')
    # # df_train = pd.read_csv('model/files/train_388.csv')
    # # df_valid = pd.read_csv('model/files/val_388.csv')

    # df = pd.concat([df_train, df_valid], ignore_index=True)

    # X_train = df.drop(['Label'], axis=1)
    # Y_train = df['Label']

    knn = KNeighborsClassifier(n_neighbors=5, weights='distance', metric='canberra')
    knn.fit(X=scaler.fit_transform(X_train), y=le.fit_transform(Y_train))

    import joblib

    joblib.dump(knn, 'model/knn_model.joblib')
    joblib.dump(scaler, 'model/scaler.joblib')
    joblib.dump(le, 'model/label.joblib')

    return {'success': True, 'model':knn}
    
