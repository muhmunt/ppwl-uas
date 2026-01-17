# FLOW DOCUMENTATION - APLIKASI MANAJEMEN KAFE

## 📋 DAFTAR ISI
1. [Authentication Flow](#authentication-flow)
2. [Kategori Menu Flow](#kategori-menu-flow)
3. [Menu Flow](#menu-flow)
4. [Pemesanan Flow](#pemesanan-flow)
5. [Dashboard Flow](#dashboard-flow)

---

## 🔐 AUTHENTICATION FLOW

### **Login Flow**
```
1. User mengakses halaman login (/login)
2. User memasukkan email dan password
3. Sistem validasi input
4. Sistem cek credentials di database
5. Jika valid:
   - Generate session
   - Redirect berdasarkan role:
     * Admin → /admin/dashboard
     * Kasir → /kasir/dashboard
6. Jika tidak valid:
   - Tampilkan error message
   - Kembali ke halaman login
```

### **Logout Flow**
```
1. User klik tombol logout
2. Sistem destroy session
3. Redirect ke halaman login
```

### **Middleware Flow**
```
Request → Authenticate Middleware → Role Middleware → Controller
         (cek login)              (cek role)
```

---

## 📁 KATEGORI MENU FLOW

### **Admin: Tambah Kategori**
```
1. Admin login → Dashboard Admin
2. Klik menu "Kategori" → /categories
3. Klik tombol "Tambah Kategori" → /categories/create
4. Isi form:
   - Nama kategori (required)
   - Deskripsi (optional)
   - Upload gambar (optional)
   - Status aktif (checkbox)
5. Klik "Simpan"
6. Validasi:
   - Nama harus unique
   - Nama tidak boleh kosong
7. Jika valid:
   - Simpan ke database
   - Upload gambar (jika ada)
   - Redirect ke /categories dengan success message
8. Jika tidak valid:
   - Tampilkan error messages
   - Kembali ke form dengan data yang sudah diisi
```

### **Admin: Edit Kategori**
```
1. Admin di halaman /categories
2. Klik tombol "Edit" pada kategori tertentu → /categories/{id}/edit
3. Form terisi dengan data kategori
4. Edit data yang diperlukan
5. Klik "Update"
6. Validasi (sama seperti tambah)
7. Jika valid:
   - Update database
   - Update gambar (jika diubah)
   - Redirect ke /categories dengan success message
8. Jika tidak valid:
   - Tampilkan error messages
```

### **Admin: Hapus Kategori**
```
1. Admin di halaman /categories
2. Klik tombol "Hapus" pada kategori tertentu
3. Konfirmasi dialog muncul
4. Jika konfirmasi:
   - Soft delete kategori (deleted_at diisi)
   - Cek apakah ada menu yang menggunakan kategori ini
   - Jika ada menu:
     * Tampilkan warning
     * Tidak bisa hapus (atau hapus menu juga)
   - Jika tidak ada menu:
     * Hapus kategori
     * Redirect dengan success message
5. Jika batal:
   - Tutup dialog
```

### **Kasir: Lihat Kategori**
```
1. Kasir login → Dashboard Kasir
2. Klik menu "Kategori" → /categories
3. Tampilkan daftar kategori (read-only)
4. Tidak ada tombol edit/hapus
```

---

## 🍽️ MENU FLOW

### **Admin: Tambah Menu**
```
1. Admin login → Dashboard Admin
2. Klik menu "Menu" → /menus
3. Klik tombol "Tambah Menu" → /menus/create
4. Isi form:
   - Nama menu (required)
   - Kategori (dropdown, required)
   - Deskripsi (optional)
   - Harga (required, numeric)
   - Upload gambar (optional)
   - Stok (optional, integer)
   - Status tersedia (checkbox)
5. Klik "Simpan"
6. Validasi:
   - Nama tidak boleh kosong
   - Kategori harus dipilih
   - Harga harus numeric dan > 0
   - Stok harus integer (jika diisi)
7. Jika valid:
   - Simpan ke database
   - Upload gambar
   - Redirect ke /menus dengan success message
8. Jika tidak valid:
   - Tampilkan error messages
```

### **Admin: Edit Menu**
```
1. Admin di halaman /menus
2. Klik tombol "Edit" → /menus/{id}/edit
3. Form terisi dengan data menu
4. Edit data
5. Klik "Update"
6. Validasi dan proses (sama seperti tambah)
```

### **Admin: Toggle Ketersediaan Menu**
```
1. Admin di halaman /menus
2. Klik toggle switch "Tersedia/Tidak Tersedia"
3. AJAX request ke /menus/{id}/toggle
4. Update is_available di database
5. Response JSON dengan status baru
6. Update UI tanpa reload
```

### **Admin: Hapus Menu**
```
1. Admin di halaman /menus
2. Klik tombol "Hapus"
3. Konfirmasi dialog
4. Jika konfirmasi:
   - Soft delete menu
   - Cek apakah ada di pesanan aktif
   - Jika ada:
     * Tampilkan warning
     * Tidak bisa hapus
   - Jika tidak ada:
     * Hapus menu
     * Redirect dengan success message
```

### **Kasir: Lihat Menu**
```
1. Kasir di halaman /menus
2. Tampilkan daftar menu dengan:
   - Filter berdasarkan kategori
   - Search nama menu
   - Hanya menu yang tersedia (is_available = true)
3. Tidak ada tombol edit/hapus
```

---

## 🛒 PEMESANAN FLOW

### **Kasir: Buat Pesanan Baru**
```
1. Kasir login → Dashboard Kasir
2. Klik "Pesanan Baru" → /orders/create
3. Form pesanan:
   - Nomor meja (optional)
   - Nama customer (optional)
   - Catatan (optional)
4. Tambah item menu:
   - Pilih kategori (filter menu)
   - Pilih menu dari list
   - Input jumlah
   - Klik "Tambah ke Pesanan"
   - Item muncul di cart
5. Di cart:
   - Lihat daftar item
   - Edit jumlah item
   - Hapus item
   - Lihat subtotal per item
   - Lihat total keseluruhan
6. Klik "Buat Pesanan"
7. Validasi:
   - Minimal 1 item
   - Semua item harus valid
8. Jika valid:
   - Generate order_number (format: ORD-YYYYMMDD-XXXX)
   - Simpan order ke database
   - Simpan order_items ke database
   - Update stok menu (jika ada)
   - Redirect ke /orders/{id} dengan success message
9. Jika tidak valid:
   - Tampilkan error messages
```

### **Kasir: Update Status Pesanan**
```
1. Kasir di halaman detail pesanan /orders/{id}
2. Status saat ini: "Pending"
3. Klik tombol "Proses Pesanan"
4. Update status menjadi "Processing"
5. Redirect dengan success message

6. Setelah selesai, klik "Selesai"
7. Update status menjadi "Completed"
8. Redirect dengan success message
```

### **Admin: Lihat Semua Pesanan**
```
1. Admin di halaman /orders
2. Filter:
   - Status (pending, processing, completed, cancelled)
   - Tanggal (hari ini, minggu ini, bulan ini)
   - Kasir (user yang membuat)
3. Tampilkan:
   - Order number
   - Tanggal
   - Customer/Meja
   - Status
   - Total
   - Kasir
   - Actions (view, edit, delete)
```

### **Admin/Kasir: Detail Pesanan**
```
1. Klik "Lihat" pada pesanan → /orders/{id}
2. Tampilkan:
   - Informasi pesanan (order number, tanggal, status)
   - Informasi customer/meja
   - Daftar item pesanan:
     * Nama menu
     * Jumlah
     * Harga satuan
     * Subtotal
   - Total pesanan
   - Catatan
   - Tombol actions:
     * Edit (jika status pending)
     * Update status
     * Print struk
     * Hapus (hanya admin, jika status pending)
```

### **Print Struk Pesanan**
```
1. Di halaman detail pesanan /orders/{id}
2. Klik "Print Struk"
3. Generate PDF dengan:
   - Header (nama kafe, alamat, telepon)
   - Order number dan tanggal
   - Informasi customer/meja
   - Daftar item dengan harga
   - Subtotal
   - Pajak (jika ada)
   - Total
   - Footer (terima kasih)
4. Download atau print PDF
```

### **Edit Pesanan (Hanya Status Pending)**
```
1. Di halaman detail pesanan /orders/{id}
2. Jika status = "pending":
   - Tampilkan tombol "Edit Pesanan"
3. Klik "Edit Pesanan" → /orders/{id}/edit
4. Form edit:
   - Edit customer/meja/catatan
   - Tambah item baru
   - Edit jumlah item
   - Hapus item
5. Klik "Update Pesanan"
6. Recalculate total
7. Update database
8. Redirect ke detail pesanan
```

### **Hapus Pesanan (Hanya Admin, Status Pending)**
```
1. Admin di halaman detail pesanan
2. Jika status = "pending":
   - Tampilkan tombol "Hapus Pesanan"
3. Klik "Hapus Pesanan"
4. Konfirmasi dialog
5. Jika konfirmasi:
   - Hapus order_items
   - Hapus order
   - Restore stok menu (jika sudah dikurangi)
   - Redirect ke /orders dengan success message
```

---

## 📊 DASHBOARD FLOW

### **Admin Dashboard**
```
1. Admin login → /admin/dashboard
2. Tampilkan:
   - Statistik hari ini:
     * Total pesanan
     * Total pendapatan
     * Menu terlaris
   - Grafik penjualan (7 hari terakhir)
   - Daftar pesanan terbaru (10 terakhir)
   - Quick actions:
     * Buat pesanan baru
     * Tambah menu
     * Tambah kategori
3. Klik menu navigasi:
   - Kategori → /categories
   - Menu → /menus
   - Pesanan → /orders
   - Laporan → /reports
   - Users → /users (hanya admin)
```

### **Kasir Dashboard**
```
1. Kasir login → /kasir/dashboard
2. Tampilkan:
   - Pesanan hari ini (yang dibuat sendiri)
   - Total penjualan hari ini
   - Status pesanan aktif:
     * Pending
     * Processing
   - Quick action:
     * Buat pesanan baru
3. Klik menu navigasi:
   - Menu → /menus (read-only)
   - Kategori → /categories (read-only)
   - Pesanan → /orders (hanya yang dibuat sendiri)
```

---

## 🔄 STATE MANAGEMENT

### **Status Pesanan**
```
pending → processing → completed
   ↓
cancelled (hanya admin)
```

**Rules:**
- Hanya bisa edit jika status = "pending"
- Hanya bisa hapus jika status = "pending"
- Status "completed" tidak bisa diubah
- Status "cancelled" tidak bisa diubah

### **Status Menu**
```
is_available = true  → Menu bisa dipesan
is_available = false → Menu tidak bisa dipesan (tidak muncul di form pesanan)
```

### **Status Kategori**
```
is_active = true  → Kategori aktif, menu bisa ditambahkan
is_active = false → Kategori tidak aktif, tidak muncul di dropdown
```

---

## 🎯 BUSINESS RULES

1. **Pesanan:**
   - Setiap pesanan harus punya minimal 1 item
   - Total harga = sum(subtotal semua item)
   - Order number auto-generate (unique)

2. **Menu:**
   - Menu yang tidak tersedia tidak bisa ditambahkan ke pesanan
   - Jika stok habis, menu otomatis tidak tersedia
   - Harga menu di order_item = harga saat pemesanan (snapshot)

3. **Kategori:**
   - Kategori yang tidak aktif tidak muncul di dropdown
   - Tidak bisa hapus kategori jika masih ada menu aktif

4. **User:**
   - Kasir hanya bisa lihat pesanan yang dibuat sendiri
   - Admin bisa lihat semua pesanan
   - Kasir tidak bisa hapus pesanan

---

## 📱 RESPONSIVE FLOW

### **Mobile View:**
- Navigation menjadi hamburger menu
- Tables menjadi cards
- Forms tetap full width
- Touch-friendly buttons

### **Tablet View:**
- 2-column layout untuk dashboard
- Tables dengan horizontal scroll
- Forms dengan 2-column layout

### **Desktop View:**
- Full navigation sidebar
- Multi-column layouts
- Tables dengan semua kolom
- Forms dengan optimal spacing

---

**Last Updated:** 2025-01-02
**Version:** 1.0.0


