# ☕ APLIKASI MANAJEMEN KAFE

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  Sistem manajemen kafe berbasis web yang dibangun dengan Laravel untuk mengelola menu, kategori, dan pemesanan.
</p>

## 📚 Dokumentasi

- **[📋 PROJECT PLAN](./PROJECT_PLAN.md)** - Rencana lengkap project, modul, dan fitur
- **[🔄 FLOW DOCUMENTATION](./FLOW_DOCUMENTATION.md)** - Dokumentasi alur aplikasi dan business flow
- **[🚀 GETTING STARTED](./STARTER.md)** - Panduan instalasi dan setup project

## ✨ Fitur Utama

- ✅ **Modul Kategori Menu** - CRUD kategori dengan validasi dan soft delete
- ✅ **Modul Menu** - Manajemen menu lengkap dengan upload gambar
- ✅ **Modul Pemesanan** - Sistem pemesanan dengan status tracking
- ✅ **Role-based Access** - Admin dan Kasir dengan permission berbeda
- ✅ **Dashboard** - Statistik dan laporan untuk admin dan kasir

## 🚀 Quick Start

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Start server
php artisan serve
npm run dev
```

**Default Login:**
- Admin: `admin@cafe.com` / `password`
- Kasir: `kasir@cafe.com` / `password`

Lihat [STARTER.md](./STARTER.md) untuk panduan lengkap.

## 📦 Teknologi

- **Backend:** Laravel 12.x
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL/PostgreSQL/SQLite
- **PHP:** 8.2+

## 📖 About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
