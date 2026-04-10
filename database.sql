-- database.sql

-- Tabel berita
CREATE TABLE berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gambar VARCHAR(255) NOT NULL,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel anggota
CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel produk
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    alamat VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    nomor_wa VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel wisata
CREATE TABLE wisata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel user untuk login admin
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    session_admin VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel elapor
CREATE TABLE elapor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelapor VARCHAR(100) NOT NULL,
    foto_laporan VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    status ENUM('belum','teratasi') DEFAULT 'belum',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Demografi Kependudukan (Demografi Mikro)
CREATE TABLE demografi_kependudukan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun INT NOT NULL,
    total_penduduk INT NOT NULL,
    laki_laki INT NOT NULL,
    perempuan INT NOT NULL,
    rasio_jenis_kelamin DECIMAL(5,2),
    tingkat_kelahiran DECIMAL(5,2),
    tingkat_kematian DECIMAL(5,2),
    penduduk_masuk INT DEFAULT 0,
    penduduk_keluar INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Geospasial dan Infrastruktur Publik
CREATE TABLE geospasial_infrastruktur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lokasi VARCHAR(100) NOT NULL,
    jenis_data ENUM('batas_wilayah','tata_guna_lahan','fasilitas_umum','infrastruktur') NOT NULL,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    deskripsi TEXT,
    kondisi VARCHAR(100),
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Sosial, Ekonomi, dan Pendidikan
CREATE TABLE sosial_ekonomi_pendidikan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tahun INT NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    pendapatan_rata_rata INT,
    kepemilikan_aset VARCHAR(255),
    desil_kemiskinan INT,
    jumlah_termasuk_miskin INT DEFAULT 0,
    data_detail TEXT,
    partisipasi_sekolah_anak DECIMAL(5,2),
    tingkat_pendidikan VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
