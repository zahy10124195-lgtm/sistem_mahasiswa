# Sistem Informasi Manajemen Data Mahasiswa

Tugas 2 – Penerapan Teknologi Internet (Teknik Informatika, Semester 5)

Aplikasi CRUD data mahasiswa berbasis **PHP murni** + **MySQL/MariaDB**, dilengkapi login berbasis `$_SESSION` dan fitur dual bahasa (Indonesia / Inggris).

## Fitur
- **Form & Validasi**: form POST, validasi `if-else` & `switch`, sanitasi `filter_var()` dan `htmlspecialchars()`
- **CRUD**: Create, Read (tabel + pencarian), Update (berdasarkan `id`), Delete
- **Session**: login (`password_hash` / `password_verify`), proteksi halaman, dual bahasa tersimpan di `$_SESSION['lang']`
- **Keamanan tambahan**: prepared statement, token CSRF, `session_regenerate_id()`

## Cara Menjalankan (XAMPP / Laragon)
1. Salin folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Jalankan Apache dan MySQL.
3. Buka phpMyAdmin → **Import** → pilih `database.sql`.
4. Jika perlu, sesuaikan kredensial di `config/koneksi.php`.
5. Buka `http://localhost/sistem-mahasiswa/`.
6. Login: **admin** / **admin123**

## Struktur Proyek
```
sistem-mahasiswa/
├── assets/style.css
├── config/koneksi.php        # koneksi database
├── includes/                 # auth, bahasa, validasi, header, footer, form
├── lang/id.php, en.php       # kamus bahasa
├── index.php                 # Read
├── tambah.php                # Create
├── edit.php                  # Update
├── hapus.php                 # Delete
├── login.php, logout.php, set_bahasa.php
└── database.sql
```
