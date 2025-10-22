# Animart

> Panduan instalasi, konfigurasi, dan menjalankan project **Animart** (Laravel + Blade + Tailwind + Vite) secara lokal dan dengan Docker.

---

## Ringkasan
Repo ini adalah aplikasi web berbasis **Laravel** dengan tampilan Blade dan tooling frontend menggunakan **Vite** + **Tailwind CSS**. Dokumen ini menjelaskan langkah-langkah lengkap untuk menyiapkan lingkungan pengembangan, menjalankan aplikasi secara lokal, dan tips troubleshooting.

> **Catatan:** sesuaikan nilai `APP_URL`, credential database, dan variabel lain di file `.env` sesuai lingkungan Anda.

---

## Prasyarat (Prerequisites)
Pastikan mesin/dev workstation Anda memiliki komponen berikut:

- **Git** (untuk clone repo)
- **PHP** — versi minimal 8.1 (direkomendasikan 8.2 atau lebih baru)
- **Composer** (dependency manager PHP)
- **Node.js** — LTS (mis. 18.x atau 20.x) dan NPM (atau Yarn/PNPM jika Anda gunakan)
- **Database** — MySQL / MariaDB / PostgreSQL (sesuaikan `.env`)
- **Optional:** Redis (untuk cache/queue), Mail server atau Mailtrap (untuk testing email)

Jika ingin menjalankan via Docker, perlu **Docker** & **Docker Compose**.

---

## Instalasi Lokal (Langkah demi langkah)
Ikuti langkah berikut di terminal (Linux/macOS) atau PowerShell (Windows):

### 1. Clone repository
```bash
git clone https://github.com/DaffaFirasyan/Animart.git
cd Animart
```

### 2. Install dependency PHP
```bash
composer install --no-interaction --prefer-dist
```

Jika Composer tidak ada di PATH, gunakan `php composer.phar install` (sesuaikan lokasi).

### 3. Copy file environment
```bash
cp .env.example .env
```
Di Windows PowerShell:
```powershell
copy .env.example .env
```

Edit `.env` dan sesuaikan konfigurasi berikut:
- `APP_NAME=Animart`
- `APP_URL=http://127.0.0.1:8000`
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=animart`
- `DB_USERNAME=root`
- `DB_PASSWORD=`

> Jika Anda akan menggunakan SQLite untuk testing cepat, buat file database: `database/database.sqlite` dan set `DB_CONNECTION=sqlite`.

### 4. Generate application key
```bash
php artisan key:generate
```

### 5. Buat database & jalankan migration
Pastikan database sudah dibuat (mis. `animart`). Lalu jalankan:
```bash
php artisan migrate
# Jika repo menyediakan seeder dan Anda mau data contoh:
php artisan db:seed
```
Jika ingin mengulang migration sambil seed:
```bash
php artisan migrate:fresh --seed
```

### 6. Setup storage link
Agar file upload dan asset storage bekerja:
```bash
php artisan storage:link
```

### 7. Install dependency frontend
```bash
npm install
```
Atau jika Anda memakai Yarn/PNPM:
```bash
yarn
# atau
pnpm install
```

### 8. Jalankan Vite (development)
```bash
npm run dev
```
Perintah ini akan menjalankan dev server Vite (untuk hot-reload asset).

### 9. Jalankan aplikasi Laravel
```bash
php artisan serve --host=127.0.0.1 --port=8000
```
Buka browser ke `http://127.0.0.1:8000` (atau `APP_URL` yang Anda set).

---

## Build untuk produksi (assets)
Jika akan membuat bundel produksi untuk asset CSS/JS:
```bash
npm run build
```
Kemudian pastikan web server (Nginx/Apache) mengarah ke folder `public/` dan file build ada di path yang benar (sesuai konfigurasi Vite).

---

## Menjalankan dengan Docker (Opsional)
Berikut contoh pendekatan Docker Compose (jika Anda ingin containerized):

> **Catatan:** Jika repo sudah menyertakan `docker-compose.yml`, ikuti file tersebut. Jika belum, Anda dapat membuat file sederhana seperti contoh di bawah.

**Contoh `docker-compose.yml` (contoh minimal):**
```yaml
version: '3.8'
services:
  app:
    image: php:8.2-fpm
    working_dir: /var/www/html
    volumes:
      - ./:/var/www/html
    depends_on:
      - db
  node:
    image: node:20
    working_dir: /var/www/html
    volumes:
      - ./:/var/www/html
    command: sh -c "npm install && npm run dev"
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: animart
      MYSQL_USER: user
      MYSQL_PASSWORD: secret
    ports:
      - 3306:3306
```

Langkah umum untuk Docker:
```bash
docker compose up -d
# lalu di container app jalankan composer install, artisan migrate, dll
```

---

## Variabel .env (Contoh penting)
Cantumkan contoh variabel `.env` yang kerap perlu disesuaikan:

```
APP_NAME=Animart
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=animart
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Animart"
```

---

## Menjalankan Queue & Scheduler (Jika digunakan)
- Queue worker (jika `QUEUE_CONNECTION=database` atau `redis`):
  ```bash
  php artisan queue:work --sleep=3 --tries=3
  ```
- Scheduler (cron) — tambahkan di crontab server:
  ```cron
  * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
  ```

---

## Testing
Jika repo menyediakan test (folder `tests/`), jalankan:
```bash
./vendor/bin/phpunit
```
atau jika menggunakan Pest:
```bash
./vendor/bin/pest
```

---

## Troubleshooting (Masalah yang sering muncul)
- **Error `Class 'xxx' not found` / Dependency issues:** jalankan `composer install` ulang; cek `composer.json` dan versi PHP.
- **Permission issues (Linux):** berikan permission pada `storage/` dan `bootstrap/cache`:
  ```bash
  sudo chown -R $USER:www-data storage bootstrap/cache
  chmod -R 775 storage bootstrap/cache
  ```
- **Node/Vite error:** hapus `node_modules` dan `package-lock.json` lalu `npm install` ulang.
- **Migration gagal:** periksa konfigurasi DB di `.env` dan pastikan server DB berjalan.

---

## Struktur singkat project
Beberapa direktori penting untuk dilihat:
- `app/` — kode backend (Models, Controllers, Console, Providers)
- `routes/` — deklarasi rute (web/api)
- `resources/views/` — Blade templates
- `resources/js/` & `resources/css/` — source asset frontend
- `database/migrations/` — definisi tabel DB
- `public/` — file publik yang di-serve (index.php, asset build)

---

## Kontribusi & Pengembangan
Jika Anda ingin berkontribusi:
1. Fork repo
2. Buat branch fitur: `git checkout -b feat/nama-fitur`
3. Commit dan push ke fork
4. Buat Pull Request dengan deskripsi perubahan

Tambahkan juga `CONTRIBUTING.md` jika diperlukan.

---

## Menambahkan dokumentasi & screenshot
Untuk membuat repo lebih menarik (direkomendasikan):
- Tambahkan **README.md** dengan screenshot UI, fitur utama, demo link (jika ada)
- Sertakan contoh `.env.example` yang sudah dimodifikasi untuk kebutuhan project
- Tambahkan badge (build, PHP version, license)

---

## Lisensi
Jika belum ada license, tambahkan file `LICENSE` (mis. MIT) dan tambahakan keterangan singkat di README.

---

## Kontak
Untuk pertanyaan lebih lanjut, tambahkan kontak pemilik repo (email, Twitter, dsb) di bagian README.

---

> Jika Anda mau, saya bisa:  
> - Menyunting README ini supaya cocok langsung sebagai `README.md` di root repo (bahasa & tone disesuaikan).  
> - Menambahkan contoh `.env.example` yang sudah diisi placeholder.  
> - Membuat bagian "Fitur yang sudah ada" jika Anda minta saya menganalisis file `routes/`, `Controllers`, dan `migrations` sekarang dan memasukkannya ke README.

