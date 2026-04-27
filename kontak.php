<?php
// Error reporting untuk development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi tidak diperlukan untuk halaman kontak, tapi jika ada error di header, kita beri tau jelas
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak & Pengaduan | Desa Demung</title>
    
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

    <main class="flex-grow pt-8 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-16 text-center" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bxs-contact'></i> Pusat Layanan
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Kontak & Pengaduan Desa</h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Sampaikan aspirasi, laporan, atau pertanyaan Anda. Kami berkomitmen untuk melayani masyarakat dengan cepat dan transparan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 relative overflow-hidden" data-aos="fade-right">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10"></div>
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
                            <i class='bx bx-shield-quarter'></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Portal E-Lapor</h2>
                            <p class="text-sm text-gray-500">Laporan resmi ke sistem admin desa</p>
                        </div>
                    </div>

                    <form action="admin/proses_elapor.php" method="post" enctype="multipart/form-data" class="space-y-5">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_pelapor" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-gray-50 focus:bg-white"
                                placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Bukti Foto Laporan</label>
                            <input type="file" name="foto_laporan" accept="image/*" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors border border-gray-200 rounded-xl cursor-pointer bg-gray-50">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Deskripsi / Detail Laporan</label>
                            <textarea name="deskripsi" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-gray-50 focus:bg-white resize-y"
                                rows="4" placeholder="Jelaskan secara rinci laporan atau keluhan Anda..."></textarea>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-gray-900 text-white font-semibold py-3.5 rounded-xl hover:bg-emerald-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                <i class='bx bx-send text-xl'></i> Kirim Laporan Resmi
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 relative overflow-hidden" data-aos="fade-left">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-2xl">
                            <i class='bx bxl-whatsapp'></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Hubungi via WhatsApp</h2>
                            <p class="text-sm text-gray-500">Tanya jawab cepat dengan perangkat desa</p>
                        </div>
                    </div>

                    <form onsubmit="return sendToWA(event)" class="space-y-5">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" id="nama" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-gray-50 focus:bg-white"
                                placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Alamat Email (Opsional)</label>
                            <input type="email" id="email" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-gray-50 focus:bg-white"
                                placeholder="contoh@email.com">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">Pesan Anda</label>
                            <textarea id="pesan" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-gray-50 focus:bg-white resize-y"
                                rows="4" placeholder="Tuliskan pertanyaan atau pesan Anda..."></textarea>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-green-500 text-white font-semibold py-3.5 rounded-xl hover:bg-green-600 shadow-md hover:shadow-lg hover:shadow-green-500/30 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class='bx bxl-whatsapp text-xl'></i> Kirim Pesan ke WhatsApp
                            </button>
                        </div>
                    </form>
                    
                    <script>
                        function sendToWA(e) {
                            e.preventDefault();
                            var nama = document.getElementById('nama').value;
                            var email = document.getElementById('email').value;
                            var pesan = document.getElementById('pesan').value;
                            var no_wa = '6282322396666'; 
                            var text = `Halo Admin Desa Demung,%0A%0APerkenalkan saya *${nama}* (${email}).%0A%0A${pesan}`;
                            var url = `https://wa.me/${no_wa}?text=${text}`;
                            window.open(url, '_blank');
                            return false;
                        }
                    </script>
                </div>
                
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row" data-aos="fade-up">
                
                <div class="w-full md:w-3/5 h-80 md:h-auto bg-gray-200 relative group">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.5132515053744!2d113.7120027!3d-7.7269929!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd71efc6b0d6b39%3A0xc35e4f85077c7e7d!2sKantor%20Kepala%20Desa%20Demung!5e0!3m2!1sid!2sid!4v1700000000000" 
                        class="absolute inset-0 w-full h-full border-0 grayscale-[20%] group-hover:grayscale-0 transition-all duration-500" 
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/20 backdrop-blur-[1px]">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=-7.7269929,113.7120027" 
                           target="_blank" 
                           class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold shadow-2xl hover:bg-emerald-700 flex items-center gap-2 transform hover:scale-105 transition-all">
                            <i class='bx bx-directions text-2xl'></i>
                            Buka Rute Navigasi
                        </a>
                    </div>
                </div>

                <div class="w-full md:w-2/5 p-8 md:p-10 flex flex-col justify-center bg-white">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <i class='bx bx-map text-xl'></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Alamat Kantor</p>
                                <p class="text-sm text-gray-600 leading-relaxed">Jl. Desa Demung No. 1, Kecamatan Besuki, Kabupaten Situbondo, Jawa Timur</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <i class='bx bx-phone text-xl'></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Telepon Utama</p>
                                <p class="text-sm text-gray-600">0812-3456-7890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <i class='bx bx-envelope text-xl'></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Email Resmi</p>
                                <p class="text-sm text-gray-600">info@desademung.id</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 md:hidden">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=-7.7269929,113.7120027" 
                           target="_blank" 
                           class="w-full flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 py-3 rounded-xl font-bold border border-emerald-100 active:scale-95 transition-all">
                            <i class='bx bx-map-pin text-xl'></i> Petunjuk Jalan
                        </a>
                    </div>
                </div>
                
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
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 800, once: true, offset: 50 });
        }
    </script>
</body>
</html>