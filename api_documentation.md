# Dokumentasi REST API - Global Supply Chain Risk Intelligence

Dokumentasi ini menyajikan petunjuk lengkap penggunaan 5 endpoint REST API JSON wajib yang telah dibangun sesuai dengan spesifikasi tugas akhir (Halaman 9 PDF).

Seluruh endpoint API dapat diakses menggunakan prefix `/api` setelah alamat server lokal Anda (misal: `http://127.0.0.1:8000/api/...`).

---

## 1. Get Countries List
Mendapatkan daftar seluruh negara beserta indikator ekonomi makro dan skor risiko rantai pasok.

- **Endpoint**: `/api/countries`
- **Metode**: `GET`
- **Response Contoh (JSON)**:
  ```json
  {
    "status": "success",
    "count": 250,
    "data": [
      {
        "id": 1,
        "name": "Indonesia",
        "iso2": "ID",
        "gdp": 1371171305417,
        "inflation_rate": 2.61,
        "risk_score": 38,
        "un_member": 1,
        "independent": 1
      }
    ]
  }
  ```

---

## 2. Get Country Risk Prediction Details
Mendapatkan detail perhitungan skor risiko prediktif untuk negara tertentu berbasis pembobotan formula (Cuaca 30%, Inflasi 20%, Valas 10%, dan Berita 40%).

- **Endpoint**: `/api/risk`
- **Metode**: `GET`
- **Parameter Query (Wajib)**:
  - `country_id` (ID database negara, misal: `country_id=1`)
- **Response Contoh (JSON)**:
  ```json
  {
    "status": "success",
    "data": {
      "country": "Indonesia",
      "indicators": {
        "temperature": "28.5 °C",
        "precipitation": "0 mm",
        "wind_speed": "12 km/h",
        "inflation_rate": "2.61 %",
        "currency": "IDR",
        "news_sentiment": "Positive"
      },
      "scoring": {
        "weather_risk": "10 / 30",
        "inflation_risk": "10 / 20",
        "currency_risk": "10 / 10",
        "news_risk": "10 / 40",
        "total_risk_score": "40 / 100"
      },
      "risk_level": "Medium Risk"
    }
  }
  ```

---

## 3. Get Ports List
Mendapatkan daftar data pelabuhan dunia yang terintegrasi dengan filter pencarian dan koordinat.

- **Endpoint**: `/api/ports`
- **Metode**: `GET`
- **Parameter Query (Opsional)**:
  - `search` (Nama pelabuhan atau negara)
  - `country` (Kode negara 2 digit, misal: `country=ID`)
- **Response Contoh (JSON)**:
  ```json
  {
    "status": "success",
    "count": 13,
    "data": [
      {
        "id": 45,
        "port_name": "Kuala Tanjung",
        "country": "ID",
        "city": null,
        "latitude": "3.364400",
        "longitude": "99.444200",
        "delay_hours": 28,
        "wpi_code": "WPI-10045",
        "region": "Asia",
        "congestion": "Tinggi"
      }
    ]
  }
  ```

---

## 4. Get News Intelligence with Sentiments
Mendapatkan berita global terkini berdasarkan kategori rantai pasok lengkap dengan analisis sentimen otomatis berbasis PHP Lexicon Analyzer per artikel.

- **Endpoint**: `/api/news`
- **Metode**: `GET`
- **Parameter Query (Opsional)**:
  - `category` (Kategori: `logistics`, `trade`, `shipping`, atau `economy`. Default: `logistics`)
- **Response Contoh (JSON)**:
  ```json
  {
    "status": "success",
    "category": "logistics",
    "count": 10,
    "data": [
      {
        "title": "Vaishnaw unveils major railway freight reforms to cut costs, boost logistics",
        "description": "The Minister of Railways announced a series of reforms designed to enhance cargo movement...",
        "url": "https://example.com/news-article",
        "image": "https://example.com/image.jpg",
        "publishedAt": "2026-07-15T10:00:00Z",
        "source": {
          "name": "The Hindu"
        },
        "sentiment": "Positive"
      }
    ]
  }
  ```

---

## 5. Get Exchange Rates
Mendapatkan nilai tukar mata uang real-time bersumber dari API ExchangeRate.

- **Endpoint**: `/api/currency`
- **Metode**: `GET`
- **Parameter Query (Opsional)**:
  - `base` (Mata uang asal. Default: `USD`)
- **Response Contoh (JSON)**:
  ```json
  {
    "status": "success",
    "base": "USD",
    "rates": {
      "USD": 1,
      "IDR": 18080.3,
      "EUR": 0.875764,
      "JPY": 162.1718
    }
  }
  ```
