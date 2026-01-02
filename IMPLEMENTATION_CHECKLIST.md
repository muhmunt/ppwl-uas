# IMPLEMENTATION CHECKLIST - APLIKASI MANAJEMEN KAFE

## ✅ Checklist Implementasi

Gunakan checklist ini untuk tracking progress development.

---

## 📋 PHASE 1: SETUP & AUTHENTICATION

### Setup Project
- [ ] Install Laravel Breeze atau setup authentication manual
- [ ] Setup database connection
- [ ] Create .env file
- [ ] Generate application key
- [ ] Run initial migrations

### Authentication & Authorization
- [ ] Add `role` column to users table (migration)
- [ ] Create AdminMiddleware
- [ ] Create KasirMiddleware
- [ ] Register middlewares in bootstrap/app.php
- [ ] Update User model (add role accessor/mutator)
- [ ] Create AdminSeeder (default admin user)
- [ ] Create KasirSeeder (default kasir user)
- [ ] Test login dengan role berbeda
- [ ] Setup route groups dengan middleware

### Layout & Navigation
- [ ] Create admin layout (resources/views/layouts/admin.blade.php)
- [ ] Create kasir layout (resources/views/layouts/kasir.blade.php)
- [ ] Setup navigation menu untuk admin
- [ ] Setup navigation menu untuk kasir
- [ ] Create dashboard views (admin & kasir)
- [ ] Setup routing untuk dashboard

---

## 📋 PHASE 2: MODUL KATEGORI MENU

### Database
- [ ] Create migration: `create_categories_table`
- [ ] Add fields: name, description, image, is_active, sort_order, timestamps, deleted_at
- [ ] Run migration

### Model
- [ ] Create Category model
- [ ] Add fillable fields
- [ ] Add soft delete trait
- [ ] Add relationships (hasMany Menu)
- [ ] Add accessors/mutators (jika perlu)

### Controller
- [ ] Create CategoryController (resource)
- [ ] Implement index() - dengan pagination & search
- [ ] Implement create()
- [ ] Implement store() - dengan validasi
- [ ] Implement show()
- [ ] Implement edit()
- [ ] Implement update() - dengan validasi
- [ ] Implement destroy() - soft delete
- [ ] Add authorization checks

### Form Request
- [ ] Create CategoryRequest untuk validasi
- [ ] Add validation rules (name required, unique, dll)

### Views
- [ ] Create categories/index.blade.php (list dengan table)
- [ ] Create categories/create.blade.php (form tambah)
- [ ] Create categories/edit.blade.php (form edit)
- [ ] Create categories/show.blade.php (detail, optional)
- [ ] Add search/filter functionality
- [ ] Add pagination
- [ ] Add success/error messages

### Routes
- [ ] Add resource routes untuk categories
- [ ] Protect dengan admin middleware

### Testing
- [ ] Test create kategori
- [ ] Test edit kategori
- [ ] Test delete kategori
- [ ] Test validasi
- [ ] Test authorization (kasir tidak bisa akses)

---

## 📋 PHASE 3: MODUL MENU

### Database
- [ ] Create migration: `create_menus_table`
- [ ] Add fields: category_id, name, description, price, image, is_available, stock, timestamps, deleted_at
- [ ] Add foreign key constraint ke categories
- [ ] Run migration

### Model
- [ ] Create Menu model
- [ ] Add fillable fields
- [ ] Add soft delete trait
- [ ] Add relationships (belongsTo Category, hasMany OrderItem)
- [ ] Add accessors/mutators (jika perlu)
- [ ] Add scopes (available, byCategory)

### Controller
- [ ] Create MenuController (resource)
- [ ] Implement index() - dengan filter kategori & search
- [ ] Implement create() - dengan load categories
- [ ] Implement store() - dengan validasi & upload gambar
- [ ] Implement show()
- [ ] Implement edit()
- [ ] Implement update() - dengan validasi & upload gambar
- [ ] Implement destroy() - soft delete
- [ ] Implement toggleAvailability() - toggle is_available
- [ ] Add authorization checks

### Form Request
- [ ] Create MenuRequest untuk validasi
- [ ] Add validation rules (name, category_id, price required, dll)
- [ ] Add image validation

### Views
- [ ] Create menus/index.blade.php (list dengan filter kategori)
- [ ] Create menus/create.blade.php (form tambah dengan kategori dropdown)
- [ ] Create menus/edit.blade.php (form edit)
- [ ] Create menus/show.blade.php (detail, optional)
- [ ] Add image upload preview
- [ ] Add filter by category
- [ ] Add search functionality
- [ ] Add toggle availability button
- [ ] Add pagination

### Image Upload
- [ ] Setup storage link (`php artisan storage:link`)
- [ ] Create upload directory (storage/app/public/menus)
- [ ] Implement image upload logic
- [ ] Implement image delete logic (saat update/delete)
- [ ] Add image validation (size, type)

### Routes
- [ ] Add resource routes untuk menus
- [ ] Add route untuk toggle availability
- [ ] Protect dengan admin middleware

### Testing
- [ ] Test create menu
- [ ] Test edit menu
- [ ] Test delete menu
- [ ] Test upload gambar
- [ ] Test toggle availability
- [ ] Test filter by category
- [ ] Test validasi
- [ ] Test authorization

---

## 📋 PHASE 4: MODUL PEMESANAN

### Database
- [ ] Create migration: `create_orders_table`
- [ ] Add fields: order_number, user_id, customer_name, table_number, status, total_price, notes, timestamps
- [ ] Add foreign key constraint ke users
- [ ] Create migration: `create_order_items_table`
- [ ] Add fields: order_id, menu_id, quantity, price, subtotal, notes, timestamps
- [ ] Add foreign key constraints ke orders & menus
- [ ] Run migrations

### Models
- [ ] Create Order model
- [ ] Add fillable fields
- [ ] Add relationships (belongsTo User, hasMany OrderItem)
- [ ] Add accessors/mutators (jika perlu)
- [ ] Add scopes (byStatus, byDate, byUser)
- [ ] Add method untuk generate order_number
- [ ] Create OrderItem model
- [ ] Add fillable fields
- [ ] Add relationships (belongsTo Order, belongsTo Menu)
- [ ] Add method untuk calculate subtotal

### Controllers
- [ ] Create OrderController (resource)
- [ ] Implement index() - dengan filter status, tanggal, user
- [ ] Implement create() - dengan load menus & categories
- [ ] Implement store() - dengan validasi & generate order_number
- [ ] Implement show() - detail pesanan dengan items
- [ ] Implement edit() - hanya jika status pending
- [ ] Implement update() - dengan recalculate total
- [ ] Implement destroy() - hanya admin, hanya jika pending
- [ ] Implement updateStatus() - update status pesanan
- [ ] Implement print() - generate PDF struk
- [ ] Add authorization checks
- [ ] Create OrderItemController
- [ ] Implement store() - tambah item ke pesanan
- [ ] Implement update() - update item
- [ ] Implement destroy() - hapus item

### Form Requests
- [ ] Create OrderRequest untuk validasi
- [ ] Add validation rules (min 1 item, dll)
- [ ] Create OrderItemRequest untuk validasi item

### Views
- [ ] Create orders/index.blade.php (list dengan filter)
- [ ] Create orders/create.blade.php (form pesanan dengan cart)
- [ ] Create orders/edit.blade.php (form edit pesanan)
- [ ] Create orders/show.blade.php (detail pesanan)
- [ ] Add cart functionality (JavaScript)
- [ ] Add add/remove item dari cart
- [ ] Add calculate total otomatis
- [ ] Add filter by status & date
- [ ] Add status badge
- [ ] Add print button

### Business Logic
- [ ] Implement generate order_number (format: ORD-YYYYMMDD-XXXX)
- [ ] Implement calculate total (sum of subtotals)
- [ ] Implement update stock saat pesanan dibuat (jika ada stock)
- [ ] Implement restore stock saat pesanan dihapus
- [ ] Implement status flow (pending → processing → completed)
- [ ] Implement validation: hanya bisa edit jika pending

### PDF Generation
- [ ] Install DomPDF atau library PDF
- [ ] Create PDF view untuk struk
- [ ] Implement print() method
- [ ] Design struk layout

### Routes
- [ ] Add resource routes untuk orders
- [ ] Add route untuk update status
- [ ] Add route untuk print
- [ ] Add resource routes untuk order-items
- [ ] Protect dengan middleware sesuai role

### Testing
- [ ] Test create pesanan
- [ ] Test tambah item ke pesanan
- [ ] Test edit pesanan (pending)
- [ ] Test update status
- [ ] Test delete pesanan (admin, pending)
- [ ] Test print struk
- [ ] Test calculate total
- [ ] Test authorization (kasir hanya lihat sendiri)
- [ ] Test validasi

---

## 📋 PHASE 5: DASHBOARD & LAPORAN

### Admin Dashboard
- [ ] Create dashboard view (admin)
- [ ] Add statistik hari ini (total pesanan, total pendapatan)
- [ ] Add grafik penjualan (7 hari terakhir)
- [ ] Add daftar pesanan terbaru (10 terakhir)
- [ ] Add menu terlaris
- [ ] Add quick actions
- [ ] Implement data aggregation queries

### Kasir Dashboard
- [ ] Create dashboard view (kasir)
- [ ] Add pesanan hari ini (yang dibuat sendiri)
- [ ] Add total penjualan hari ini
- [ ] Add status pesanan aktif (pending, processing)
- [ ] Add quick action (buat pesanan baru)

### Laporan (Admin Only)
- [ ] Create reports index page
- [ ] Add filter by date range
- [ ] Add laporan harian
- [ ] Add laporan bulanan
- [ ] Add export to PDF/Excel (optional)
- [ ] Add grafik penjualan

### Routes
- [ ] Add dashboard routes
- [ ] Add reports routes
- [ ] Protect dengan middleware

### Testing
- [ ] Test dashboard admin
- [ ] Test dashboard kasir
- [ ] Test laporan
- [ ] Test filter laporan

---

## 📋 PHASE 6: POLISH & OPTIMIZATION

### UI/UX Improvements
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] Loading states
- [ ] Error handling & messages
- [ ] Success messages
- [ ] Form validation feedback
- [ ] Toast notifications (optional)
- [ ] Loading spinners

### Security
- [ ] Review semua authorization checks
- [ ] Review input validation
- [ ] Add CSRF protection (Laravel default)
- [ ] Add XSS protection
- [ ] Review file upload security
- [ ] Add rate limiting (optional)

### Performance
- [ ] Add database indexes
- [ ] Optimize queries (eager loading)
- [ ] Add caching (jika perlu)
- [ ] Optimize images (resize, compress)
- [ ] Minify CSS/JS untuk production

### Error Handling
- [ ] Create custom error pages (404, 500)
- [ ] Add error logging
- [ ] Add user-friendly error messages

### Documentation
- [ ] Code comments
- [ ] Update README
- [ ] API documentation (jika perlu)

### Testing
- [ ] Unit tests untuk models
- [ ] Feature tests untuk controllers
- [ ] Browser tests untuk critical flows
- [ ] Test semua edge cases

### Deployment Preparation
- [ ] Setup production .env
- [ ] Optimize for production
- [ ] Setup database backup
- [ ] Setup logging
- [ ] Security audit

---

## 📊 PROGRESS TRACKING

**Total Tasks:** ~150+
**Completed:** 0
**In Progress:** 0
**Not Started:** ~150+

### Priority Order:
1. ✅ Phase 1: Setup & Authentication
2. ✅ Phase 2: Modul Kategori
3. ✅ Phase 3: Modul Menu
4. ✅ Phase 4: Modul Pemesanan
5. ✅ Phase 5: Dashboard & Laporan
6. ✅ Phase 6: Polish & Optimization

---

## 💡 TIPS

1. **Commit sering:** Commit setiap fitur yang selesai
2. **Test as you go:** Test setiap fitur sebelum lanjut
3. **Follow Laravel conventions:** Gunakan naming conventions Laravel
4. **Document code:** Comment code yang kompleks
5. **Ask for help:** Jangan stuck terlalu lama

---

**Last Updated:** 2025-01-02
**Version:** 1.0.0

