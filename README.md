# Kaswarga App

Aplikasi Laravel sederhana untuk pengelolaan data `Kepala Keluarga` dan `Pengumuman` lingkungan warga.

## Fitur

- Dashboard utama dengan sapaan waktu otomatis: pagi, siang, sore, atau malam
- Sidebar aktif sesuai halaman yang sedang dibuka
- CRUD data `Kepala Keluarga`
- CRUD data `Pengumuman`
- Search pada halaman data kepala keluarga
- Search pada halaman pengumuman
- Dummy data bawaan melalui seeder

## Teknologi

- PHP `^8.1`
- Laravel `^10.10`
- MySQL
- Tailwind CSS via CDN

## Struktur Halaman

- `/` : Dashboard utama
- `/kepala-keluarga` : CRUD kepala keluarga
- `/pengumuman` : CRUD pengumuman

## Struktur Data

### Kepala Keluarga

Field yang digunakan:

- `nama`
- `alamat`
- `no_telepon`

### Pengumuman

Field yang digunakan:

- `judul`
- `isi`

## Instalasi

1. Clone repository ini.
2. Install dependency PHP:

```bash
composer install
```

3. Install dependency frontend:

```bash
npm install
```

4. Copy file environment jika belum ada:

```bash
cp .env.example .env
```

5. Atur koneksi database pada file `.env`.

Contoh konfigurasi yang saat ini dipakai di project ini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kaswarga
DB_USERNAME=root
DB_PASSWORD=
```

6. Generate application key:

```bash
php artisan key:generate
```

7. Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

8. Jalankan server development:

```bash
php artisan serve
```

9. Jika ingin menjalankan Vite:

```bash
npm run dev
```

## Seeder

Seeder yang tersedia:

- `WargaSeeder`
- `PengumumanSeeder`

Seeder dijalankan melalui:

```bash
php artisan db:seed
```

atau:

```bash
php artisan migrate --seed
```

## Testing

Menjalankan test bawaan Laravel:

```bash
php artisan test
```

## Struktur File Penting

- `routes/web.php` : route aplikasi
- `app/Http/Controllers/WargaController.php` : dashboard dan CRUD kepala keluarga
- `app/Http/Controllers/PengumumanController.php` : CRUD pengumuman
- `app/Models/Warga.php` : model kepala keluarga
- `app/Models/Pengumuman.php` : model pengumuman
- `resources/views/welcome.blade.php` : dashboard utama
- `resources/views/index.blade.php` : halaman CRUD kepala keluarga
- `resources/views/pengumuman/index.blade.php` : halaman CRUD pengumuman
- `resources/views/components/nav-bar.blade.php` : sidebar navigasi

## Catatan

- Secara internal model yang dipakai untuk data kepala keluarga masih menggunakan nama `Warga`, tetapi dari sisi aplikasi seluruh tampilan sudah diarahkan sebagai data `Kepala Keluarga`.
- Styling menggunakan Tailwind CDN, jadi belum memakai setup Tailwind lewat build pipeline Vite.

## Lisensi

Project ini menggunakan lisensi MIT mengikuti basis Laravel.
