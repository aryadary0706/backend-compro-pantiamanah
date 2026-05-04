# Backend API - Compro Panti Amanah

Ini adalah repository backend untuk aplikasi Company Profile Panti Asuhan Amanah. Backend ini dibangun menggunakan **Laravel 12** dan menyediakan RESTful API untuk dikonsumsi oleh aplikasi frontend.

## Persyaratan Sistem (Prerequisites)

Sebelum memulai, pastikan sistem Anda memiliki instalasi berikut:
- **PHP** >= 8.2
- **Composer** (untuk manajemen dependensi PHP)
- **Git**

## Panduan Instalasi (Setup)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

1. **Clone Repository**
   ```bash
   git clone <url-repo-ini>
   cd backend-compro-pantiamanah
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   > **Catatan untuk Frontend Dev:** Secara default, project ini menggunakan database `sqlite` agar mudah dijalankan tanpa perlu setup aplikasi database terpisah seperti MySQL.

4. **Generate Application Key & JWT Secret**
   Jalankan perintah ini untuk membuat *encryption key* Laravel dan *secret key* untuk token JWT (autentikasi).
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

5. **Migrasi Database dan Data Awal (Seeder)**
   Jalankan perintah berikut untuk membuat file sqlite (jika belum ada), membuat struktur tabel di database, dan mengisi data awal (dummy data) agar API siap digunakan:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Link Storage (Untuk Upload Gambar)**
   Agar file/gambar yang diupload via CMS (seperti QRIS atau Galeri) bisa diakses oleh frontend melalui URL publik, jalankan:
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Backend sekarang berjalan di `http://127.0.0.1:8000`. Gunakan base URL ini (yakni `http://127.0.0.1:8000/api`) di aplikasi React / frontend Anda.

---

## Autentikasi (Authentication)

Aplikasi ini menggunakan **JWT (JSON Web Token)** untuk autentikasi dan memproteksi endpoint admin.

- **Login**: Lakukan `POST /api/login` dengan mengirimkan field `email` dan `password`. Response sukses akan mengembalikan `access_token`.
- **Bearer Token**: Untuk mengakses API yang terproteksi (CMS), Anda harus menyertakan token tersebut di HTTP Headers pada setiap request:
  ```http
  Authorization: Bearer <access_token_anda>
  ```

---

## Daftar API Endpoints

Berikut adalah daftar endpoint yang tersedia di aplikasi ini.

### 🔓 Public Endpoints (Tanpa Token)
Digunakan untuk halaman publik / *landing page*.

| Method | Endpoint | Deskripsi |
| --- | --- | --- |
| `POST` | `/api/login` | Melakukan login untuk mendapatkan Token. |
| `GET` | `/api/profile` | Mengambil data profil dan identitas Panti Asuhan. |
| `GET` | `/api/anak-asuh` | Mengambil daftar anak asuh. |
| `GET` | `/api/locations` | Mengambil data lokasi panti. |
| `GET` | `/api/programs` | Mengambil daftar program kegiatan. |
| `GET` | `/api/bank-accounts` | Mengambil daftar rekening bank panti. |
| `GET` | `/api/donasi` | Mengambil data kebutuhan donasi. |
| `GET` | `/api/galleries` | Mengambil data foto galeri panti. |
| `GET` | `/api/donation-form` | Mengambil data riwayat donasi yang masuk. |
| `POST` | `/api/donation-form` | Endpoint untuk user mensubmit form donasi. |
| `POST` | `/api/donation-form/{id}`| Menampilkan detail form donasi yang spesifik berdasarkan ID. |

### 🔒 Protected Endpoints (Butuh Token JWT)
Endpoint di bawah ini digunakan untuk *dashboard admin (CMS)* dan wajib menyertakan token di Header.

#### Auth & Profil User
| Method | Endpoint | Deskripsi |
| --- | --- | --- |
| `POST` | `/api/logout` | Logout dan menonaktifkan token saat ini. |
| `POST` | `/api/refresh`| Memperbarui (refresh) token JWT. |
| `GET`  | `/api/me`     | Mendapatkan data user admin yang sedang login. |

#### Data Panti (Profile)
| Method | Endpoint | Deskripsi |
| --- | --- | --- |
| `PUT`  | `/api/profile` | Update identitas Panti Asuhan. |
| `POST` | `/api/profile/qris` | Mengunggah gambar QRIS. |

#### Data Master (CRUD)
Berikut rute untuk menambah (`POST`), mengubah (`PUT`), dan menghapus (`DELETE`) data:

- **Anak Asuh:** `/api/anak-asuh` (POST) \| `/api/anak-asuh/{id}` (PUT, DELETE)
- **Lokasi Panti:** `/api/locations` (POST) \| `/api/locations/{id}` (PUT, DELETE)
- **Program Panti:** `/api/programs` (POST) \| `/api/programs/{id}` (PUT, DELETE)
- **Rekening Bank:** `/api/bank-accounts` (POST) \| `/api/bank-accounts/{id}` (PUT, DELETE)
- **Donasi (Kebutuhan):** `/api/donasi` (POST) \| `/api/donasi/{id}` (DELETE)
- **Galeri Foto:** `/api/galleries` (POST) \| `/api/galleries/{id}` (DELETE)

---

## Catatan Tambahan (FAQ)
- **Format Response**: Backend mengembalikan response dalam format `JSON`.
- **Error Handling**: Jika ada *error* atau validasi yang gagal (misal kolom mandatory kosong), API akan merespon dengan status code **422 (Unprocessable Entity)** beserta detail message error di dalamnya. Jika akses ditolak karena token, responsnya adalah **401 (Unauthorized)**.
- **Akses Gambar**: Jika endpoint mengembalikan direktori file/gambar, tambahkan base URL di depannya agar tampil di web. (contoh jika API mereturn `storage/galeri/foto.jpg`, URL lengkapnya adalah `http://127.0.0.1:8000/storage/galeri/foto.jpg`).
- **CORS**: Jika terjadi masalah CORS saat integrasi awal dengan frontend lokal (seperti `localhost:5173` atau `localhost:3000`), silakan periksa dan sesuaikan file konfigurasi CORS Laravel di sisi backend.
