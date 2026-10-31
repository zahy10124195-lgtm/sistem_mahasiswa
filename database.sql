-- ============================================================
-- Database: db_mahasiswa
-- Tugas 2 - Sistem Informasi Manajemen Data Sederhana
-- Import via phpMyAdmin atau: mysql -u root -p < database.sql
-- ============================================================
CREATE DATABASE IF NOT EXISTS db_mahasiswa
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_mahasiswa;

DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS users;

-- Tabel pengguna (untuk login)
CREATE TABLE users (
  id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username     VARCHAR(50)  NOT NULL,
  password     VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel data mahasiswa
CREATE TABLE mahasiswa (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nim        VARCHAR(12)  NOT NULL,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL,
  prodi      VARCHAR(50)  NOT NULL,
  angkatan   SMALLINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_nim (nim)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akun demo: username = admin | password = admin123 (di-hash dengan password_hash)
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$10$8M8AwZn/Ddbhrba.HatU7.2..9Md3xbuvMVnXYPe.z3HgjXI.9JaK', 'Administrator');

-- Data contoh
INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan) VALUES
('2023110001', 'Andi Pratama',   'andi.pratama@example.com',   'Teknik Informatika', 2023),
('2023110002', 'Siti Nurhaliza', 'siti.nurhaliza@example.com', 'Sistem Informasi',   2023),
('2022110015', 'Budi Santoso',   'budi.santoso@example.com',   'Teknik Informatika', 2022);
