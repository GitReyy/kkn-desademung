<?php
// Error reporting untuk development
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
            theme: {
                extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } }
            }
        }
    </script>
    
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
</head>

<body class="bg-gray-50 text-gray-800 antialiased selection:bg-green-200 selection:text-green-900 flex flex-col min-h-screen">
    
    <?php 
    if (file_exists('koneksi.php')) { include 'koneksi.php'; }
    if (file_exists('header.php')) { include 'header.php'; } 
    ?>

    <main class="flex-grow pt-8 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12 text-center" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bxs-news'></i> Kabar Terkini
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Berita Desa Demung</h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Ikuti terus informasi terbaru, pengumuman, dan kegiatan menarik seputar masyarakat dan pemerintahan desa.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                if (isset($conn)) {
                    // Menghapus LIMIT 3 agar menjadi halaman arsip berita yang sebenarnya
                    $berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
                    
                    if ($berita && mysqli_num_rows($berita) > 0) {
                        while ($row = mysqli_fetch_assoc($berita)):
                ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group" data-aos="fade-up">
                            
                            <a href="detail_berita.php?id=<?= $row['id'] ?>" class="block relative h-56 overflow-hidden bg-gray-100">
                                <?php if (!empty($row['gambar'])): ?>
                                    <img src="admin/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= e($row['judul']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                        <i class='bx bx-image text-4xl mb-1'></i>
                                        <span class="text-xs font-medium">Tanpa Gambar</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                            </a>
                            
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="text-xs font-bold text-emerald-600 mb-3 uppercase tracking-wider">Informasi Publik</div>
                                
                                <a href="detail_berita.php?id=<?= $row['id'] ?>" class="block mb-4 flex-grow">
                                    <h2 class="text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors line-clamp-3 leading-snug">
                                        <?= e($row['judul']) ?>
                                    </h2>
                                </a>
                                
                                <div class="mt-auto pt-4 border-t border-gray-50">
                                    <a href="detail_berita.php?id=<?= $row['id'] ?>" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white px-5 py-2.5 rounded-xl font-semibold transition-colors duration-300">
                                        Baca Selengkapnya <i class='bx bx-right-arrow-alt text-lg'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php 
                        endwhile;
                    } else {
                        // Jika belum ada berita di database
                        echo '<div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-300 p-12 flex flex-col items-center justify-center text-gray-500" data-aos="fade-up">
                                <i class="bx bx-news text-6xl mb-4 text-gray-300"></i>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Berita</h3>
                                <p class="text-center">Kabar dan informasi terbaru akan segera hadir di halaman ini.</p>
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
                <a href="https://www.tiktok.com/@pemdes.demung?_t=ZS-8xjZ94umTDu&_r=1" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-white hover:text-gray-900 transition-colors text-xl"><i class='bx bxl-tiktok'></i></a>
                <a href="https://www.instagram.com/demung_creative?igsh=MTZtc2pjdDM0bHpnYQ==" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-white hover:text-gray-900 transition-colors text-xl"><i class='bx bxl-instagram'></i></a>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Init Animation
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 800, once: true, offset: 50 });
        }
        
        // Catatan: Script JS untuk Navbar/Dropdown sengaja tidak ditulis di sini 
        // karena sudah tertanam dan dieksekusi dari file header.php
    </script>
</body>
</html>