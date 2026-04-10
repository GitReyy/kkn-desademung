<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Desa | Desa Demung</title>
    
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
    if (file_exists('header.php')) { include 'header.php'; } 
    ?>

    <main class="flex-grow pt-8 pb-20 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-emerald-50 to-transparent -z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12 text-center pt-8" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bx-book-reader'></i> Profil Desa
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Sejarah Desa Demung</h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Jejak langkah, asal usul, dan perjalanan panjang masyarakat Desa Demung dari masa ke masa.</p>
            </div>

            <article class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 relative" data-aos="fade-up" data-aos-delay="100">
                
                <i class='bx bxs-quote-right absolute top-8 right-10 text-6xl text-gray-50 opacity-50'></i>

                <div class="text-gray-700 text-lg leading-loose space-y-6 relative z-10">
                    
                    <p class="first-letter:text-6xl first-letter:font-bold first-letter:text-emerald-600 first-letter:mr-3 first-letter:float-left first-line:uppercase first-line:tracking-widest">
                        Bermula dari hijrahnya Raden Abdurrahman Murobroto dari Pamekasan, Madura, pada tanggal 10 Asyura 1164 Hijriah atau tahun 1743 Masehi ke Desa Demung. Beliau adalah cucu dari Raden Abdullah Surowikromo yang masih merupakan keluarga Keraton Mataram, Susuhunan Pakubuwana II. Keputusan hijrah ini diambil karena wilayah Tanjung Jambul, Pamekasan, mengalami nimur kara atau kemarau panjang yang menyengsarakan rakyat.
                    </p>

                    <p>
                        Pada waktu itu, Raden Wino Broto memutuskan untuk hijrah ke tengah Pulau Jawa, mengarungi lautan menggunakan <i>proco</i> demi mencari tanah baru untuk bercocok tanam. Akhirnya, beliau tiba di Desa Demung yang dahulu dikenal dengan nama <strong class="text-gray-900">Nambhekor</strong>, berasal dari kata <i>nambhe</i> yang berarti berlabuh. Di sana, beliau mulai membuka hutan dan membangun sebuah gubuk yang dikenal dengan nama Tujuk Setacam di Dusun Demung Barat, serta membuka lahan pertanian.
                    </p>

                    <div class="py-4 flex justify-center">
                        <div class="w-16 h-1 bg-emerald-200 rounded-full"></div>
                    </div>

                    <p>
                        Berkat kerja keras tanpa mengenal putus asa, hasil panen Wino Broto melimpah ruah. Dalam catatan sejarah, Desa Demung merupakan hasil penyatuan dari empat desa. Pada tahun <strong class="text-gray-900">1927</strong>, perangkat desa pertama kali diangkat, yaitu Raden Siniwi Joyo.
                    </p>

                    <p>
                        Berdasarkan Monografi Desa Demung tahun 2020, jumlah penduduk mencapai 4.700,28 jiwa, yang terbagi ke dalam empat dusun, yaitu: <span class="font-semibold text-emerald-700">Dusun Ketah, Dusun Demung Barat, Dusun Semiring, dan Dusun Watuketu</span>.
                    </p>

                    <p>
                        Hingga saat ini, sektor pertanian masih menjadi penunjang utama perekonomian masyarakat Desa Demung. Sekitar 60% warga bermata pencaharian sebagai petani, dengan lahan pertanian seluas 262.388 hektare dan lahan perkebunan seluas 5.584 hektare. Selain bertani, sebagian masyarakat juga bekerja sebagai nelayan, karena letak Desa Demung berada di pesisir selatan Pantai Selat Madura.
                    </p>
                </div>
                
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-sm text-gray-500 font-medium">Diperbarui berdasarkan Monografi Desa</span>
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-sm text-gray-900">Bagikan:</span>
                        <a href="https://wa.me/?text=<?= urlencode('Baca Sejarah Desa Demung di sini: ' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" target="_blank" class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-colors text-lg">
                            <i class='bx bxl-whatsapp'></i>
                        </a>
                    </div>
                </div>

            </article>
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