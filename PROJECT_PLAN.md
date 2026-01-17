# PROJECT PLAN - APLIKASI MANAJEMEN KAFE

## 📋 DAFTAR ISI
1. [Overview](#overview)
2. [Fitur Utama](#fitur-utama)
3. [Struktur Modul](#struktur-modul)
4. [Role dan Permission](#role-dan-permission)
5. [Database Schema](#database-schema)
6. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
7. [Timeline Pengembangan](#timeline-pengembangan)

---

## 🎯 OVERVIEW

Aplikasi Manajemen Kafe adalah sistem berbasis web yang dibangun dengan Laravel untuk mengelola operasional kafe, termasuk manajemen menu, kategori, dan pemesanan. Aplikasi ini dirancang untuk memudahkan admin dan kasir dalam mengelola bisnis kafe secara efisien.

### Tujuan
- Memudahkan manajemen menu dan kategori
- Meningkatkan efisiensi proses pemesanan
- Memberikan laporan transaksi yang akurat
- Meningkatkan pengalaman pengguna (admin dan kasir)

---

## 🚀 FITUR UTAMA

### 1. **Modul Kategori Menu**
- ✅ CRUD (Create, Read, Update, Delete) kategori menu
- ✅ Validasi input kategori
- ✅ Soft delete untuk kategori
- ✅ Filter dan pencarian kategori
- ✅ Urutan kategori (sorting)

### 2. **Modul Menu**
- ✅ CRUD menu lengkap
- ✅ Upload gambar menu
- ✅ Relasi dengan kategori
- ✅ Status menu (tersedia/tidak tersedia)
- ✅ Harga dan deskripsi menu
- ✅ Filter berdasarkan kategori
- ✅ Pencarian menu

### 3. **Modul Pemesanan**
- ✅ Membuat pesanan baru
- ✅ Menambahkan item ke pesanan
- ✅ Update jumlah item
- ✅ Hapus item dari pesanan
- ✅ Status pesanan (pending, processing, completed, cancelled)
- ✅ Total harga otomatis
- ✅ Riwayat pesanan
- ✅ Filter pesanan berdasarkan status dan tanggal
- ✅ Print struk pesanan

---

## 📦 STRUKTUR MODUL

### **1. Modul Kategori Menu**

#### **Model: Category**
```php
- id (primary key)
- name (string, required, unique)
- description (text, nullable)
- image (string, nullable)
- is_active (boolean, default: true)
- sort_order (integer, default: 0)
- created_at, updated_at, deleted_at
```

#### **Controller: CategoryController**
- `index()` - Menampilkan daftar kategori
- `create()` - Form tambah kategori
- `store()` - Simpan kategori baru
- `show($id)` - Detail kategori
- `edit($id)` - Form edit kategori
- `update($id)` - Update kategori
- `destroy($id)` - Hapus kategori (soft delete)

#### **Routes:**
```php
GET    /categories           - Daftar kategori
GET    /categories/create   - Form tambah
POST   /categories           - Simpan kategori
GET    /categories/{id}      - Detail kategori
GET    /categories/{id}/edit - Form edit
PUT    /categories/{id}      - Update kategori
DELETE /categories/{id}      - Hapus kategori
```

---

### **2. Modul Menu**

#### **Model: Menu**
```php
- id (primary key)
- category_id (foreign key -> categories)
- name (string, required)
- description (text, nullable)
- price (decimal, required)
- image (string, nullable)
- is_available (boolean, default: true)
- stock (integer, nullable)
- created_at, updated_at, deleted_at
```

#### **Controller: MenuController**
- `index()` - Daftar menu dengan filter
- `create()` - Form tambah menu
- `store()` - Simpan menu baru
- `show($id)` - Detail menu
- `edit($id)` - Form edit menu
- `update($id)` - Update menu
- `destroy($id)` - Hapus menu (soft delete)
- `toggleAvailability($id)` - Toggle status ketersediaan

#### **Routes:**
```php
GET    /menus                - Daftar menu
GET    /menus/create         - Form tambah
POST   /menus                - Simpan menu
GET    /menus/{id}           - Detail menu
GET    /menus/{id}/edit      - Form edit
PUT    /menus/{id}           - Update menu
DELETE /menus/{id}           - Hapus menu
POST   /menus/{id}/toggle    - Toggle ketersediaan
```

---

### **3. Modul Pemesanan**

#### **Model: Order**
```php
- id (primary key)
- order_number (string, unique)
- user_id (foreign key -> users) // kasir yang membuat
- customer_name (string, nullable)
- table_number (string, nullable)
- status (enum: pending, processing, completed, cancelled)
- total_price (decimal)
- notes (text, nullable)
- created_at, updated_at
```

#### **Model: OrderItem**
```php
- id (primary key)
- order_id (foreign key -> orders)
- menu_id (foreign key -> menus)
- quantity (integer, required)
- price (decimal) // harga saat pemesanan
- subtotal (decimal) // quantity * price
- notes (text, nullable)
- created_at, updated_at
```

#### **Controller: OrderController**
- `index()` - Daftar pesanan dengan filter
- `create()` - Form pesanan baru
- `store()` - Simpan pesanan
- `show($id)` - Detail pesanan
- `edit($id)` - Form edit pesanan
- `update($id)` - Update pesanan
- `destroy($id)` - Hapus pesanan
- `updateStatus($id)` - Update status pesanan
- `print($id)` - Print struk pesanan

#### **Controller: OrderItemController**
- `store()` - Tambah item ke pesanan
- `update($id)` - Update item pesanan
- `destroy($id)` - Hapus item dari pesanan

#### **Routes:**
```php
GET    /orders               - Daftar pesanan
GET    /orders/create        - Form pesanan baru
POST   /orders               - Simpan pesanan
GET    /orders/{id}          - Detail pesanan
GET    /orders/{id}/edit     - Form edit
PUT    /orders/{id}          - Update pesanan
DELETE /orders/{id}          - Hapus pesanan
POST   /orders/{id}/status   - Update status
GET    /orders/{id}/print    - Print struk

POST   /order-items          - Tambah item
PUT    /order-items/{id}     - Update item
DELETE /order-items/{id}     - Hapus item
```

---

## 👥 ROLE DAN PERMISSION

### **1. Admin**
**Akses Penuh:**
- ✅ Manajemen kategori menu (CRUD)
- ✅ Manajemen menu (CRUD)
- ✅ Manajemen pesanan (CRUD)
- ✅ Manajemen user/kasir
- ✅ Laporan dan statistik
- ✅ Pengaturan sistem
- ✅ Update status pesanan
- ✅ Hapus pesanan

**Dashboard Admin:**
- Statistik penjualan hari ini
- Grafik penjualan (mingguan/bulanan)
- Daftar pesanan terbaru
- Menu terlaris
- Total pendapatan

---

### **2. Kasir**
**Akses Terbatas:**
- ✅ Lihat kategori menu (read only)
- ✅ Lihat menu (read only)
- ✅ Membuat pesanan baru
- ✅ Update pesanan yang dibuat sendiri
- ✅ Update status pesanan (pending → processing → completed)
- ❌ Tidak bisa hapus pesanan
- ❌ Tidak bisa edit/hapus menu
- ❌ Tidak bisa edit/hapus kategori
- ❌ Tidak bisa akses manajemen user

**Dashboard Kasir:**
- Daftar pesanan hari ini
- Form quick order
- Status pesanan aktif
- Total penjualan hari ini (hanya yang dibuat sendiri)

---

## 🗄️ DATABASE SCHEMA

### **Tabel: users**
```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string)
- role (enum: 'admin', 'kasir', default: 'kasir')
- is_active (boolean, default: true)
- created_at, updated_at
```

### **Tabel: categories**
```sql
- id (bigint, primary key)
- name (string, unique)
- description (text, nullable)
- image (string, nullable)
- is_active (boolean, default: true)
- sort_order (integer, default: 0)
- created_at, updated_at
- deleted_at (timestamp, nullable) // soft delete
```

### **Tabel: menus**
```sql
- id (bigint, primary key)
- category_id (bigint, foreign key)
- name (string)
- description (text, nullable)
- price (decimal(10,2))
- image (string, nullable)
- is_available (boolean, default: true)
- stock (integer, nullable)
- created_at, updated_at
- deleted_at (timestamp, nullable) // soft delete
```

### **Tabel: orders**
```sql
- id (bigint, primary key)
- order_number (string, unique)
- user_id (bigint, foreign key -> users)
- customer_name (string, nullable)
- table_number (string, nullable)
- status (enum: 'pending', 'processing', 'completed', 'cancelled')
- total_price (decimal(10,2))
- notes (text, nullable)
- created_at, updated_at
```

### **Tabel: order_items**
```sql
- id (bigint, primary key)
- order_id (bigint, foreign key -> orders)
- menu_id (bigint, foreign key -> menus)
- quantity (integer)
- price (decimal(10,2))
- subtotal (decimal(10,2))
- notes (text, nullable)
- created_at, updated_at
```

---

## 🛠️ TEKNOLOGI YANG DIGUNAKAN

### **Backend:**
- Laravel 12.x
- PHP 8.2+
- MySQL/PostgreSQL/SQLite

### **Frontend:**
- Blade Templates
- Tailwind CSS / Bootstrap
- JavaScript (Vanilla atau Alpine.js)
- Font Awesome / Heroicons

### **Libraries & Packages:**
- Laravel Breeze (Authentication)
- Intervention Image (Image handling)
- DomPDF / Barryvdh Laravel-Dompdf (PDF generation)

---

## 📅 TIMELINE PENGEMBANGAN

### **Phase 1: Setup & Authentication (Week 1)**
- [ ] Setup Laravel project
- [ ] Install Laravel Breeze
- [ ] Setup database
- [ ] Implement role-based authentication
- [ ] Create middleware untuk role
- [ ] Setup layout dan navigation

### **Phase 2: Modul Kategori (Week 1-2)**
- [ ] Migration dan Model Category
- [ ] CategoryController
- [ ] Views untuk kategori (index, create, edit)
- [ ] Validasi form
- [ ] Upload gambar kategori
- [ ] Soft delete
- [ ] Testing

### **Phase 3: Modul Menu (Week 2-3)**
- [ ] Migration dan Model Menu
- [ ] MenuController
- [ ] Views untuk menu (index, create, edit)
- [ ] Relasi dengan kategori
- [ ] Upload gambar menu
- [ ] Filter dan search
- [ ] Toggle availability
- [ ] Testing

### **Phase 4: Modul Pemesanan (Week 3-4)**
- [ ] Migration Order dan OrderItem
- [ ] OrderController dan OrderItemController
- [ ] Views untuk pemesanan
- [ ] Logic perhitungan total
- [ ] Update status pesanan
- [ ] Print struk
- [ ] Filter dan search pesanan
- [ ] Testing

### **Phase 5: Dashboard & Laporan (Week 4-5)**
- [ ] Dashboard Admin
- [ ] Dashboard Kasir
- [ ] Statistik penjualan
- [ ] Grafik penjualan
- [ ] Laporan harian/bulanan
- [ ] Testing

### **Phase 6: Polish & Deployment (Week 5-6)**
- [ ] UI/UX improvements
- [ ] Responsive design
- [ ] Error handling
- [ ] Security audit
- [ ] Performance optimization
- [ ] Documentation
- [ ] Deployment

---

## 📝 CATATAN PENTING

1. **Security:**
   - Validasi semua input
   - CSRF protection
   - XSS protection
   - SQL injection prevention (gunakan Eloquent)
   - Authorization checks di setiap action

2. **Best Practices:**
   - Gunakan Form Request untuk validasi
   - Service classes untuk business logic
   - Repository pattern (optional)
   - Event & Listeners untuk logging
   - Queue untuk heavy operations

3. **Testing:**
   - Unit tests untuk models
   - Feature tests untuk controllers
   - Browser tests untuk critical flows

---

## 🎨 UI/UX CONSIDERATIONS

- **Color Scheme:** Warm colors (brown, cream, coffee tones)
- **Typography:** Clean, readable fonts
- **Icons:** Consistent icon set
- **Responsive:** Mobile-friendly design
- **Accessibility:** WCAG compliance
- **Loading States:** Show loading indicators
- **Error Messages:** User-friendly error messages
- **Success Messages:** Confirmation messages

---

## 📚 DOKUMENTASI TAMBAHAN

- [FLOW_DOCUMENTATION.md](./FLOW_DOCUMENTATION.md) - Dokumentasi alur aplikasi
- [STARTER.md](./STARTER.md) - Panduan memulai project
- [API_DOCUMENTATION.md](./API_DOCUMENTATION.md) - Dokumentasi API (jika diperlukan)

---

**Last Updated:** 2025-01-02
**Version:** 1.0.0


