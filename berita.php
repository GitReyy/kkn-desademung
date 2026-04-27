<?php
// Error reporting untuk development
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

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
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Desa | Desa Demung</title>
    
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

    <main class="flex-grow py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-16 text-center" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-widest uppercase">
                    <i class='bx bxs-news'></i> Kabar Terkini
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Berita Desa Demung</h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">
                    Ikuti terus informasi terbaru, pengumuman, dan kegiatan menarik seputar masyarakat dan pemerintahan desa.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                <?php 
                if (isset($conn)) {
                    $query = "SELECT * FROM berita ORDER BY id DESC";
                    $berita = mysqli_query($conn, $query);
                    
                    if ($berita && mysqli_num_rows($berita) > 0) {
                        while ($row = mysqli_fetch_assoc($berita)):
                ?>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group" data-aos="fade-up">
                    
                    <div class="relative h-60 overflow-hidden">
                        <?php if ($row['gambar']): ?>
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                 src="admin/<?= htmlspecialchars($row['gambar']) ?>" 
                                 alt="<?= htmlspecialchars($row['judul']) ?>" />
                        <?php else: ?>
                            <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-200">
                                <i class='bx bx-image text-6xl'></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-md text-emerald-700 px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-sm border border-emerald-100">
                                Kabar Desa
                            </span>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 flex flex-col flex-1">
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-4 font-semibold">
                            <i class='bx bx-calendar text-emerald-500 text-sm'></i> 
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </div>

                        <a href="detail_berita.php?id=<?= $row['id'] ?>" class="block mb-6">
                            <h5 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-emerald-600 transition-colors line-clamp-2">
                                <?= htmlspecialchars($row['judul']) ?>
                            </h5>
                        </a>

                        <div class="mt-auto pt-6 border-t border-gray-50">
                            <a href="detail_berita.php?id=<?= $row['id'] ?>" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-all">
                                Baca Selengkapnya <i class='bx bx-right-arrow-alt text-xl'></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                        endwhile; // --- PENUTUP WHILE YANG HILANG ---
                    } else {
                        echo '<div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                                <p class="text-gray-400 font-medium">Belum ada berita yang diterbitkan.</p>
                              </div>';
                    }
                }
                ?>
            </div>

        </div>
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
        AOS.init({ duration: 800, once: true, offset: 50 });
    </script>
</body>
</html>