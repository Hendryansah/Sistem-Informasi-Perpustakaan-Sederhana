# Sistem Informasi Perpustakaan Sederhana

Aplikasi web pengelolaan perpustakaan berbasis Laravel (MVC) untuk tugas UAS Pemrograman Web Framework.
Aplikasi ini dipakai oleh dua role, **admin** dan **petugas**, untuk mengelola katalog buku, kategori,
anggota, serta transaksi peminjaman dan pengembalian buku.

## Teknologi

- Laravel 13 (PHP >= 8.2)
- MySQL
- Blade + CSS murni (tanpa framework CSS)

## Fitur

### Authentication & Authorization
- Login dan logout dengan halaman terproteksi middleware `auth`.
- Role `admin` dan `petugas` ditegakkan lewat middleware `role`.
- Admin: mengelola pengguna, kategori, buku, anggota, dan peminjaman.
- Petugas: melihat kategori, mengelola buku, anggota, dan peminjaman (tidak bisa menyentuh menu pengguna dan ubah/hapus kategori).

### User Management (khusus admin)
- Lihat, tambah, ubah, hapus pengguna, serta menentukan role.

### Category Management
- List kategori beserta jumlah buku per kategori.
- Tambah / ubah / hapus kategori (khusus admin; hapus ditolak bila kategori masih dipakai buku).

### Book Management
- List buku dengan pencarian (judul, penulis, ISBN) dan pagination.
- Detail buku lengkap dengan riwayat peminjaman.
- Tambah / ubah / hapus buku dengan pemilihan kategori.

### Member Management
- List anggota dengan pencarian dan pagination.
- Detail anggota beserta riwayat peminjaman.
- Tambah / ubah / hapus anggota (kode anggota dibuat otomatis).

### Borrowing Management
- Peminjaman mencatat petugas/admin yang mencatat, anggota, tanggal pinjam, jatuh tempo otomatis
  7 hari setelah tanggal pinjam, status `borrowed`, dan rincian buku yang dipinjam; stok buku ikut berkurang.
- Pengembalian mencatat tanggal pengembalian, mengubah status menjadi `returned`, dan stok buku bertambah kembali.
- Filter transaksi: semua / sedang dipinjam / sudah kembali, plus penanda transaksi terlambat.

### Dashboard
- Jumlah judul buku, total stok, jumlah anggota, dan jumlah transaksi yang sedang dipinjam.
- Daftar peminjaman yang sedang berjalan.

## Cara Menjalankan

1. Pastikan PHP >= 8.2, Composer, dan MySQL sudah berjalan.
2. Install dependency:
   ```bash
   composer install
   ```
3. Salin berkas environment lalu sesuaikan kredensial MySQL di dalamnya:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Isi bagian database sesuai mesin masing-masing, contoh:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE="sistem informasi_perpustakaan_sederhana_1"
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Buat database sesuai nama di `.env` bila belum ada.
5. Jalankan migration sekaligus data contoh:
   ```bash
   php artisan migrate --seed
   ```
6. Nyalakan server pengembangan:
   ```bash
   php artisan serve
   ```
7. Buka `http://localhost:8000` di browser.

## Akun Demo

| Role    | Email             | Kata Sandi |
|---------|-------------------|------------|
| Admin   | admin@perpus.id   | password   |
| Petugas | petugas@perpus.id | password   |

## Struktur MVC

- `routes/web.php` — seluruh routing aplikasi, termasuk grup middleware `auth` dan `role:admin`.
- `app/Http/Controllers` — LoginController, DashboardController, UserController, CategoryController,
  BookController, MemberController, BorrowingController.
- `app/Http/Middleware/EnsureUserHasRole` — authorization berbasis role.
- `app/Models` — User, Category, Book, Member, Borrowing beserta relasi Eloquent
  (category hasMany books, member hasMany borrowings, borrowing belongsTo member/officer,
  borrowing belongsToMany books melalui tabel pivot `book_borrowing`).
- `database/migrations` — skema tabel users, categories, books, members, borrowings, book_borrowing.
- `database/seeders/DatabaseSeeder.php` — data contoh pengguna, kategori, buku, anggota, dan transaksi.
- `resources/views` — seluruh tampilan Blade dengan tata letak sidebar dan halaman login.
- `lang/id` — pesan validation, auth, dan pagination berbahasa Indonesia.

## Catatan Pengembangan

- Stok buku diubah di dalam transaksi database (`DB::transaction`) supaya peminjaman/pengembalian
  dan perubahan stok selalu konsisten.
- Kode anggota (`AGT-xxxx`) dan kode peminjaman (`PJM-tahun-xxxx`) dibuat otomatis oleh sistem.
