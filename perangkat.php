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
    <title>Perangkat Desa | Desa Demung</title>
    
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
    if (file_exists('koneksi.php')) { include 'koneksi.php'; }
    if (file_exists('header.php')) { include 'header.php'; } 
    ?>

    <main class="flex-grow pt-8 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-16 text-center pt-4" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bxs-user-badge'></i> Struktur Organisasi
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Perangkat Desa Demung</h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Mengenal lebih dekat jajaran pelayan masyarakat yang berdedikasi penuh untuk kemajuan dan kesejahteraan warga.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                <?php 
                if (isset($conn)) {
                    $anggota = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id ASC");
                    
                    if ($anggota && mysqli_num_rows($anggota) > 0) {
                        while ($row = mysqli_fetch_assoc($anggota)):
                ?>
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group flex flex-col text-center" data-aos="fade-up">
                                
                                <div class="h-24 w-full bg-gradient-to-br from-emerald-500 to-green-400 relative">
                                    <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=')]"></div>
                                </div>
                                
                                <div class="relative -mt-12 mx-auto mb-4 z-10">
                                    <div class="w-24 h-24 rounded-full border-4 border-white shadow-md bg-gray-50 flex items-center justify-center overflow-hidden">
                                        <?php if (!empty($row['foto'])): ?>
                                            <img src="admin/<?= htmlspecialchars($row['foto']) ?>" alt="<?= e($row['nama']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <i class='bx bxs-user text-5xl text-gray-300'></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="px-6 pb-8 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                            <?= e($row['nama']) ?>
                                        </h2>
                                    </div>
                                    <div class="mt-3">
                                        <span class="inline-block bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm">
                                            <?= e($row['jabatan']) ?>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                <?php 
                        endwhile;
                    } else {
                        // Tampilan jika data masih kosong
                        echo '<div class="col-span-full bg-white rounded-3xl border border-dashed border-gray-300 p-12 flex flex-col items-center justify-center text-gray-500" data-aos="fade-up">
                                <i class="bx bxs-group text-6xl mb-4 text-gray-300"></i>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Data</h3>
                                <p class="text-center">Data struktur perangkat desa belum diinputkan ke dalam sistem.</p>
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
    </script>
</body>
</html>