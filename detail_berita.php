<?php
// detail_berita.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$koneksiPath = __DIR__ . '/koneksi.php';
if (!file_exists($koneksiPath)) {
    die('Error: koneksi.php tidak ditemukan di ' . __DIR__);
}
require_once $koneksiPath;

// Helper function untuk keamanan XSS
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!isset($_GET['id'])) {
    echo '<div style="padding: 50px; text-align: center; font-family: sans-serif;"><h2>Berita tidak ditemukan.</h2><a href="berita.php">Kembali ke Berita</a></div>';
    exit();
}

$id = intval($_GET['id']);

// --- LOGIKA VIEW COUNTER ---
// Tambahkan 1 ke kolom views setiap kali halaman ini diakses
mysqli_query($conn, "UPDATE berita SET views = views + 1 WHERE id = $id");

$detail = mysqli_query($conn, "SELECT * FROM berita WHERE id=$id");
$berita = mysqli_fetch_assoc($detail);

if (!$berita) {
    echo '<div style="padding: 50px; text-align: center; font-family: sans-serif;"><h2>Berita tidak ditemukan.</h2><a href="berita.php">Kembali ke Berita</a></div>';
    exit();
}

// Ambil berita lain
$berita_lain = mysqli_query($conn, "SELECT id, judul, gambar, created_at FROM berita WHERE id != $id ORDER BY id DESC LIMIT 5");
if (mysqli_num_rows($berita_lain) == 0) {
    $berita_lain = mysqli_query($conn, "SELECT id, judul, gambar, created_at FROM berita ORDER BY id DESC LIMIT 5");
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($berita['judul']) ?> | Desa Demung</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } } }
        }
    </script>
    
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
    
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-emerald-200 selection:text-emerald-900 flex flex-col min-h-screen">
    
    <?php 
    $headerPath = __DIR__ . '/header.php';
    if (file_exists($headerPath)) { 
        include $headerPath; 
    } else {
        die('Error: header.php tidak ditemukan di ' . __DIR__);
    }
    ?>

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12 flex flex-col lg:flex-row gap-8 lg:gap-12">
        
        <article class="flex-1 max-w-4xl bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10 lg:p-12 overflow-hidden" data-aos="fade-up">
            
            <a href="berita.php" class="inline-flex items-center gap-2 text-emerald-600 font-semibold mb-8 hover:text-emerald-800 transition-colors bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl text-sm w-fit">
                <i class='bx bx-left-arrow-alt text-xl'></i> Kembali ke Daftar Berita
            </a>

            <div class="flex flex-wrap items-center gap-4 md:gap-6 text-sm text-gray-500 mb-5 font-medium">
                <div class="flex items-center gap-1.5">
                    <i class='bx bx-calendar text-lg text-emerald-600'></i> 
                    <?= date('d F Y', strtotime($berita['created_at'])) ?>
                </div>
                
                <div class="flex items-center gap-1.5 bg-gray-100 px-3 py-1 rounded-full">
                    <i class='bx bx-show text-lg text-emerald-600'></i> 
                    <span>Dilihat <?= number_format($berita['views']) ?> kali</span>
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 leading-tight tracking-tight">
                <?= e($berita['judul']) ?>
            </h1>

            <?php if (!empty($berita['gambar'])): ?>
                <div class="w-full mb-10 rounded-2xl overflow-hidden bg-gray-100 shadow-md">
                    <img src="admin/<?= htmlspecialchars($berita['gambar']) ?>" alt="<?= e($berita['judul']) ?>" class="w-full h-auto max-h-[500px] object-cover hover:scale-105 transition-transform duration-700">
                </div>
            <?php endif; ?>

            <div class="text-gray-700 text-lg leading-loose space-y-6">
                <?= nl2br(e($berita['isi'])) ?>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-100 flex items-center gap-4">
                <span class="font-semibold text-gray-900">Bagikan:</span>
                <a href="https://wa.me/?text=<?= urlencode('Baca berita menarik ini: ' . $berita['judul'] . ' di website Desa Demung.') ?>" target="_blank" class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-colors text-xl shadow-sm">
                    <i class='bx bxl-whatsapp'></i>
                </a>
            </div>
        </article>

        <aside class="w-full lg:w-96 flex-shrink-0" data-aos="fade-left">
            <div class="sticky top-28 bg-white lg:bg-transparent rounded-3xl lg:rounded-none p-6 lg:p-0 shadow-sm border border-gray-100 lg:border-none lg:shadow-none">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2 border-b lg:border-none border-gray-100 pb-4 lg:pb-0">
                    <i class='bx bx-news text-emerald-600 text-2xl'></i> Baca Juga
                </h3>
                
                <div class="flex lg:flex-col gap-4 overflow-x-auto lg:overflow-visible snap-x snap-mandatory scrollbar-hide pb-2 lg:pb-0">
                    <?php while ($row = mysqli_fetch_assoc($berita_lain)): ?>
                    <a href="detail_berita.php?id=<?= $row['id'] ?>" class="flex gap-4 group bg-white border border-gray-100 rounded-2xl p-3 hover:border-emerald-200 hover:shadow-md hover:bg-emerald-50/30 transition-all duration-300 min-w-[280px] sm:min-w-[320px] lg:min-w-0 snap-center flex-shrink-0 lg:flex-shrink">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="admin/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= e($row['judul']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300"><i class='bx bx-image text-2xl'></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col justify-center flex-grow">
                            <h4 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug mb-1">
                                <?= e($row['judul']) ?>
                            </h4>
                            <span class="text-xs text-gray-500 font-medium"><?= date('d M Y', strtotime($row['created_at'])) ?></span>
                        </div>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </aside>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <h3 class="text-white font-bold text-xl mb-1">Desa Demung</h3>
                <p class="text-sm text-gray-400">Transparansi dan Akuntabilitas Menuju Desa Mandiri.</p>
            </div>
            <div class="text-sm text-gray-400 text-center">
                &copy; <?= date('Y') ?> Pemerintah Desa Demung.<br class="md:hidden"> Didukung oleh KKN UNIVERSITAS NURUL JADID 25.
            </div>
            <div class="flex gap-4">
                <a href="https://www.tiktok.com/@pemdes.demung" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-white hover:text-gray-900 transition-colors text-xl"><i class='bx bxl-tiktok'></i></a>
                <a href="https://www.instagram.com/demung_creative" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-white hover:text-gray-900 transition-colors text-xl"><i class='bx bxl-instagram'></i></a>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 800, once: true, offset: 50 });
        }
    </script>
</body>
</html>