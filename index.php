<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi | Desa Demung</title>
    
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
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="home.css">

    <style>
        /* Custom Scrollbar untuk Berita Mobile */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        .logo-shine {
            position: relative;
            overflow: hidden;
        }
        .logo-shine::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(120deg, rgba(255,255,255,0) 40%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 60%);
            transform: rotate(25deg);
            animation: shine 3s infinite;
            pointer-events: none;
        }
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(25deg); }
            60% { transform: translateX(120%) rotate(25deg); }
            100% { transform: translateX(120%) rotate(25deg); }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased selection:bg-green-200 selection:text-green-900 font-sans">
    
    <?php 
    if (file_exists('header.php')) {
        include 'header.php'; 
    } 
    ?>
    
    <section class="relative h-[85vh] min-h-[600px] flex items-center overflow-hidden" data-aos="fade-in">
        <div id="carousel-bg" class="absolute inset-0 w-full h-full z-0">
            <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
                <div class="relative h-full overflow-hidden">
                    <div class="absolute inset-0 bg-gray-900/40 z-10"></div>
                    <div class="hidden duration-700 ease-in-out h-full" data-carousel-item>
                        <img src="https://mercusuar.co/wp-content/uploads/2023/11/pengertian-Desa-dan-Pedesaan.jpg" class="absolute block w-full h-full object-cover object-center" alt="Desa Demung">
                    </div>
                    <div class="hidden duration-700 ease-in-out h-full" data-carousel-item>
                        <img src="https://www.simpeldesa.com/blog/wp-content/uploads/2020/07/musyawarah-desa.jpg" class="absolute block w-full h-full object-cover object-center" alt="Musyawarah">
                    </div>
                    <div class="hidden duration-700 ease-in-out h-full" data-carousel-item>
                        <img src="https://www.djkn.kemenkeu.go.id/files/images/2020/12/desa1.png" class="absolute block w-full h-full object-cover object-center" alt="Potensi Desa">
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 relative z-20 flex flex-col md:flex-row items-center justify-between gap-12 mt-10">
            <div class="max-w-xl bg-white/90 backdrop-blur-md rounded-3xl p-8 md:p-10 shadow-2xl border border-white/40" data-aos="fade-right" data-aos-delay="100">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold mb-6 tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Website Resmi
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2 tracking-tight leading-tight">Selamat Datang di</h1>
                <h2 class="text-4xl md:text-5xl font-extrabold text-green-600 mb-6 tracking-tight">Desa Demung</h2>
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    Desa yang kaya akan budaya, potensi alam, dan semangat gotong royong masyarakatnya. Mari bersama membangun desa yang lebih maju, mandiri, dan sejahtera.
                </p>
                <div class="flex items-center gap-4">
                    <a href="potensi.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-green-600/30 transition-all hover:-translate-y-0.5">Jelajahi Desa</a>
                    <div class="flex gap-3 ml-2">
                        <a href="https://www.tiktok.com/@pemdes.demung?_t=ZS-8xjZ94umTDu&_r=1" target="_blank" class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition-colors text-2xl"><i class='bx bxl-tiktok'></i></a>
                        <a href="https://www.instagram.com/demung_creative?igsh=MTZtc2pjdDM0bHpnYQ==" target="_blank" class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-pink-500 hover:to-purple-600 hover:text-white transition-all text-2xl"><i class='bx bxl-instagram'></i></a>
                    </div>
                </div>
            </div>

           <div class="hidden md:flex items-center justify-center" data-aos="fade-left" data-aos-delay="300">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-green-400/20 rounded-full blur-2xl group-hover:bg-green-400/30 transition-all duration-700 animate-pulse"></div>
        
                    <div class="w-72 h-72 md:w-[300px] md:h-[300px] rounded-full relative overflow-hidden logo-shine border-8 border-white/80 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] flex items-center justify-center -1 transition-transform duration-700 hover:scale-105">
                        <img src="logo.svg" alt="Logo Desa Demung" class="w-full h-full object-contain drop-shadow-2xl animate-float" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan Masyarakat</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Akses berbagai layanan administrasi desa dengan lebih mudah, cepat, dan transparan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-300">
                        <i class="bx bxs-id-card text-3xl text-blue-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Administrasi Kependudukan</h3>
                    <p class="text-gray-500 leading-relaxed">Pengurusan KTP, Kartu Keluarga, Akta Kelahiran, Akta Kematian, serta surat Pindah Datang/Keluar.</p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-300">
                        <i class="bx bxs-file-doc text-3xl text-emerald-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Surat Keterangan</h3>
                    <p class="text-gray-500 leading-relaxed">Layanan pembuatan Surat Keterangan Domisili, Usaha, Tidak Mampu, Tanah, dan dokumen pendukung lainnya.</p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors duration-300">
                        <i class="bx bxs-building-house text-3xl text-purple-600 group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Administrasi Kantor</h3>
                    <p class="text-gray-500 leading-relaxed">Pengelolaan surat menyurat, informasi keuangan desa, arsip publik, laporan, dan rencana pembangunan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white border-t border-gray-100" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Berita Terbaru</h2>
                    <p class="text-gray-500 text-lg">Informasi dan kegiatan terkini seputar Desa Demung.</p>
                </div>
                <a href="berita.php" class="hidden md:inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-800 transition-colors">
                    Lihat Semua <i class="bx bx-right-arrow-alt text-xl"></i>
                </a>
            </div>

            <div id="beritaScroll" class="flex gap-6 overflow-x-auto md:grid md:grid-cols-3 scrollbar-hide snap-x snap-mandatory pb-8 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0">
                
                <?php 
                // Error handling aman untuk koneksi
                if (file_exists('koneksi.php')) {
                    include 'koneksi.php';
                    if (isset($conn)) {
                        $berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
                        if ($berita && mysqli_num_rows($berita) > 0) {
                            while ($row = mysqli_fetch_assoc($berita)):
                ?>
                <div class="w-full bg-white border border-gray-200 rounded-lg shadow transition hover:scale-105 hover:shadow-lg flex-shrink-0">
                    <?php if ($row['gambar']) echo '<a href="detail_berita.php?id=' . $row['id'] . '"><img class="rounded-t-lg w-full h-48 object-cover" src="admin/' . htmlspecialchars($row['gambar']) . '" alt="' . htmlspecialchars($row['judul']) . '" /></a>'; ?>
                    <div class="p-5 flex flex-col">
                        <a href="detail_berita.php?id=<?= $row['id'] ?>">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-600 text-left"><?= htmlspecialchars($row['judul']) ?></h5>
                        </a>
                        <a href="detail_berita.php?id=<?= $row['id'] ?>" class="mt-auto inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Baca Selengkapnya</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

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