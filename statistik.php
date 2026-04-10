<?php
// statistik.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'koneksi.php';

$tables_check = [
    'demografi_kependudukan',
    'geospasial_infrastruktur', 
    'sosial_ekonomi_pendidikan'
];

$missing_tables = [];
if (isset($conn) && $conn) {
    foreach ($tables_check as $table) {
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if (!$result || mysqli_num_rows($result) == 0) {
            $missing_tables[] = $table;
        }
    }
} else {
    $missing_tables = $tables_check;
}

$setup_needed = !empty($missing_tables);

if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$demografi_data = [];
$geospasial_data = [];
$sosial_data = [];

if (!$setup_needed && isset($conn)) {
    $demografi_query = "SELECT * FROM demografi_kependudukan ORDER BY tahun DESC LIMIT 5";
    if ($result = mysqli_query($conn, $demografi_query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $demografi_data[] = $row;
        }
    }

    $geospasial_query = "SELECT * FROM geospasial_infrastruktur ORDER BY jenis_data ASC";
    if ($result = mysqli_query($conn, $geospasial_query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $geospasial_data[] = $row;
        }
    }

    $sosial_query = "SELECT * FROM sosial_ekonomi_pendidikan ORDER BY tahun DESC LIMIT 5";
    if ($result = mysqli_query($conn, $sosial_query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sosial_data[] = $row;
        }
    }
}

$demografi_latest = !empty($demografi_data) ? $demografi_data[0] : null;

$geospasial_count = [
    'batas_wilayah' => 0,
    'tata_guna_lahan' => 0,
    'fasilitas_umum' => 0,
    'infrastruktur' => 0,
];

foreach ($geospasial_data as $item) {
    $jenis = $item['jenis_data'] ?? '';
    if (array_key_exists($jenis, $geospasial_count)) {
        $geospasial_count[$jenis]++;
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Data Desa | Demung</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } } }
        }
    </script>
    
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
    
    <style>
        .table-scroll::-webkit-scrollbar { height: 8px; }
        .table-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .table-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-green-200 selection:text-green-900">
    
    <?php 
    if (file_exists('header.php')) {
        include 'header.php'; 
    } else {
        echo '<div class="bg-red-100 text-red-700 p-3 text-center text-sm font-semibold">Peringatan: File header.php tidak ditemukan!</div>';
    }
    ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
        
        <?php if ($setup_needed): ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg mb-8 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0"><i class="bx bx-exclamation-circle text-3xl text-yellow-600"></i></div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-yellow-900 mb-2">Setup Database Diperlukan</h3>
                        <p class="text-yellow-800 mb-4">Tabel database untuk statistik belum dibuat atau koneksi terputus. Tabel yang hilang:</p>
                        <ul class="bg-white rounded p-3 mb-4 text-sm border border-yellow-200">
                            <?php foreach ($missing_tables as $table): ?>
                                <li class="text-red-600 font-medium">• <?php echo htmlspecialchars($table); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php else: ?>
        
        <div class="mb-10 text-center" data-aos="fade-down">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Portal Satu Data Desa</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Menyajikan data kependudukan, geospasial, dan sosial ekonomi secara transparan untuk perencanaan pembangunan yang terukur.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
            <?php if ($demografi_latest): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group" data-aos="fade-up">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Penduduk</p>
                        <h3 class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors"><?php echo number_format($demografi_latest['total_penduduk'] ?? 0, 0, ',', '.'); ?></h3>
                        <span class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-blue-700 bg-blue-50 px-2 py-1 rounded-md">
                            <i class='bx bx-calendar'></i> Tahun <?php echo e($demografi_latest['tahun'] ?? '-'); ?>
                        </span>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600"><i class="bx bxs-group text-3xl"></i></div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Rasio Jenis Kelamin</p>
                        <h3 class="text-3xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors"><?php echo e($demografi_latest['rasio_jenis_kelamin'] ?? '0'); ?></h3>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">Laki-laki per 100 Perempuan</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600"><i class="bx bx-male-female text-3xl"></i></div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-span-2 bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-6 flex items-center justify-center text-gray-400" data-aos="fade-up">
                <p><i class='bx bx-info-circle mr-2'></i>Data demografi utama belum tersedia.</p>
            </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Fasilitas Umum</p>
                        <h3 class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors"><?php echo $geospasial_count['fasilitas_umum'] ?? 0; ?></h3>
                        <p class="text-xs text-gray-500 mt-2">Titik Tercatat</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600"><i class="bx bxs-building-house text-3xl"></i></div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Infrastruktur</p>
                        <h3 class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors"><?php echo $geospasial_count['infrastruktur'] ?? 0; ?></h3>
                        <p class="text-xs text-gray-500 mt-2">Titik Tercatat</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600"><i class="bx bxs-traffic-cone text-3xl"></i></div>
                </div>
            </div>
        </div>

        <section class="mb-14 scroll-mt-24" id="demografi" data-aos="fade-up">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-5 flex items-center gap-3">
                    <div class="p-2 bg-blue-600 rounded-lg text-white"><i class="bx bxs-bar-chart-alt-2 text-xl"></i></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Demografi Kependudukan</h2>
                        <p class="text-sm text-gray-500">Statistik pertumbuhan dan pergerakan penduduk</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="border border-gray-100 rounded-xl p-5 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Tren Populasi (5 Tahun)</h3>
                            <div class="relative h-[250px] w-full"><canvas id="populasiChart"></canvas></div>
                        </div>
                        <div class="border border-gray-100 rounded-xl p-5 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Piramida Gender Aktif</h3>
                            <div class="relative h-[250px] w-full flex justify-center"><canvas id="genderChart"></canvas></div>
                        </div>
                    </div>

                    <div class="table-scroll overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Tahun</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right">Total</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right text-blue-600">Laki-laki</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right text-pink-600">Perempuan</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-center">Rasio JK</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right" title="Lahir / Mati">L/M (%)</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right">Masuk / Keluar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (!empty($demografi_data)): ?>
                                    <?php foreach ($demografi_data as $index => $row): ?>
                                    <tr class="hover:bg-blue-50/50 transition-colors <?php echo $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/30'; ?>">
                                        <td class="px-5 py-3 font-medium text-gray-900"><?php echo e($row['tahun'] ?? '-'); ?></td>
                                        <td class="px-5 py-3 text-right font-medium"><?php echo number_format($row['total_penduduk'] ?? 0, 0, ',', '.'); ?></td>
                                        <td class="px-5 py-3 text-right text-gray-600"><?php echo number_format($row['laki_laki'] ?? 0, 0, ',', '.'); ?></td>
                                        <td class="px-5 py-3 text-right text-gray-600"><?php echo number_format($row['perempuan'] ?? 0, 0, ',', '.'); ?></td>
                                        <td class="px-5 py-3 text-center"><span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-md font-medium"><?php echo e($row['rasio_jenis_kelamin'] ?? '-'); ?></span></td>
                                        <td class="px-5 py-3 text-right text-gray-500">
                                            <span class="text-green-600">↑<?php echo e($row['tingkat_kelahiran'] ?? '0'); ?></span> / 
                                            <span class="text-red-500">↓<?php echo e($row['tingkat_kematian'] ?? '0'); ?></span>
                                        </td>
                                        <td class="px-5 py-3 text-right text-gray-600">
                                            <?php echo number_format($row['penduduk_masuk'] ?? 0, 0, ',', '.') . ' / ' . number_format($row['penduduk_keluar'] ?? 0, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="px-5 py-8 text-center text-gray-500"><i class='bx bx-folder-open text-2xl mb-2 block'></i>Belum ada data demografi yang dicatat.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-14 scroll-mt-24" id="geospasial" data-aos="fade-up">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-5 flex items-center gap-3">
                    <div class="p-2 bg-emerald-600 rounded-lg text-white"><i class="bx bx-map-alt text-xl"></i></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Geospasial & Infrastruktur</h2>
                        <p class="text-sm text-gray-500">Pemetaan titik vital dan kondisi fasilitas fisik desa</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex gap-2 flex-wrap mb-6 border-b border-gray-100 pb-4">
                        <button onclick="filterGeospasial('semua')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all bg-emerald-600 text-white shadow-sm" data-filter="semua">Semua Titik</button>
                        <button onclick="filterGeospasial('batas_wilayah')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50" data-filter="batas_wilayah">Batas Wilayah</button>
                        <button onclick="filterGeospasial('tata_guna_lahan')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50" data-filter="tata_guna_lahan">Tata Guna Lahan</button>
                        <button onclick="filterGeospasial('fasilitas_umum')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50" data-filter="fasilitas_umum">Fasilitas Umum</button>
                        <button onclick="filterGeospasial('infrastruktur')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all bg-white text-gray-600 border border-gray-200 hover:bg-gray-50" data-filter="infrastruktur">Infrastruktur</button>
                    </div>

                    <div class="table-scroll overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Nama / Titik Lokasi</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Kategori</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Koordinat (Lat, Long)</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Kondisi Fisik</th>
                                    <th class="px-5 py-4 font-semibold">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody id="geospasialTable" class="divide-y divide-gray-100">
                                <?php if (!empty($geospasial_data)): ?>
                                    <?php foreach ($geospasial_data as $row): 
                                        $kondisi = strtolower(trim($row['kondisi'] ?? ''));
                                        $badgeKondisi = 'bg-gray-100 text-gray-700';
                                        if (in_array($kondisi, ['baik', 'bagus', 'layak'])) $badgeKondisi = 'bg-green-100 text-green-700';
                                        else if (in_array($kondisi, ['rusak ringan', 'sedang'])) $badgeKondisi = 'bg-yellow-100 text-yellow-700';
                                        else if (in_array($kondisi, ['rusak berat', 'kritis'])) $badgeKondisi = 'bg-red-100 text-red-700';
                                    ?>
                                    <tr class="hover:bg-emerald-50/30 transition-colors bg-white geospasial-row" data-jenis="<?php echo e($row['jenis_data'] ?? ''); ?>">
                                        <td class="px-5 py-4 font-medium text-gray-900"><?php echo e($row['nama_lokasi'] ?? '-'); ?></td>
                                        <td class="px-5 py-4"><span class="px-2.5 py-1 rounded-md text-xs font-medium border border-gray-200 text-gray-600 bg-gray-50"><?php echo ucwords(str_replace('_', ' ', e($row['jenis_data'] ?? '-'))); ?></span></td>
                                        <td class="px-5 py-4">
                                            <?php if (!empty($row['latitude']) && !empty($row['longitude'])): ?>
                                                <a href="https://maps.google.com/?q=<?php echo $row['latitude'].','.$row['longitude']; ?>" target="_blank" class="inline-flex items-center gap-1 font-mono text-xs text-blue-600 hover:underline bg-blue-50 px-2 py-1 rounded">
                                                    <i class='bx bx-map'></i> <?php echo round($row['latitude'], 5) . ', ' . round($row['longitude'], 5); ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400 italic text-xs">Belum dipetakan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-4">
                                            <?php if(!empty($row['kondisi'])): ?>
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium <?php echo $badgeKondisi; ?>"><?php echo ucwords(e($row['kondisi'])); ?></span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-5 py-4 text-gray-600 text-sm max-w-xs truncate" title="<?php echo e($row['deskripsi'] ?? ''); ?>">
                                            <?php echo e($row['deskripsi'] ?? '-'); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500"><i class='bx bx-map-pin text-2xl mb-2 block'></i>Data pemetaan geospasial belum tersedia.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-14 scroll-mt-24" id="sosial" data-aos="fade-up">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 px-6 py-5 flex items-center gap-3">
                    <div class="p-2 bg-orange-500 rounded-lg text-white"><i class="bx bx-wallet-alt text-xl"></i></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Kesejahteraan & Pendidikan</h2>
                        <p class="text-sm text-gray-500">Indikator ekonomi keluarga dan partisipasi pendidikan anak</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="border border-gray-100 rounded-xl p-5 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Tren Pendapatan Kapita</h3>
                            <div class="relative h-[250px] w-full"><canvas id="pendapatanChart"></canvas></div>
                        </div>
                        <div class="border border-gray-100 rounded-xl p-5 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Indeks Partisipasi Sekolah</h3>
                            <div class="relative h-[250px] w-full flex justify-center"><canvas id="pendidikanChart"></canvas></div>
                        </div>
                    </div>

                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-6">
                        <div class="flex items-start gap-2">
                            <i class='bx bx-info-circle text-orange-600 mt-0.5'></i>
                            <div>
                                <h4 class="text-sm font-bold text-orange-800 mb-2">Panduan Desil Kesejahteraan (Basis Data Terpadu)</h4>
                                <div class="flex flex-wrap gap-2 text-xs">
                                    <span class="bg-white px-2 py-1 rounded border border-orange-200 shadow-sm"><strong class="text-red-600">D-0:</strong> Sangat Miskin</span>
                                    <span class="bg-white px-2 py-1 rounded border border-orange-200 shadow-sm"><strong class="text-orange-600">D-1 - D-3:</strong> Miskin</span>
                                    <span class="bg-white px-2 py-1 rounded border border-orange-200 shadow-sm"><strong class="text-yellow-600">D-4 - D-6:</strong> Pra-Sejahtera</span>
                                    <span class="bg-white px-2 py-1 rounded border border-orange-200 shadow-sm"><strong class="text-green-600">D-7 - D-9:</strong> Sejahtera</span>
                                    <span class="bg-white px-2 py-1 rounded border border-orange-200 shadow-sm"><strong class="text-blue-600">D-10:</strong> Sangat Sejahtera</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-scroll overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Tahun</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right">Pendapatan Rata-rata</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-center">Desil Dominan</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-right">Keluarga Pra-Sejahtera</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-center">Partisipasi Sekolah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (!empty($sosial_data)): ?>
                                    <?php foreach ($sosial_data as $index => $row): ?>
                                    <tr class="hover:bg-orange-50/30 transition-colors <?php echo $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/30'; ?>">
                                        <td class="px-5 py-4 font-medium text-gray-900"><?php echo e($row['tahun'] ?? '-'); ?></td>
                                        <td class="px-5 py-4 text-right text-gray-700 font-medium">Rp <?php echo number_format($row['pendapatan_rata_rata'] ?? 0, 0, ',', '.'); ?></td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-block bg-orange-100 text-orange-800 text-xs font-bold px-2 py-1 rounded-md shadow-sm">D-<?php echo e($row['desil_kemiskinan'] ?? '0'); ?></span>
                                        </td>
                                        <td class="px-5 py-4 text-right text-gray-700"><?php echo number_format($row['jumlah_termasuk_miskin'] ?? 0, 0, ',', '.'); ?> KK</td>
                                        <td class="px-5 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <span class="font-medium <?php echo ($row['partisipasi_sekolah_anak'] ?? 0) >= 90 ? 'text-green-600' : 'text-orange-600'; ?>">
                                                    <?php echo e($row['partisipasi_sekolah_anak'] ?? '0'); ?>%
                                                </span>
                                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden hidden sm:block">
                                                    <div class="h-full <?php echo ($row['partisipasi_sekolah_anak'] ?? 0) >= 90 ? 'bg-green-500' : 'bg-orange-500'; ?>" style="width: <?php echo e($row['partisipasi_sekolah_anak'] ?? 0); ?>%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500"><i class='bx bx-data text-2xl mb-2 block'></i>Data sosial ekonomi belum diinput ke sistem.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <?php endif; ?>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-white font-bold text-lg mb-1">Portal Data Desa Demung</h3>
                <p class="text-sm text-gray-400">Transparansi dan Akuntabilitas Menuju Desa Mandiri.</p>
            </div>
            <div class="text-sm text-gray-400">© <?php echo date('Y'); ?> Pemerintah Desa Demung. All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        if (typeof AOS !== 'undefined') { AOS.init({ duration: 800, once: true, offset: 50 }); }

        function filterGeospasial(filterVal) {
            const rows = document.querySelectorAll('.geospasial-row');
            const buttons = document.querySelectorAll('.filter-btn');

            buttons.forEach(btn => {
                if (btn.dataset.filter === filterVal) {
                    btn.classList.replace('bg-white', 'bg-emerald-600');
                    btn.classList.replace('text-gray-600', 'text-white');
                    btn.classList.remove('border-gray-200', 'hover:bg-gray-50');
                } else {
                    btn.classList.replace('bg-emerald-600', 'bg-white');
                    btn.classList.replace('text-white', 'text-gray-600');
                    btn.classList.add('border-gray-200', 'hover:bg-gray-50');
                }
            });

            rows.forEach(row => {
                row.style.display = (filterVal === 'semua' || row.dataset.jenis === filterVal) ? 'table-row' : 'none';
            });
        }

        // CHART.JS RENDER (Hanya berjalan jika library berhasil di-load)
        window.addEventListener('DOMContentLoaded', () => {
            if (typeof Chart !== 'undefined') {
                Chart.defaults.font.family = "'Inter', sans-serif";
                Chart.defaults.color = '#64748b';

                <?php
                // Data disiapkan dari server PHP ke var JavaScript
                $tahun_demografi = !empty($demografi_data) ? array_column(array_reverse($demografi_data), 'tahun') : [];
                $total_penduduk = !empty($demografi_data) ? array_column(array_reverse($demografi_data), 'total_penduduk') : [];
                $tahun_pendapatan = !empty($sosial_data) ? array_column(array_reverse($sosial_data), 'tahun') : [];
                $pendapatan = !empty($sosial_data) ? array_column(array_reverse($sosial_data), 'pendapatan_rata_rata') : [];
                $partisipasi_sekolah = !empty($sosial_data) ? array_column(array_reverse($sosial_data), 'partisipasi_sekolah_anak') : [];
                ?>

                const popCanvas = document.getElementById('populasiChart');
                if (popCanvas && <?php echo count($tahun_demografi); ?> > 0) {
                    new Chart(popCanvas, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($tahun_demografi); ?>,
                            datasets: [{
                                label: 'Total Penduduk',
                                data: <?php echo json_encode($total_penduduk); ?>,
                                borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.1)', borderWidth: 2, fill: true, tension: 0.3, pointBackgroundColor: '#ffffff', pointBorderColor: '#2563eb', pointBorderWidth: 2, pointRadius: 4
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: false, grid: { borderDash: [2, 4] } }, x: { grid: { display: false } } } }
                    });
                }

                const genCanvas = document.getElementById('genderChart');
                if (genCanvas && <?php echo $demografi_latest ? 'true' : 'false'; ?>) {
                    new Chart(genCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: ['Laki-laki', 'Perempuan'],
                            datasets: [{
                                data: [<?php echo $demografi_latest['laki_laki'] ?? 0; ?>, <?php echo $demografi_latest['perempuan'] ?? 0; ?>],
                                backgroundColor: ['#3b82f6', '#ec4899'], borderWidth: 0, hoverOffset: 4
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } } }
                    });
                }

                const pendCanvas = document.getElementById('pendapatanChart');
                if (pendCanvas && <?php echo count($tahun_pendapatan); ?> > 0) {
                    new Chart(pendCanvas, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($tahun_pendapatan); ?>,
                            datasets: [{ label: 'Rata-rata Pendapatan', data: <?php echo json_encode($pendapatan); ?>, backgroundColor: '#f97316', borderRadius: 4 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: value => 'Rp ' + (value/1000000).toFixed(1) + ' Jt' } }, x: { grid: { display: false } } } }
                    });
                }

                const eduCanvas = document.getElementById('pendidikanChart');
                if (eduCanvas && <?php echo count($tahun_pendapatan); ?> > 0) {
                    new Chart(eduCanvas, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($tahun_pendapatan); ?>,
                            datasets: [{ label: 'Partisipasi Sekolah (%)', data: <?php echo json_encode($partisipasi_sekolah); ?>, borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 2, fill: true, tension: 0.3 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { min: 50, max: 100 }, x: { grid: { display: false } } } }
                    });
                }
            }
        });

        // Catatan: Script untuk Navbar dan Dropdown SENGAJA DIHAPUS DARI SINI
        // karena sudah di-handle sepenuhnya oleh file header.php
    </script>
</body>
</html>