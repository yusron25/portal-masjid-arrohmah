---
description: Deploy Laravel ke cPanel tanpa terminal
---

# Deploy ke cPanel (Tanpa Terminal)

// turbo-all

## Persiapan Lokal (Sebelum Upload)

1. Build assets Vite:
```
npm run build
```

2. Pastikan folder `vendor/` lengkap:
```
composer install --optimize-autoloader --no-dev
```

## Upload ke cPanel via File Manager

3. Buat folder `web-desa` di `/home/username/` (sejajar dengan `public_html`)

4. Upload **semua file/folder** project **KECUALI folder `public/`** ke `/home/username/web-desa/`
   - Termasuk: `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`, `.env`, `artisan`, `composer.json`, dll

5. Upload **ISI folder `public/`** ke `/home/username/public_html/`
   - Termasuk: `index.php`, `build/`, `images/`, `deploy.php`, `.htaccess`, dll
   - **JANGAN** buat subfolder `public` di dalam `public_html`

## Edit index.php

6. Edit `/home/username/public_html/index.php`, ubah path bootstrap:

```php
// Cari baris ini:
require __DIR__.'/../vendor/autoload.php';
// Ubah menjadi:
require __DIR__.'/../web-desa/vendor/autoload.php';

// Cari baris ini:
$app = require_once __DIR__.'/../bootstrap/app.php';
// Ubah menjadi:
$app = require_once __DIR__.'/../web-desa/bootstrap/app.php';
```

## Edit .env

7. Edit `/home/username/web-desa/.env`:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database
```

## File Permission

8. Pastikan permission via cPanel File Manager:
   - `/home/username/web-desa/storage/` → 775 (recursive)
   - `/home/username/web-desa/bootstrap/cache/` → 775

## Jalankan Deploy Script

9. Buka browser, akses: `https://domainanda.com/deploy.php?key=mukti2026`

10. Klik tombol-tombol berikut secara berurutan:
    - 🔍 **Cek Environment** — Pastikan semua ✅
    - 🔗 **Buat Storage Link** — Untuk akses file upload
    - 📦 **Jalankan Migrasi** — Buat tabel database
    - 🌱 **Jalankan Seeder** — Isi data awal
    - ⚡ **Cache Config & Route** — Optimasi production

## Selesai!

11. **HAPUS file `deploy.php`** dari `public_html` setelah semua selesai!

12. Test website: `https://domainanda.com`
13. Test admin: `https://domainanda.com/admin` (login: admin@desa.test / password)
