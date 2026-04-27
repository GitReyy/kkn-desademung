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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Potensi Desa | Desa Demung</title>
    
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
    $koneksiPath = __DIR__ . '/koneksi.php';
    if (file_exists($koneksiPath)) { include $koneksiPath; }
    
    $headerPath = __DIR__ . '/header.php';
    if (file_exists($headerPath)) { include $headerPath; } else {
        die('Error: header.php tidak ditemukan di ' . __DIR__);
    }
    ?>

    <main class="flex-grow pt-8 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-16 text-center" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bxs-star'></i> Unggulan Desa
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Potensi Desa Demung</h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Mengenal lebih dekat kekayaan alam, destinasi wisata, dan produk unggulan karya inovatif masyarakat lokal.</p>
            </div>

            <section class="mb-20" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xl">
                        <i class='bx bxs-store-alt'></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">UMKM & Produk Lokal</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php 
                    if (isset($conn)) {
                        $produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                        if ($produk && mysqli_num_rows($produk) > 0) {
                            while ($row = mysqli_fetch_assoc($produk)):
                    ?>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                                <div class="relative h-56 w-full overflow-hidden rounded-xl mb-5 bg-gray-100">
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="admin/<?= htmlspecialchars($row['foto']) ?>" alt="<?= e($row['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-image text-4xl mb-1'></i>
                                            <span class="text-xs font-medium">Tanpa Foto</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex flex-col flex-grow">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-emerald-600 transition-colors"><?= e($row['nama']) ?></h3>
                                    <p class="text-sm font-medium text-emerald-600 mb-3 flex items-start gap-1">
                                        <i class='bx bxs-map mt-0.5'></i> <?= e($row['alamat']) ?>
                                    </p>
                                    <p class="text-gray-500 text-sm mb-6 leading-relaxed flex-grow line-clamp-3">
                                        <?= e($row['deskripsi']) ?>
                                    </p>
                                    
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['nomor_wa']) ?>" target="_blank" class="w-full flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white py-3 rounded-xl font-semibold transition-colors duration-300">
                                        <i class='bx bxl-whatsapp text-xl'></i> Hubungi Penjual
                                    </a>
                                </div>
                            </div>
                    <?php 
                            endwhile;
                        } else {
                            echo '<div class="col-span-full bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">Belum ada data UMKM yang diinputkan.</div>';
                        }
                    }
                    ?>
                </div>
            </section>

            <section data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                        <i class='bx bxs-landscape'></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Destinasi Wisata</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php 
                    if (isset($conn)) {
                        $wisata = mysqli_query($conn, "SELECT * FROM wisata ORDER BY id DESC");
                        if ($wisata && mysqli_num_rows($wisata) > 0) {
                            while ($row = mysqli_fetch_assoc($wisata)):
                    ?>
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col">
                                <div class="relative h-64 w-full overflow-hidden bg-gray-100">
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="admin/<?= htmlspecialchars($row['foto']) ?>" alt="<?= e($row['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent opacity-80"></div>
                                    <?php else: ?>
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-image text-4xl mb-1'></i>
                                            <span class="text-xs font-medium">Tanpa Foto</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h3 class="absolute bottom-4 left-5 right-5 text-xl font-bold text-white drop-shadow-md">
                                        <?= e($row['nama']) ?>
                                    </h3>
                                </div>
                                
                                <div class="p-6 flex flex-col flex-grow">
                                    <p class="text-gray-500 text-sm leading-relaxed">
                                        <?= e($row['deskripsi']) ?>
                                    </p>
                                </div>
                            </div>
                    <?php 
                            endwhile;
                        } else {
                            echo '<div class="col-span-full bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">Belum ada data destinasi wisata yang diinputkan.</div>';
                        }
                    }
                    ?>
                </div>
            </section>

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
    </script>
</body>
</html>