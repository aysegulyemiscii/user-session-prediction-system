# 🧠 Kullanıcı Oturum Tahmin Sistemi – Humanas Case Project

Bu proje, kullanıcıların login geçmişini analiz ederek **bir sonraki giriş zamanlarını tahmin eden** bir sistem sunar. Backend'de PHP, frontend'de React + Tailwind CSS kullanılmıştır.

## 🎯 Amaç

- Kullanıcıların login zaman verileri üzerinden tahmin algoritmaları geliştirmek
- Farklı algoritmalarla analiz yaparak öngörüleri karşılaştırmak
- Sonuçları kullanıcı dostu bir arayüzde sunmak

---

## 🔧 Kullanılan Teknolojiler

- **Backend:** PHP
- **Frontend:** React (Vite), Tailwind CSS
- **Veri Kaynağı:** `http://case-test-api.humanas.io/`

---

## 🧮 Kullanılan Tahmin Algoritmaları

### 1. Ortalama Giriş Aralığına Dayalı Tahmin

- Kullanıcının login zamanları arasındaki **ortalama süre** hesaplanır.
- Bu ortalama, son login zamanına eklenerek **bir sonraki tahmin edilen login zamanı** bulunur.
- **Güven Skoru:** Eğer sürelerin standart sapması düşükse (%90), değilse (%65)

### 2. En Sık Giriş Saatine Dayalı Tahmin

- Login saatleri (örneğin 08:00, 09:00...) analiz edilir.
- En sık tekrar eden saat bulunur, ve bir sonraki gün o saate göre tahmin yapılır.
- **Güven Skoru:** Saat en az 3 kez tekrar ederse %85, değilse %60

---

## 📦 Kurulum ve Çalıştırma

### 1. Backend (PHP)
cd backend
php -S localhost:8000
Tarayıcıda aç: http://localhost:8000/index.php

### 2. Frontend (PHP)
cd frontend
npm install
npm run dev

Tarayıcıda aç: http://localhost:5173

📁 Proje Yapısı
user-session-prediction-system/
├── backend/       → PHP tahmin API
├── frontend/      → React arayüz
└── README.md

👩‍💻 Geliştiren
Ayşegül 🌟
Humanas değerlendirmesi için hazırlanmıştır.