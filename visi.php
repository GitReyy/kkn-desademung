<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi | Desa Demung</title>
    
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
    if (file_exists($headerPath)) { include $headerPath; } else {
        die('Error: header.php tidak ditemukan di ' . __DIR__);
    }
    ?>

    <main class="flex-grow pt-8 pb-20 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-emerald-50 to-transparent -z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12 text-center pt-8" data-aos="fade-down">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold mb-4 tracking-wide uppercase">
                    <i class='bx bx-target-lock'></i> Arah Gerak Desa
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Visi & Misi</h1>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Cita-cita mulia dan langkah nyata Pemerintah Desa Demung dalam mewujudkan masyarakat yang madani.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative" data-aos="fade-up" data-aos-delay="100">
                
                <div class="p-8 md:p-12 lg:p-16 relative bg-gradient-to-br from-white to-emerald-50/30">
                    <i class='bx bxs-quote-alt-left absolute top-10 left-8 md:left-12 text-6xl text-emerald-100 opacity-60'></i>
                    
                    <div class="relative z-10 text-center max-w-3xl mx-auto mt-4">
                        <h2 class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-6">Visi Desa</h2>
                        <p class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight italic">
                            "Terwujudnya Masyarakat Desa Demung yang Beriman, Jujur, Adil, Sejahtera, Dan Berbudaya."
                        </p>
                    </div>
                </div>

                <div class="w-full flex justify-center items-center px-12">
                    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent w-full"></div>
                </div>

                <div class="p-8 md:p-12 lg:p-16">
                    <div class="text-center mb-10">
                        <h2 class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-2">Misi Desa</h2>
                        <h3 class="text-2xl font-bold text-gray-900">Langkah Nyata Mewujudkan Visi</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="150">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">1</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Mewujudkan Sumber Daya Manusia (SDM) Beriman, Bertaqwa, Berbudi Pekerti Luhur, Bugar dan Berbudaya.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="200">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">2</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Mewujudkan Pemerintahan Desa yang Jujur dan Berwibawa.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="250">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">3</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Mewujudkan Sarana dan Prasarana di Desa yang Memadai.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="300">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">4</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Mewujudkan Perekonomian Melalui Pembangunan Pertanian, Perikanan, Peternakan, Pariwisata/Budaya, dan Pengembangan Industri kecil.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="350">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">5</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Meningkatkan Kualitas Pelayanan Kesehatan Masyarakat Desa.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="400">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">6</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Meningkatkan Pendidikan Non Formal dan Pendidikan Formal.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="450">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">7</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Meningkatkan Tata Kelola yang Baik Dalam Memberikan Pelayanan Kepada Masyarakat.
                            </p>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="500">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">8</div>
                            <p class="text-gray-700 text-lg pt-2 leading-relaxed">
                                Mewujudkan Keamanan Masyarakat Desa Demung.
                            </p>
                        </div>
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