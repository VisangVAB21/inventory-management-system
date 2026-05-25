
# Inventory Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**Sistem manajemen stok barang berbasis web yang modern dan responsif.**  
Dirancang untuk mengelola barang masuk, barang keluar, kategori, supplier, dan manajemen user secara efisien.

[Demo](#) · [Laporan Bug](#) · [Request Fitur](#)

</div>

---

## Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur](#-fitur)
- [Tech Stack](#-tech-stack)
- [Role & Akses](#-role--akses)
- [Screenshot](#-screenshot)
- [Cara Install](#-cara-install)
- [Konfigurasi](#-konfigurasi)
- [Struktur Folder](#-struktur-folder)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## Tentang Project

**Inventory Management System** adalah aplikasi web berbasis Laravel yang dirancang untuk mempermudah pengelolaan stok barang di gudang atau toko. Sistem ini mendukung multi-role user, pencatatan aktivitas, laporan stok, serta manajemen supplier dan kategori produk.

> Dibangun dengan prinsip clean code, UI dark, dan alur kerja yang terstruktur berdasarkan role.

---

## Fitur

### Autentikasi
- Login & Register dengan validasi
- Manajemen session yang aman
- Role-based access control (Admin, Manajer Gudang, Staff)

### Manajemen Barang
- CRUD produk lengkap (nama, harga beli, harga jual, stok, gambar)
- Atribut produk: merk, warna, ukuran
- Indikator stok menipis
- Stock opname

### Master Data
- CRUD Kategori produk
- CRUD Supplier

### Transaksi Stok
- Pencatatan **Barang Masuk** (stock in) dengan supplier
- Pencatatan **Barang Keluar** (stock out)
- History transaksi lengkap
- Status pengecekan barang (pending → checked/prepared)

### Laporan
- Laporan stok saat ini
- Laporan barang masuk & keluar per periode
- Laporan stok menipis
- Rekap transaksi
- Export **PDF** & **Excel**

### Manajemen User *(Admin only)*
- CRUD user
- Assignment role

### Pengaturan *(Admin only)*
- Nama & deskripsi aplikasi
- Upload logo & favicon
- Informasi kontak
- Sosial media

### Activity Log
- Pencatatan semua aktivitas user
- Filter & pencarian log
- Badge warna berdasarkan jenis aksi

---

## Tech Stack

| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| [Laravel](https://laravel.com) | 10.x | Backend Framework |
| [PHP](https://php.net) | 8.2 | Server-side Language |
| [MySQL](https://mysql.com) | 8.0 | Database |
| [Tailwind CSS](https://tailwindcss.com) | 3.x | Styling |
| [Vite](https://vitejs.dev) | 4.x | Asset Bundler |
| [SweetAlert2](https://sweetalert2.github.io) | 11.x | Notifikasi UI |
| [Chart.js](https://chartjs.org) | 4.x | Grafik Dashboard |
| [DomPDF](https://github.com/barryvdh/laravel-dompdf) | — | Export PDF |
| [Font Awesome](https://fontawesome.com) | 6.x | Icon Library |

---

## Role & Akses

| Fitur | Admin | Manajer | Staff |
|-------|:-----:|:-------:|:-----:|
| Dashboard | ✅ | ✅ | ✅ |
| CRUD Produk | ✅ | ✅ | ❌ |
| CRUD Kategori | ✅ | ✅ | ❌ |
| CRUD Supplier | ✅ | ✅ | ❌ |
| Barang Masuk / Keluar | ✅ | ✅ | ✅ |
| Stock Opname | ❌ | ✅ | ✅ |
| Laporan | ✅ | ✅ | ❌ |
| Kelola User | ✅ | ❌ | ❌ |
| Pengaturan | ✅ | ❌ | ❌ |
| Activity Log | ✅ | ✅ | ❌ |

---

>
## Screenshot

### Dashboard Admin
![Dashboard Admin](docs/screenshots/dashboard-admin.png)

### Dashboard Manajer
![Dashboard Manajer](docs/screenshots/dashboard-manajer.png)

### Dashboard Staff
![Dashboard Staff](docs/screenshots/dashboard-staff.png)

### Manajemen Produk
![Products](docs/screenshots/product.png)

### Barang Masuk
![Stock In](docs/screenshots/stock-in.png)

### Laporan
![Reports](docs/screenshots/Reports.png)

### Pengaturan
![Settings](docs/screenshots/Settings.png)
```

screenshots/
├── dashboard-admin.png
├── dashboard-manager.png
├── dashboard-staff.png
├── products.png
├── stock-in.png
├── reports.png
└── settings.png
```

---

## Cara Install

### Prasyarat

Pastikan environment kamu sudah memenuhi persyaratan berikut:

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL >= 8.0
- XAMPP / Laragon / Herd *(opsional)*

---

### Langkah Instalasi

**1. Clone repository**

```bash
git clone https://github.com/username/inventory-management-system.git
cd inventory-management-system
```

**2. Install dependency PHP**

```bash
composer install
```

**3. Install dependency Node.js**

```bash
npm install
```

**4. Salin file environment**

```bash
cp .env.example .env
```

**5. Generate application key**

```bash
php artisan key:generate
```

**6. Konfigurasi database**

Buka file `.env` dan sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockify_db
DB_USERNAME=root
DB_PASSWORD=
```

**7. Jalankan migrasi & seeder**

```bash
php artisan migrate --seed
```

**8. Buat symlink storage**

```bash
php artisan storage:link
```

**9. Build assets**

```bash
npm run build
# atau untuk development
npm run dev
```

**10. Jalankan server**

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

### Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gmail.com | password |
| Manajer | manager@gmail.com | password |
| Staff | staff@gmail.com | password |

---

## Konfigurasi

### Environment Variables Penting

```env
APP_NAME=Stockify
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockify_db

# Mail (opsional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_password

# Filesystem
FILESYSTEM_DISK=public
```

### Compile Assets

```bash
# Development (watch mode)
npm run dev

# Production build
npm run build
```

---

## Struktur Folder

```
inventory-management-system/
├── app/
│   ├── Exports/                  # Excel exports
│   │   └── ReportExport.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       │   └── SettingController.php
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       ├── CategoryController.php
│   │       ├── SupplierController.php
│   │       ├── StockInController.php
│   │       ├── StockOutController.php
│   │       ├── ReportController.php
│   │       ├── UserController.php
│   │       └── ActivityLogController.php
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Supplier.php
│   │   ├── StockIn.php
│   │   ├── StockOut.php
│   │   ├── ActivityLog.php
│   │   └── Setting.php
│   └── helpers/
│       └── activity.php          # Helper activity log
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     # Layout utama
│       ├── dashboard.blade.php
│       ├── products/
│       ├── categories/
│       ├── suppliers/
│       ├── stock_in/
│       ├── stock_out/
│       ├── reports/
│       ├── users/
│       ├── activity/
│       └── admin/
│           └── settings/
├── routes/
│   └── web.php
├── public/
│   └── storage/                  # Symlink uploaded files
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## Kontribusi

Kontribusi sangat diterima! Ikuti langkah berikut:

1. **Fork** repository ini
2. Buat branch fitur baru
   ```bash
   git checkout -b feature/nama-fitur
   ```
3. Commit perubahan
   ```bash
   git commit -m "feat: tambah fitur nama-fitur"
   ```
4. Push ke branch
   ```bash
   git push origin feature/nama-fitur
   ```
5. Buat **Pull Request**

### Konvensi Commit

| Prefix | Kegunaan |
|--------|----------|
| `feat:` | Fitur baru |
| `fix:` | Bug fix |
| `refactor:` | Refaktor kode |
| `docs:` | Update dokumentasi |
| `style:` | Perubahan styling |

---

## Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

## Developer

<div align="center">

**Dibuat dengan menggunakan Laravel & Tailwind CSS**

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/VisangVAB21)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/visang-arya-bangga-26513a3b5/)

</div>
