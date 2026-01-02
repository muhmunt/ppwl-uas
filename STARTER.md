# GETTING STARTED - APLIKASI MANAJEMEN KAFE

## 📋 DAFTAR ISI
1. [Persyaratan Sistem](#persyaratan-sistem)
2. [Instalasi](#instalasi)
3. [Konfigurasi](#konfigurasi)
4. [Database Setup](#database-setup)
5. [Menjalankan Aplikasi](#menjalankan-aplikasi)
6. [Struktur Project](#struktur-project)
7. [Command Reference](#command-reference)

---

## 💻 PERSYARATAN SISTEM

### **Minimum Requirements:**
- PHP >= 8.2
- Composer
- Node.js >= 18.x dan NPM
- Database: MySQL 8.0+ / PostgreSQL 13+ / SQLite 3.8.8+

### **Recommended:**
- PHP 8.3+
- MySQL 8.0+
- NPM 9.x+
- Git

---

## 🚀 INSTALASI

### **1. Clone atau Download Project**
```bash
# Jika menggunakan git
git clone <repository-url> cafe-management
cd cafe-management

# Atau jika sudah ada folder project
cd cafe-management
```

### **2. Install Dependencies PHP**
```bash
composer install
```

### **3. Install Dependencies Node.js**
```bash
npm install
```

### **4. Copy Environment File**
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### **5. Generate Application Key**
```bash
php artisan key:generate
```

---

## ⚙️ KONFIGURASI

### **1. Edit File .env**

Buka file `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="Cafe Management"
APP_ENV=local
APP_KEY=base64:... (auto-generated)
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_management
DB_USERNAME=root
DB_PASSWORD=

# Atau untuk SQLite (untuk development)
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

### **2. Buat Database**

**MySQL:**
```sql
CREATE DATABASE cafe_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**SQLite:**
```bash
# File akan dibuat otomatis di database/database.sqlite
touch database/database.sqlite
```

---

## 🗄️ DATABASE SETUP

### **1. Jalankan Migration**
```bash
php artisan migrate
```

### **2. Jalankan Seeder (Data Awal)**
```bash
php artisan db:seed
```

Seeder akan membuat:
- **Admin User:**
  - Email: admin@cafe.com
  - Password: password
  - Role: admin

- **Kasir User:**
  - Email: kasir@cafe.com
  - Password: password
  - Role: kasir

- **Sample Data:**
  - Beberapa kategori menu
  - Beberapa menu
  - Sample pesanan (optional)

### **3. Refresh Database (Jika Perlu)**
```bash
# Hapus semua data dan jalankan ulang migration + seeder
php artisan migrate:fresh --seed
```

---

## 🏃 MENJALANKAN APLIKASI

### **1. Start Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### **2. Start Vite (untuk assets)**
```bash
# Terminal baru
npm run dev
```

Atau untuk production build:
```bash
npm run build
```

### **3. Jalankan Keduanya Bersamaan**
```bash
# Windows PowerShell
Start-Process php artisan serve
Start-Process npm run dev

# Linux/Mac
php artisan serve &
npm run dev &
```

---

## 📁 STRUKTUR PROJECT

```
cafe-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php
│   │   │   ├── MenuController.php
│   │   │   ├── OrderController.php
│   │   │   └── OrderItemController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   └── KasirMiddleware.php
│   │   └── Requests/
│   │       ├── CategoryRequest.php
│   │       ├── MenuRequest.php
│   │       └── OrderRequest.php
│   └── Models/
│       ├── Category.php
│       ├── Menu.php
│       ├── Order.php
│       ├── OrderItem.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── create_categories_table.php
│   │   ├── create_menus_table.php
│   │   ├── create_orders_table.php
│   │   └── create_order_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php
│       ├── CategorySeeder.php
│       └── MenuSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── admin.blade.php
│   │   │   └── kasir.blade.php
│   │   ├── categories/
│   │   ├── menus/
│   │   ├── orders/
│   │   └── dashboard/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── auth.php
├── public/
│   └── storage/ (symlink untuk uploads)
├── storage/
│   └── app/
│       └── public/ (uploads folder)
└── .env
```

---

## 🛠️ COMMAND REFERENCE

### **Artisan Commands**

```bash
# Migration
php artisan migrate                    # Jalankan migration
php artisan migrate:fresh              # Hapus semua table dan migrate ulang
php artisan migrate:refresh            # Rollback dan migrate ulang
php artisan migrate:rollback           # Rollback migration terakhir
php artisan migrate:status             # Status migration

# Seeder
php artisan db:seed                    # Jalankan seeder
php artisan db:seed --class=AdminSeeder  # Jalankan seeder tertentu

# Model & Controller
php artisan make:model Category -m      # Buat model + migration
php artisan make:controller CategoryController --resource  # Buat resource controller
php artisan make:request CategoryRequest  # Buat form request

# Cache
php artisan cache:clear                # Clear cache
php artisan config:clear                # Clear config cache
php artisan route:clear                 # Clear route cache
php artisan view:clear                  # Clear view cache

# Storage
php artisan storage:link                # Buat symlink storage

# Queue (jika menggunakan queue)
php artisan queue:work                  # Jalankan queue worker
php artisan queue:listen                # Listen queue
```

### **NPM Commands**

```bash
npm run dev                            # Development mode (watch)
npm run build                          # Production build
npm run preview                        # Preview production build
```

---

## 🔐 DEFAULT LOGIN CREDENTIALS

Setelah menjalankan seeder, gunakan credentials berikut:

### **Admin:**
- **Email:** admin@cafe.com
- **Password:** password
- **URL:** http://localhost:8000/login

### **Kasir:**
- **Email:** kasir@cafe.com
- **Password:** password
- **URL:** http://localhost:8000/login

**⚠️ PENTING:** Ganti password default setelah pertama kali login!

---

## 📝 LANGKAH SELANJUTNYA

### **1. Setup Storage Link**
```bash
php artisan storage:link
```
Ini diperlukan untuk mengakses file yang di-upload (gambar menu/kategori).

### **2. Buat User Baru (Optional)**
```bash
php artisan tinker
```
Kemudian di tinker:
```php
User::create([
    'name' => 'Nama User',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin' // atau 'kasir'
]);
```

### **3. Jalankan Tests (Jika Ada)**
```bash
php artisan test
```

### **4. Setup IDE/Editor**
- Install Laravel IDE Helper (optional):
```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
```

---

## 🐛 TROUBLESHOOTING

### **Error: "SQLSTATE[HY000] [2002] Connection refused"**
- Pastikan database server berjalan
- Cek konfigurasi DB_HOST dan DB_PORT di .env

### **Error: "Class 'PDO' not found"**
- Install PHP PDO extension:
```bash
# Ubuntu/Debian
sudo apt-get install php-pdo php-mysql

# Windows (XAMPP/WAMP)
# Enable extension di php.ini
```

### **Error: "Storage link tidak bisa dibuat"**
- Windows: Jalankan sebagai Administrator
- Linux/Mac: Pastikan permission folder storage

### **Error: "Vite manifest not found"**
- Jalankan `npm run dev` atau `npm run build`
- Pastikan file `public/build/manifest.json` ada

### **Error: "419 Page Expired"**
- Clear cache: `php artisan cache:clear`
- Pastikan APP_KEY sudah di-generate
- Cek session driver di .env

---

## 📚 RESOURCES

- **Laravel Documentation:** https://laravel.com/docs
- **Project Plan:** [PROJECT_PLAN.md](./PROJECT_PLAN.md)
- **Flow Documentation:** [FLOW_DOCUMENTATION.md](./FLOW_DOCUMENTATION.md)

---

## 🎯 QUICK START CHECKLIST

- [ ] Install PHP 8.2+
- [ ] Install Composer
- [ ] Install Node.js & NPM
- [ ] Clone/download project
- [ ] `composer install`
- [ ] `npm install`
- [ ] Copy `.env.example` ke `.env`
- [ ] `php artisan key:generate`
- [ ] Setup database di `.env`
- [ ] `php artisan migrate`
- [ ] `php artisan db:seed`
- [ ] `php artisan storage:link`
- [ ] `php artisan serve`
- [ ] `npm run dev` (terminal baru)
- [ ] Login dengan admin@cafe.com / password

---

**Selamat Coding! 🚀**

**Last Updated:** 2025-01-02
**Version:** 1.0.0

