# 📚 Dokumentasi Lengkap AgroGuard-Model

**Versi:** 1.0  
**Tanggal:** Juni 2026  
**Penulis:** AgroGuard Team  
**Status:** Complete Documentation

---

## 📋 Daftar Isi

1. [Overview Sistem](#overview-sistem)
2. [Arsitektur Teknis](#arsitektur-teknis)
3. [Tech Stack & Dependencies](#tech-stack--dependencies)
4. [Setup & Installation](#setup--installation)
5. [Struktur Folder](#struktur-folder)
6. [Detail Modul Kode](#detail-modul-kode)
7. [Alur Kerja Lengkap](#alur-kerja-lengkap)
8. [API Endpoints](#api-endpoints)
9. [Database Schema](#database-schema)
10. [Penjelasan Algoritma](#penjelasan-algoritma)
11. [Troubleshooting](#troubleshooting)

---

## Overview Sistem

### 🎯 Tujuan Utama

**AgroGuard-Model** adalah sistem **Machine Learning berbasis Python Flask** yang dirancang untuk:

- ✅ **Deteksi Penyakit Tanaman** - Khususnya pada daun menggunakan Computer Vision
- ✅ **Klasifikasi Otomatis** - Mengidentifikasi jenis penyakit dengan confidence score
- ✅ **Real-time Processing** - API REST untuk integrasi dengan mobile/web app
- ✅ **Dynamic Training** - Dapat di-train ulang dengan dataset baru
- ✅ **Enterprise-ready** - API Key authentication, error handling, logging

### 📊 Kapabilitas Sistem

| Fitur | Deskripsi | Status |
|-------|-----------|--------|
| Deteksi Penyakit | Identifikasi otomatis penyakit daun | ✅ Active |
| Segmentasi Daun | Pisahkan daun dari background | ✅ Active |
| Feature Extraction | 6 fitur visual daun | ✅ Active |
| KNN Classification | 5-NN classifier dengan Canberra distance | ✅ Active |
| Model Refresh | Reload model dari database | ✅ Active |
| Dataset Processing | Batch processing untuk training | ✅ Active |
| Security | API Key validation | ✅ Active |

---

## Arsitektur Teknis

```
┌─────────────────────────────────────────────────────────────┐
│                    AgroGuard Frontend                        │
│              (Admin Panel / Mobile App)                      │
└────────────────┬────────────────────────────────────────────┘
                 │
                 │ HTTP/REST
                 ▼
┌─────────────────────────────────────────────────────────────┐
│                    Flask Application                         │
│                     (app.py)                                 │
│  ┌──────────────────────────────────────────────────────┐  │
│  │  Endpoints:                                          │  │
│  │  • /ekstrak (POST) - Deteksi penyakit              │  │
│  │  • /refresh_model (POST) - Update model            │  │
│  │  • /proses-dataset (POST) - Process training data  │  │
│  └──────────────────────────────────────────────────────┘  │
└────────────────┬──────────────┬─────────────────┬──────────┘
                 │              │                 │
                 ▼              ▼                 ▼
        ┌──────────────┐ ┌───────────┐ ┌──────────────────┐
        │  Controller  │ │ Extractor │ │  BG Remover      │
        │ (kontroller) │ │(ekstraktor)│ │ (bgremover)      │
        └──────┬───────┘ └─────┬─────┘ └────────┬─────────┘
               │               │                 │
               ▼               ▼                 ▼
        ┌──────────────┐ ┌───────────┐ ┌──────────────────┐
        │  MongoDB     │ │   KNN     │ │ Image Processing │
        │  Database    │ │ Classifier│ │ (OpenCV/skimage) │
        │              │ │ (knn.py)  │ │                  │
        └──────────────┘ └─────┬─────┘ └──────────────────┘
                               │
                ┌──────────────┴──────────────┐
                ▼                             ▼
            ┌─────────┐              ┌──────────────┐
            │ Scaler  │              │  Label       │
            │.joblib  │              │  Encoder     │
            │         │              │  .joblib     │
            └─────────┘              └──────────────┘
```

---

## Tech Stack & Dependencies

### 🐍 Python Version
- **Python 3.8+** (recommended 3.10+)

### 📦 Core Dependencies

#### Web Framework
```
Flask==3.1.3                          # Web server framework
Werkzeug==3.1.8                       # WSGI utility
Jinja2==3.1.6                         # Template engine
```

#### Machine Learning & Data Science
```
scikit-learn==1.8.0                   # ML algorithms (KNN, StandardScaler, LabelEncoder)
numpy==2.4.4                          # Numerical computing
pandas==3.0.2                         # Data manipulation & CSV handling
joblib==1.5.3                         # Model serialization
scipy==1.17.1                         # Scientific computing
```

#### Computer Vision
```
opencv-python==4.13.0.92              # Image processing (masking, segmentation)
scikit-image==0.26.0                  # Advanced image features (GLCM, texture)
pillow==12.2.0                        # Image handling
imageio==2.37.3                       # Image I/O
```

#### Database
```
pymongo==4.17.0                       # MongoDB driver
```

#### Utilities
```
python-dotenv==1.2.2                  # Environment variable loading
click==8.3.2                          # CLI utilities
```

#### Development Tools
```
jupyter==1.0.0                        # Notebook environment
matplotlib==3.10.9                    # Data visualization
ipython==9.13.0                       # Interactive shell
```

---

## Setup & Installation

### ✅ Prasyarat
- Python 3.8 atau lebih tinggi
- pip (Python package manager)
- MongoDB server (local atau cloud)
- Git

### 📝 Langkah-langkah Instalasi

#### 1. Clone Repository
```bash
git clone https://github.com/DaraH06/AgroGuard-admin.git
cd AgroGuard-admin/AgroGuard-Model
```

#### 2. Buat Virtual Environment
```bash
# Windows
python -m venv venv
venv\Scripts\activate

# Linux/Mac
python3 -m venv venv
source venv/bin/activate
```

#### 3. Install Dependencies
```bash
pip install -r requirements.txt
```

#### 4. Konfigurasi Environment Variables
Buat file `.env` di root folder `AgroGuard-Model`:

```env
# MongoDB Configuration
DB_HOST=localhost
DB_PORT=27017
DB_DATABASE=agroguard_db
DB_USER=your_mongodb_user
DB_PASSWORD=your_mongodb_password

# Flask Configuration
FLASK_ENV=development
FLASK_DEBUG=True

# API Security
INTERNAL_API_KEY=your_secret_api_key_here
```

#### 5. Jalankan Flask Server
```bash
# Windows
python -m flask run

# Linux/Mac
python3 -m flask run
```

Server akan berjalan di: `http://localhost:5000`

---

## Struktur Folder

```
AgroGuard-Model/
│
├── model/                              # Machine Learning modules
│   ├── __init__.py
│   ├── knn.py                         # KNN classifier (training & prediction)
│   ├── ekstraktor.py                  # Feature extraction dari gambar
│   ├── bgremover.py                   # Background removal & segmentation
│   ├── knn_model.joblib               # Pre-trained KNN model (generated)
│   ├── scaler.joblib                  # Feature scaler (generated)
│   └── label.joblib                   # Label encoder (generated)
│
├── hasil/                             # Output folder (generated)
│   ├── mask_disease_*.jpg             # Disease mask visualization
│   ├── mask for disease_*.jpg         # Healthy area mask
│   └── segmentasi_*.jpg               # Image segmentation
│
├── app.py                             # Flask main application & API endpoints
├── kontroller.py                      # Database controller & model manager
├── requirements.txt                   # Python dependencies
├── .env.example                       # Environment variables template
├── .gitignore                         # Git ignore rules
├── README.md                          # Quick start guide
└── DOKUMENTASI_LENGKAP.md             # This file
```

---

## Detail Modul Kode

### 📄 1. app.py - Flask Application

**Fungsi Utama:**
- Membuat REST API server
- Menangani request dari frontend/mobile
- Validasi API Key
- Mengelola lifecycle model

#### **Struktur File**

```python
# Import libraries
from flask import Flask, request, jsonify, abort
import os
import joblib
from functools import wraps
from kontroller import getConnection, load_data
from dotenv import load_dotenv
from model.knn import classify
from model.ekstraktor import dataset_processor, extract_features
from model.bgremover import save_extracted_leaf

# Initialize Flask
load_dotenv()
app = Flask(__name__)

# API Key validation decorator
def require_api_key(f):
    """Decorator untuk validate API Key di header request"""
    @wraps(f)
    def decorated_function(*args, **kwargs):
        api_key = request.headers.get('X-API-KEY')
        if api_key and api_key == os.getenv('INTERNAL_API_KEY'):
            return f(*args, **kwargs)
        else:
            abort(401)  # Unauthorized
    return decorated_function

# Global model variable
model = None

# Preparation function
def preparation():
    """Load model ke memory saat server start"""
    global model
    getConnection()
    load = load_data()
    if load['success']:
        model = load['model']
    else:
        return

# Endpoints (3 endpoint)
# 1. /ekstrak
# 2. /refresh_model
# 3. /proses-dataset

# Server start
preparation()
```

#### **Endpoint 1: /ekstrak (POST)**

**Tujuan:** Deteksi penyakit daun dari foto

**Request Body:**
```json
{
    "path_foto": "/path/to/leaf/image.jpg"
}
```

**Header:**
```
X-API-KEY: your_secret_api_key
Content-Type: application/json
```

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "hasil": "leaf_rust",
        "tingkat_keyakinan": [
            {"leaf_rust": 0.85},
            {"powdery_mildew": 0.12},
            {"healthy": 0.03}
        ]
    }
}
```

**Response Error:**
```json
{
    "success": false,
    "message": "Foto tidak terdeteksi sebagai daun"
}
```

**Logika:**
1. Validasi API Key
2. Cek keberadaan file foto
3. Extract features dari gambar
4. Load model jika belum ada
5. Jalankan prediksi KNN
6. Save segmentasi hasil ke folder `hasil/`
7. Return hasil prediksi + confidence

#### **Endpoint 2: /refresh_model (POST)**

**Tujuan:** Memperbarui model dari dataset terbaru di MongoDB

**Request Body:**
```json
{}  # Empty body
```

**Header:**
```
X-API-KEY: your_secret_api_key
```

**Response:**
```json
{
    "success": true,
    "message": "Model berhasil di-refresh"
}
```

**Logika:**
1. Call `load_data(refresh=True)`
2. Retrain model dengan dataset terbaru
3. Update model di memory
4. Return status

#### **Endpoint 3: /proses-dataset (POST)**

**Tujuan:** Batch process gambar untuk training dataset

**Request Body:**
```json
{
    "label": "leaf_rust",
    "path_folder": "/path/to/leaf/images",
    "path_result": "/path/to/output"
}
```

**Response:**
```json
{
    "success": true,
    "message": "data disimpan sebagai 'nama_file.csv'",
    "jumlah": 45,
    "nama": "20260601-120530_leaf_rust.csv"
}
```

**Logika:**
1. Validasi parameter (label, path_folder)
2. Cari semua file gambar di folder (recursive)
3. Extract features dari setiap gambar
4. Jika ada error, return error message
5. Save hasil ke CSV dengan kolom: `[mean_r, mean_g, mean_b, exg, g_std, contrast, Label]`

---

### 📄 2. model/ekstraktor.py - Feature Extraction

**Fungsi Utama:**
- Extract 6 fitur visual dari gambar daun
- Validasi bahwa image adalah daun
- Preprocessing gambar untuk optimal feature extraction

#### **Fitur yang Diekstrak**

| No | Fitur | Formula/Method | Deskripsi |
|----|-------|----------------|-----------|
| 1 | `mean_r` | `np.mean(leaf_pixels[:, 0])` | Rata-rata intensitas Red channel |
| 2 | `mean_g` | `np.mean(leaf_pixels[:, 1])` | Rata-rata intensitas Green channel |
| 3 | `mean_b` | `np.mean(leaf_pixels[:, 2])` | Rata-rata intensitas Blue channel |
| 4 | `exg` | `2*G - R - B` | Excess Green Index (indikator kesehatan) |
| 5 | `g_std` | `np.std(green_channel)` | Standar deviasi Green (variasi warna) |
| 6 | `contrast` | GLCM feature | Texture contrast dari gambar |

#### **Alur Ekstraksi**

```
Input Image (JPG/PNG)
        ↓
[1] Baca gambar dengan OpenCV
        ↓
[2] Preprocessing (CLAHE)
    - Convert BGR → LAB
    - Apply CLAHE pada kanal L
    - Convert kembali ke BGR
        ↓
[3] Resize ke 256x256 pixel
        ↓
[4] Convert BGR → HSV
        ↓
[5] Segmentasi Daun
    - Buat mask berdasarkan range warna hijau
    - Dilasi untuk koneksi pixel
    - Ambil contour terbesar
    - Create solid mask
        ↓
[6] Validasi (Apakah benar-benar daun?)
    - Cek ukuran: leaf_area >= 3.5% dari image
    - Cek dominasi hijau: green >= 1.04 * avg(red+blue)
    - Reject jika tidak valid
        ↓
[7] Extract 6 Fitur
        ↓
[8] Return [r, g, b, exg, g_std, contrast]
```

#### **Parameter Penting**

```python
MIN_LEAF_AREA_RATIO = 0.035              # Minimum ukuran daun
MIN_LARGEST_CONTOUR_RATIO = 0.02         # Minimum contour area
MIN_GREEN_DOMINANCE_RATIO = 1.04         # Minimum dominasi warna hijau

# HSV Range untuk segmentasi
lower_green = np.array([20, 60, 60])     # Hue, Saturation, Value (cokelat/kuning)
upper_green = np.array([90, 255, 255])   # Hijau pekat
```

#### **Fungsi Penting**

```python
def extract_features(image_path) -> dict:
    """
    Extract 6 fitur dari gambar daun
    
    Args:
        image_path (str): Path ke file gambar
        
    Returns:
        dict: {
            'success': bool,
            'result': [r, g, b, exg, g_std, contrast] or None,
            'message': error_message
        }
    """

def validate_leaf_image(img, mask_solid) -> dict:
    """
    Validasi bahwa image adalah gambar daun yang valid
    
    Checks:
    - Ukuran leaf >= MIN_LEAF_AREA_RATIO
    - Contour terbesar >= MIN_LARGEST_CONTOUR_RATIO
    - Dominasi warna hijau >= MIN_GREEN_DOMINANCE_RATIO
    """

def dataset_processor(label: str, data_path: list, output_path: str):
    """
    Batch process multiple images untuk training
    
    Args:
        label: Nama label penyakit (e.g., 'leaf_rust')
        data_path: List path ke file gambar
        output_path: Folder output untuk CSV
        
    Returns:
        dict dengan status dan nama file output
    """

def save_to_csv(data_list: list, path: str, label: str):
    """
    Save extracted features ke CSV file
    
    Columns: [mean_r, mean_g, mean_b, exg, g_std, contrast, Label]
    """
```

---

### 📄 3. model/knn.py - K-Nearest Neighbors Classifier

**Fungsi Utama:**
- Train KNN classifier dengan dataset
- Melakukan prediksi penyakit
- Menghitung confidence score

#### **Algoritma KNN**

```
K-Nearest Neighbors (KNN) Configuration:
├── n_neighbors = 5           # Jumlah tetangga terdekat
├── weights = 'distance'      # Bobot berdasarkan jarak
├── metric = 'canberra'       # Jarak Canberra
└── Output: Class + Probabilities
```

#### **Training Pipeline**

```python
def initiate(dataset: list) -> dict:
    """
    Training KNN model dengan dataset dari MongoDB
    
    Process:
    1. Inisialisasi StandardScaler & LabelEncoder
    2. Extract feature matrix (X) & label vector (y)
    3. Fit & transform data
    4. Train KNN classifier
    5. Save ke joblib files
    
    Args:
        dataset: List of dict dari MongoDB
        
    Returns:
        {'success': True, 'model': knn_object}
    """
```

**Dataset Format dari MongoDB:**
```python
{
    '_id': ObjectId(...),
    'mean_r': 120.5,
    'mean_g': 180.3,
    'mean_b': 90.2,
    'exg': 170.1,
    'g_std': 25.3,
    'contrast': 15.2,
    'Label': 'leaf_rust'
}
```

#### **Prediksi Pipeline**

```python
def classify(knn, scaler, le, X_feature: list) -> dict:
    """
    Prediksi penyakit dari fitur input
    
    Process:
    1. Normalize fitur dengan scaler
    2. Prediksi class
    3. Hitung probabilitas untuk setiap class
    4. Inverse transform label ke nama penyakit
    5. Compute confidence untuk tiap class
    
    Args:
        knn: Trained KNN model
        scaler: Feature scaler
        le: Label encoder
        X_feature: [r, g, b, exg, g_std, contrast]
        
    Returns:
        {
            'success': True,
            'data': {
                'hasil': 'leaf_rust',
                'tingkat_keyakinan': [
                    {'leaf_rust': 0.85},
                    {'powdery_mildew': 0.10},
                    {'healthy': 0.05}
                ]
            }
        }
    """
```

#### **Contoh Training**

```python
# Feature matrix (45 samples, 6 features)
X_train = np.array([
    [120, 180, 90, 170, 25, 15],
    [118, 182, 88, 182, 26, 16],
    # ... lebih banyak samples
])

# Label vector
Y_train = np.array(['leaf_rust', 'leaf_rust', 'healthy', ...])

# Training
knn.fit(scaler.fit_transform(X_train), le.fit_transform(Y_train))

# Prediksi
X_new = np.array([[115, 185, 92, 175, 24, 14]])  # 1 sample
pred = knn.predict(scaler.transform(X_new))       # Output: ['leaf_rust']
proba = knn.predict_proba(scaler.transform(X_new)) # Output: [[0.85, 0.10, 0.05]]
```

---

### 📄 4. model/bgremover.py - Background Removal & Visualization

**Fungsi Utama:**
- Segmentasi daun dari background
- Deteksi area terinfeksi (disease spots)
- Save visualisasi hasil untuk quality assurance

#### **Proses Segmentasi**

```
Input Image
    ↓
[1] CLAHE Enhancement pada LAB color space
    ├─ Increase contrast pada kanal L
    └─ Better feature visibility
    ↓
[2] Convert BGR → HSV
    ↓
[3] Create Masks
    ├─ mask (Leaf): Range hijau luas [20-90 Hue]
    ├─ mask_for_disease (Healthy): Range hijau ketat [25-90 Hue]
    ├─ mask_dilated: Dilasi untuk koneksi pixel
    └─ mask_solid: Contour terbesar (daun utama)
    ↓
[4] Disease Detection
    ├─ not_healthy = komplemen dari mask_for_disease
    ├─ Filter V (Value) & S (Saturation) threshold
    ├─ Erosi untuk hapus pixel tepi
    ├─ Median blur untuk hapus noise
    └─ Filter contour berdasarkan area & aspect ratio
    ↓
[5] Save Output
    ├─ mask for disease_[timestamp].jpg
    ├─ segmentasi_[timestamp].jpg
    ├─ mask_disease_[timestamp].jpg
    └─ mask_disease_raw_[timestamp].jpg
```

#### **Filter Disease Detection**

```python
# Hanya simpan contour yang memenuhi kriteria:
AREA_MIN = 12 pixels²
AREA_MAX = 650 pixels²
ASPECT_RATIO_MIN = 0.2
ASPECT_RATIO_MAX = 5.0

# Calculation
area = cv2.contourArea(contour)
x, y, w, h = cv2.boundingRect(contour)
ratio = float(w) / h if h > 0 else 0

if (AREA_MIN < area < AREA_MAX) and (ASPECT_RATIO_MIN < ratio < ASPECT_RATIO_MAX):
    # Include this contour
```

#### **Output File**

| File | Deskripsi |
|------|-----------|
| `mask for disease_*.jpg` | Mask area sehat (background hitam) |
| `segmentasi_*.jpg` | Grayscale segmentation |
| `mask_disease_*.jpg` | Mask area terinfeksi (setelah filter) |
| `mask_disease_raw_*.jpg` | Raw disease detection (sebelum filter) |

---

### 📄 5. kontroller.py - Database & Model Manager

**Fungsi Utama:**
- Koneksi ke MongoDB
- Load dataset untuk training
- Manage model lifecycle

#### **Konfigurasi MongoDB**

```python
# .env variables
DB_HOST = os.getenv("DB_HOST")           # localhost atau URL cloud
DB_PORT = int(os.getenv("DB_PORT"))      # 27017 (default)
DB_DATABASE = os.getenv("DB_DATABASE")   # agroguard_db
DB_USER = os.getenv("DB_USER")           # username (optional)
DB_PASSWORD = os.getenv("DB_PASSWORD")   # password (optional)

# Connection URI
uri = f"mongodb://{db_USER}:{db_PASSWORD}@{db_HOST}:{db_PORT}/{db_DATABASE}?authSource=admin"
```

#### **Fungsi Penting**

```python
def getConnection() -> MongoClient:
    """
    Create MongoDB connection
    
    Returns:
        MongoClient instance
    """

def load_data(refresh: bool = False) -> dict:
    """
    Load & train model
    
    Logic:
    1. Check if model files exist (knn_model.joblib, label.joblib, scaler.joblib)
    2. If refresh=True atau files tidak exist:
       - Connect ke MongoDB
       - Query koleksi 'data_ekstraksis'
       - Call initiate() untuk training
       - Save model files
    3. Load model dari joblib ke memory
    4. Return model object
    
    Args:
        refresh: Force retrain model
        
    Returns:
        {
            'success': bool,
            'model': trained_model,
            'dataset': list_of_data,
            'message': status_message
        }
    """
```

---

## Alur Kerja Lengkap

### 🔄 Scenario 1: Deteksi Penyakit (User)

```
┌─────────────────────────────────────────────────────────┐
│ 1. User Upload Foto Daun di Mobile/Web App              │
│    (AgroGuard-mobile atau AgroGuard-admin)              │
└────────────────┬────────────────────────────────────────┘
                 │
                 │ POST /ekstrak
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 2. Flask Validate API Key                               │
│    Check: X-API-KEY header == INTERNAL_API_KEY          │
└────────────────┬────────────────────────────────────────┘
                 │ ✓ Valid
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 3. Flask Extract Fitur                                  │
│    - Call ekstraktor.py                                 │
│    - Return [r, g, b, exg, g_std, contrast]             │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 4. Flask Load Model (if null)                           │
│    - Call kontroller.load_data()                        │
│    - Load dari joblib files                             │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 5. Flask Prediksi dengan KNN                            │
│    - Normalize fitur dengan scaler                      │
│    - Call knn.predict() → 'leaf_rust'                   │
│    - Call knn.predict_proba() → [0.85, 0.10, 0.05]     │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 6. Flask Save Segmentasi                                │
│    - Call bgremover.save_extracted_leaf()               │
│    - Save 4 mask files ke folder hasil/                 │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 7. Flask Return Response                                │
│    {                                                     │
│      "success": true,                                    │
│      "data": {                                           │
│        "hasil": "leaf_rust",                             │
│        "tingkat_keyakinan": [...]                        │
│      }                                                   │
│    }                                                     │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│ 8. User Lihat Hasil di Mobile/Web App                   │
│    Penyakit: Leaf Rust                                  │
│    Confidence: 85%                                      │
└─────────────────────────────────────────────────────────┘
```

### 🔄 Scenario 2: Training Model (Admin)

```
┌──────────────────────────────────────────────────────┐
│ 1. Admin Upload Gambar Training ke Folder            │
│    /datasets/leaf_rust/                              │
│    /datasets/powdery_mildew/                         │
└─────────────────┬──────────────────────────────────┘
                  │
                  │ POST /proses-dataset
                  ▼
┌──────────────────────────────────────────────────────┐
│ 2. Flask Process Dataset                             │
│    - Recursive find semua .jpg/.png                  │
│    - Extract fitur dari setiap gambar                │
│    - Save ke CSV dengan label                        │
└─────────────────┬──────────────────────────────────┘
                  │
                  ▼
┌──────────────────────────────────────────────────────┐
│ 3. Admin Input CSV ke MongoDB                        │
│    INSERT ke collection 'data_ekstraksis'            │
└─────────────────┬──────────────────────────────────┘
                  │
                  │ POST /refresh_model
                  ▼
┌──────────────────────────────────────────────────────┐
│ 4. Flask Refresh Model                               │
│    - Query MongoDB for all data                      │
│    - Train KNN dengan dataset baru                   │
│    - Save model files (knn_model, scaler, label)    │
└─────────────────┬──────────────────────────────────┘
                  │
                  ▼
┌──────────────────────────────────────────────────────┐
│ 5. Model Update Complete                             │
│    Ready untuk deteksi dengan algoritma baru         │
└──────────────────────────────────────────────────────┘
```

---

## API Endpoints

### 📡 Endpoint Summary

| Method | Path | Auth | Fungsi |
|--------|------|------|--------|
| POST | `/ekstrak` | API Key | Deteksi penyakit dari foto |
| POST | `/refresh_model` | API Key | Reload model dari database |
| POST | `/proses-dataset` | API Key | Batch process training images |

### 1️⃣ POST /ekstrak

**Purpose:** Detect disease dari leaf image

**Request:**
```bash
curl -X POST http://localhost:5000/ekstrak \
  -H "X-API-KEY: your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{
    "path_foto": "C:/images/leaf.jpg"
  }'
```

**cURL dengan Linux:**
```bash
curl -X POST http://localhost:5000/ekstrak \
  -H "X-API-KEY: your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{"path_foto": "/home/user/images/leaf.jpg"}'
```

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "hasil": "leaf_rust",
    "tingkat_keyakinan": [
      {
        "leaf_rust": 0.85
      },
      {
        "powdery_mildew": 0.12
      },
      {
        "healthy": 0.03
      }
    ]
  }
}
```

**Error Response (400):**
```json
{
  "success": false,
  "message": "Foto tidak terdeteksi sebagai daun. Pastikan daun terlihat jelas dan tidak terlalu kecil."
}
```

**Error Response (401):**
```
Unauthorized (API Key tidak valid)
```

**Error Response (400):**
```json
{
  "success": false,
  "hasil": "Bukan path ini woy",
  "kamu ngirim di": "C:/images/leaf.jpg",
  "lokasi Flask": "C:/project/AgroGuard-Model"
}
```

### 2️⃣ POST /refresh_model

**Purpose:** Reload & retrain model dari MongoDB

**Request:**
```bash
curl -X POST http://localhost:5000/refresh_model \
  -H "X-API-KEY: your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{}'
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Model berhasil di-refresh"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Koneksi ke database gagal : [error_details]"
}
```

### 3️⃣ POST /proses-dataset

**Purpose:** Batch process images untuk training

**Request:**
```bash
curl -X POST http://localhost:5000/proses-dataset \
  -H "X-API-KEY: your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{
    "label": "leaf_rust",
    "path_folder": "C:/images/training/leaf_rust",
    "path_result": "C:/output/datasets"
  }'
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "data disimpan sebagai '20260601-120530_leaf_rust.csv' untuk label 'leaf_rust'",
  "jumlah": 45,
  "nama": "20260601-120530_leaf_rust.csv"
}
```

**Error Response (400):**
```json
{
  "success": false,
  "message": "label dan path_folder wajib diisi"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Foto tidak terdeteksi sebagai daun..."
}
```

---

## Database Schema

### 📊 MongoDB Collection: data_ekstraksis

**Structure:**
```json
{
  "_id": ObjectId("507f1f77bcf86cd799439011"),
  "mean_r": 120.5,
  "mean_g": 180.3,
  "mean_b": 90.2,
  "exg": 170.1,
  "g_std": 25.3,
  "contrast": 15.2,
  "Label": "leaf_rust",
  "created_at": ISODate("2026-06-01T10:30:00Z"),
  "image_source": "training_set_001"
}
```

**Field Description:**

| Field | Type | Range | Description |
|-------|------|-------|-------------|
| `_id` | ObjectId | - | Unique document ID |
| `mean_r` | Double | 0-255 | Mean Red channel intensity |
| `mean_g` | Double | 0-255 | Mean Green channel intensity |
| `mean_b` | Double | 0-255 | Mean Blue channel intensity |
| `exg` | Double | -510 to 510 | Excess Green Index (2*G - R - B) |
| `g_std` | Double | 0-255 | Std dev Green channel |
| `contrast` | Double | 0-∞ | GLCM texture contrast |
| `Label` | String | - | Disease class (e.g., 'leaf_rust', 'healthy') |
| `created_at` | Date | - | Document creation timestamp |
| `image_source` | String | - | Reference to training dataset |

**Indexes (Recommended):**
```javascript
// Create index untuk faster queries
db.data_ekstraksis.createIndex({ "Label": 1 })
db.data_ekstraksis.createIndex({ "created_at": 1 })
```

**Sample Data:**
```javascript
db.data_ekstraksis.insertMany([
  {
    mean_r: 118,
    mean_g: 178,
    mean_b: 88,
    exg: 168,
    g_std: 24,
    contrast: 14,
    Label: "leaf_rust"
  },
  {
    mean_r: 125,
    mean_g: 190,
    mean_b: 95,
    exg: 190,
    g_std: 18,
    contrast: 12,
    Label: "healthy"
  }
])
```

---

## Penjelasan Algoritma

### 🧮 Feature Extraction Deep Dive

#### 1. **Mean RGB (mean_r, mean_g, mean_b)**

Mengukur warna rata-rata daun di region of interest (ROI).

```python
# Pseudocode
leaf_region = extracted_leaf_pixels  # Dari mask segmentasi
mean_r = average(leaf_region[:, 0])
mean_g = average(leaf_region[:, 1])
mean_b = average(leaf_region[:, 2])
```

**Interpretasi:**
- Daun sehat: G >> R ≈ B (hijau dominan)
- Daun sakit: G < (R+B)/2 (kehilangan klorofil)

**Range Typical:**
- Healthy: R≈100, G≈150, B≈80
- Diseased: R≈130, G≈120, B≈90

#### 2. **Excess Green Index (exg)**

Indeks spektral yang sensitive terhadap vegetasi sehat.

```python
exg = 2*G - R - B
```

**Interpretasi:**
- Nilai tinggi (>150) → Daun sehat
- Nilai rendah (<100) → Daun sakit/stress

**Formula Explanation:**
- Mengamplifikasi perbedaan Green vs Red+Blue
- Robust terhadap lighting variations
- Normalisasi brightness artifacts

#### 3. **Green Channel Std Dev (g_std)**

Mengukur variabilitas dalam kanal hijau.

```python
g_channel = extract_green_pixels(leaf_region)
g_std = standard_deviation(g_channel)
```

**Interpretasi:**
- Std dev rendah (<20): Warna uniform (mungkin sakit/pucat)
- Std dev tinggi (>30): Warna bervariasi (mungkin texture penyakit)

#### 4. **GLCM Contrast**

Gray Level Co-occurrence Matrix - texture analysis.

```python
# Convert image ke grayscale
gray_img = cvtColor(image, BGR2GRAY)

# Compute GLCM (distance=5, angle=0)
glcm = graycomatrix(gray_img, distances=[5], angles=[0])

# Extract contrast feature
contrast = graycoprops(glcm, 'contrast')[0,0]
```

**Interpretasi:**
- Contrast rendah: Texture halus (penyakit halus)
- Contrast tinggi: Texture kasar (penyakit severe)

**GLCM Formula:**
```
Contrast = Σ(i-j)² * P(i,j)
```
Dimana P(i,j) adalah co-occurrence probability.

### 🤖 KNN Classification Deep Dive

#### **K-Nearest Neighbors Algorithm**

```
Input: Fitur baru [r, g, b, exg, g_std, contrast]
Output: Class prediction + probabilities

Process:
1. Normalisasi fitur baru dengan StandardScaler
   X_norm = (X - mean) / std_dev

2. Hitung jarak ke semua training points
   distance = Canberra(X_norm, X_train)
   
   Canberra Distance:
   d = Σ |xi - yi| / (|xi| + |yi|)
   
   Properties:
   - Sensitive to relative differences
   - Better for non-negative features
   - Robust to outliers

3. Find K-nearest neighbors
   k = 5 (default)
   neighbors = sorted(training_points, by=distance)[:5]

4. Weight by distance
   weight_i = 1 / distance_i
   
5. Vote dengan weighted distance
   class_votes = Σ weight_i for each class
   
6. Predict class dengan max votes
   predicted_class = argmax(class_votes)

7. Calculate probabilities
   prob_class = sum_weights_class / total_weights
```

**Example:**
```
Training Data:
  Point 1: [120, 180, 90, 170, 25, 15] → "leaf_rust"
  Point 2: [119, 182, 89, 175, 26, 16] → "leaf_rust"
  Point 3: [100, 150, 70, 150, 18, 10] → "healthy"
  Point 4: [98, 149, 71, 148, 17, 11] → "healthy"
  Point 5: [150, 120, 100, 90, 12, 8] → "powdery_mildew"

Test Point: [118, 181, 88, 172, 25, 15]

Distances (Canberra):
  → Point 1: 0.02 (weight = 50.0) ✓ "leaf_rust"
  → Point 2: 0.03 (weight = 33.3) ✓ "leaf_rust"
  → Point 3: 0.15 (weight = 6.67) ✓ "healthy"
  → Point 4: 0.16 (weight = 6.25) ✓ "healthy"
  → Point 5: 0.85 (weight = 1.18) ✗ "powdery_mildew"

Votes:
  "leaf_rust": 50.0 + 33.3 = 83.3 (wins)
  "healthy": 6.67 + 6.25 = 12.92
  "powdery_mildew": 1.18

Total: 83.3 + 12.92 + 1.18 = 97.4

Probabilities:
  "leaf_rust": 83.3 / 97.4 = 0.855 (85.5%)
  "healthy": 12.92 / 97.4 = 0.133 (13.3%)
  "powdery_mildew": 1.18 / 97.4 = 0.012 (1.2%)

Prediction: "leaf_rust" with 85.5% confidence
```

### 📸 Image Segmentation Pipeline

#### **HSV Color Space Segmentation**

Mengapa HSV lebih baik dari RGB untuk plant disease detection?

```
RGB: Sensitive to lighting changes
HSV: Decouples color (H), saturation (S), intensity (V)

Green Leaf Detection:
- Hue: 20-90° (green range dalam HSV)
- Saturation: 50-255 (menekankan warna jenuh)
- Value: 50-255 (menekankan area terang)
```

#### **CLAHE Enhancement**

Contrast Limited Adaptive Histogram Equalization

```
Purpose: Highlight small features (disease spots)

Process:
1. Convert RGB → LAB (lightness, a*, b*)
2. Apply CLAHE hanya pada channel L (lightness)
   - Divide image into grid tiles (8x8)
   - Compute histogram untuk setiap tile
   - Clip histogram pada limit (3)
   - Interpolate antar tiles untuk smooth transitions
3. Convert kembali ke RGB

Result: Enhanced contrast tanpa oversaturation
```

#### **Morphological Operations**

```
Dilation: Expand white regions
kernel = np.ones((5,5), uint8)
dilated = cv2.dilate(mask, kernel, iterations=2)

Effect: Connectedkan pixel terpisah

Erosion: Shrink white regions
eroded = cv2.erode(mask, kernel, iterations=1)

Effect: Hapus struktur kecil (noise)

Median Blur: Replace pixel dengan median neighbors
smoothed = cv2.medianBlur(mask, kernel_size=5)

Effect: Preserve edges while removing noise
```

---

## Troubleshooting

### ❌ Common Issues & Solutions

#### **Issue 1: "ModuleNotFoundError: No module named 'flask'"**

**Penyebab:** Dependencies tidak terinstall

**Solusi:**
```bash
# Ensure virtual environment aktif
source venv/bin/activate  # Linux/Mac
venv\Scripts\activate     # Windows

# Install dependencies
pip install -r requirements.txt
```

---

#### **Issue 2: "Foto tidak terdeteksi sebagai daun"**

**Penyebab:** 
- Background terlalu mirip warna daun
- Daun terlalu kecil dalam frame
- Pencahayaan buruk

**Solusi:**
- Pastikan daun >= 3.5% dari area image
- Background kontras dengan daun
- Cahaya merata tanpa shadow berat
- Crop image untuk fokus pada daun

---

#### **Issue 3: "Koneksi ke database gagal"**

**Penyebab:** MongoDB connection error

**Solusi:**
```bash
# 1. Verify MongoDB running
mongod --version  # Check if installed

# 2. Check .env credentials
# Ensure DB_HOST, DB_PORT, DB_USER, DB_PASSWORD correct

# 3. Test connection
python
>>> from pymongo import MongoClient
>>> client = MongoClient("mongodb://localhost:27017/")
>>> client.admin.command('ping')

# 4. Jika cloud MongoDB (Atlas):
# Format: mongodb+srv://user:password@cluster.mongodb.net/database

# 5. Firewall/Network issues
# Ensure port 27017 open (or custom port)
```

---

#### **Issue 4: Model prediksi tidak akurat**

**Penyebab:**
- Training data tidak cukup
- Training data imbalanced
- Fitur overlap antar class

**Solusi:**
```bash
# 1. Collect lebih banyak training data
# Target: Minimum 50 samples per class

# 2. Balance dataset
# Ensure setiap class punya sample count sama

# 3. Monitor metrics
# Compute confusion matrix

# 4. Try berbeda K value
# Dalam knn.py: ubah n_neighbors dari 5 ke 3/7

# 5. Try berbeda distance metric
# Dalam knn.py: ubah dari 'canberra' ke 'euclidean'

# 6. Normalize fitur lebih baik
# Ensure scaler.fit() dengan representative data
```

---

#### **Issue 5: Out of Memory saat processing large batch**

**Penyebab:** Terlalu banyak gambar di memory

**Solusi:**
```python
# Dalam model/ekstraktor.py atau app.py
# Process in chunks instead of all at once

batch_size = 10
for i in range(0, len(image_files), batch_size):
    batch = image_files[i:i+batch_size]
    # Process batch
    results = process_batch(batch)
```

---

#### **Issue 6: Port 5000 already in use**

**Penyebab:** Flask port sudah dipakai process lain

**Solusi:**
```bash
# Change Flask port
export FLASK_ENV=development
export FLASK_RUN_PORT=5001
flask run

# Atau force kill process
# Windows
netstat -ano | findstr :5000
taskkill /PID <PID> /F

# Linux/Mac
lsof -i :5000
kill -9 <PID>
```

---

#### **Issue 7: API Key validation gagal**

**Penyebab:** X-API-KEY header tidak sesuai

**Solusi:**
```bash
# 1. Verify .env file
cat .env | grep INTERNAL_API_KEY

# 2. Ensure request header match
# Header: X-API-KEY: <value_dari_env>
# Case sensitive!

# 3. Jika cloud deployment:
# Gunakan environment variable configuration
# Jangan hardcode API key

# 4. Rotate API key periodically untuk security
```

---

### 🔍 Debug Logging

**Enable debug mode untuk detailed logs:**

```python
# Dalam app.py
import logging

logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger(__name__)

# Dalam endpoints
logger.debug(f"Received image: {path_foto}")
logger.info(f"Prediction result: {hasil}")
logger.error(f"Error processing: {str(e)}")
```

**Run dengan debug output:**
```bash
export FLASK_ENV=development
export FLASK_DEBUG=True
flask run
```

---

## 📝 Maintenance & Best Practices

### ✅ Regular Tasks

**Daily:**
- Monitor API logs untuk errors
- Check hasil segmentasi quality

**Weekly:**
- Backup MongoDB database
- Review model accuracy metrics
- Check storage usage (hasil/ folder)

**Monthly:**
- Retrain model dengan dataset baru
- Audit API key usage
- Performance optimization review

### 🔒 Security Checklist

- ✅ Never commit `.env` file
- ✅ Rotate API keys regularly
- ✅ Use HTTPS untuk production
- ✅ Validate all input paths
- ✅ Sanitize MongoDB queries
- ✅ Rate limit API endpoints
- ✅ Use strong MongoDB authentication

### 🚀 Performance Optimization

```python
# 1. Cache model di memory
# (sudah diimplementasi dengan global variable)

# 2. Use connection pooling
# PyMongo automatically pools connections

# 3. Async processing untuk batch
from threading import Thread

def async_dataset_process(label, data_path, output_path):
    Thread(target=dataset_processor, args=(label, data_path, output_path)).start()

# 4. Image size optimization
# Resize ke 256x256 (sudah di kode)

# 5. Cache scaler & label encoder
# (sudah di cache via joblib)
```

---

## 📞 Support & Contact

Untuk pertanyaan atau issues:
1. Check documentation ini terlebih dahulu
2. Review GitHub issues
3. Contact development team

---

**End of Documentation**

Generated: 2026-06-01  
Version: 1.0  
Last Updated: 2026-06-01
