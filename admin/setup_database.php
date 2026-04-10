<?php
// setup_database.php - Untuk membuat tabel statistik
include '../koneksi.php';

$tables_created = [];
$errors = [];

// 1. Buat Tabel Demografi Kependudukan
$sql1 = "CREATE TABLE IF NOT EXISTS demografi_kependudukan (
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
)";

if (mysqli_query($conn, $sql1)) {
    $tables_created[] = "demografi_kependudukan";
} else {
    $errors[] = "Error membuat tabel demografi_kependudukan: " . mysqli_error($conn);
}

// 2. Buat Tabel Geospasial Infrastruktur
$sql2 = "CREATE TABLE IF NOT EXISTS geospasial_infrastruktur (
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
)";

if (mysqli_query($conn, $sql2)) {
    $tables_created[] = "geospasial_infrastruktur";
} else {
    $errors[] = "Error membuat tabel geospasial_infrastruktur: " . mysqli_error($conn);
}

// 3. Buat Tabel Sosial Ekonomi Pendidikan
$sql3 = "CREATE TABLE IF NOT EXISTS sosial_ekonomi_pendidikan (
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
)";

if (mysqli_query($conn, $sql3)) {
    $tables_created[] = "sosial_ekonomi_pendidikan";
} else {
    $errors[] = "Error membuat tabel sosial_ekonomi_pendidikan: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Database Statistik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-gray-100 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center gap-3 mb-6">
                <i class="bx bxs-database text-4xl text-blue-600"></i>
                <h1 class="text-3xl font-bold text-gray-800">Setup Database Statistik</h1>
            </div>

            <?php if (empty($errors)): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
                    <h2 class="font-bold mb-2">✅ Tabel Berhasil Dibuat!</h2>
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach ($tables_created as $table): ?>
                            <li><code class="bg-green-50 px-2 py-1 rounded"><?php echo htmlspecialchars($table); ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                    <p class="text-blue-800 mb-4">Database sudah siap digunakan! Anda dapat:</p>
                    <div class="space-y-2">
                        <a href="../statistik.php" class="block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center transition">
                            <i class="bx bxs-bar-chart"></i> Lihat Halaman Statistik
                        </a>
                        <a href="dashboard.php?page=statistik" class="block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center transition">
                            <i class="bx bxs-cog"></i> Kelola Data Statistik
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <h2 class="font-bold mb-2">❌ Terjadi Error</h2>
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <p class="text-yellow-800"><strong>Solusi:</strong> Hubungi admin atau coba jalankan file ini kembali.</p>
                </div>
            <?php endif; ?>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    <strong>Catatan:</strong> File ini hanya perlu dijalankan sekali. Setelah tabel berhasil dibuat, 
                    Anda dapat menghapus file ini atau menjalankannya lagi tanpa masalah (tabel tidak akan dibuat ulang).
                </p>
            </div>
        </div>
    </div>
</body>
</html>
