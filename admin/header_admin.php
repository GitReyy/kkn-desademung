<?php
// admin/header_admin.php - Header admin universal
// Gunakan dengan: include 'header_admin.php'; 
// CATATAN: session_start() sudah dipanggil di dashboard.php

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$current_page = isset($_GET['page']) ? $_GET['page'] : 'stats';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Desa Demung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../logo.svg" type="image/x-icon">
    <style>
        /* Custom Scrollbar khusus untuk Sidebar agar elegan */
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <nav class="md:hidden bg-green-700 text-white px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-2">
            <img src="../logo.svg" alt="Logo" class="h-8 w-8 rounded-full border border-green-500">
            <span class="font-bold text-lg">Admin Panel</span>
        </div>
        <button id="mobileMenuBtn" class="focus:outline-none p-2 rounded-lg hover:bg-green-600 transition-colors">
            <i class='bx bx-menu text-3xl'></i>
        </button>
    </nav>

    <div class="flex">
        
        <aside class="hidden md:flex flex-col bg-green-700 text-white w-64 h-screen sticky top-0 shadow-xl flex-shrink-0 z-30">
            <div class="p-6 border-b border-green-600 flex-shrink-0 bg-green-700 z-10">
                <div class="flex items-center gap-3">
                    <img src="../logo.svg" alt="Logo" class="h-12 w-12 rounded-full border-2 border-green-500">
                    <div>
                        <h2 class="text-xl font-bold leading-tight">Admin Panel</h2>
                        <p class="text-xs text-green-200 font-medium">Desa Demung</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 overflow-y-auto sidebar-scroll pb-10">
                <a href="?page=stats" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'stats' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                    <i class="bx bxs-dashboard text-xl"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Manajemen Konten</p>
                    <div class="space-y-1.5">
                        <a href="?page=berita" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'berita' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-news text-xl"></i> <span>Berita</span>
                        </a>
                        <a href="?page=anggota" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'anggota' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-user-badge text-xl"></i> <span>Anggota</span>
                        </a>
                        <a href="?page=produk" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'produk' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-shopping-bag text-xl"></i> <span>Produk UMKM</span>
                        </a>
                        <a href="?page=wisata" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'wisata' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-map text-xl"></i> <span>Wisata</span>
                        </a>
                    </div>
                </div>

                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Data & Laporan</p>
                    <div class="space-y-1.5">
                        <a href="?page=statistik" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'statistik' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-bar-chart-alt-2 text-xl"></i> <span>Statistik</span>
                        </a>
                        <a href="?page=elapor" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'elapor' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                            <i class="bx bxs-message-dots text-xl"></i> <span>E-Lapor</span>
                        </a>
                    </div>
                </div>

                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Pengaturan</p>
                    <a href="?page=user" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo $current_page === 'user' ? 'bg-green-800 text-white shadow-inner font-bold' : 'text-green-100 hover:bg-green-600 font-medium'; ?>">
                        <i class="bx bxs-user text-xl"></i> <span>User Admin</span>
                    </a>
                </div>

                <div class="h-6"></div> 
            </nav>

            <div class="p-4 border-t border-green-600 flex-shrink-0 bg-green-700 z-10">
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-100 bg-red-600/20 hover:bg-red-600 hover:text-white transition-colors font-medium">
                    <i class="bx bx-log-out text-xl"></i> <span>Logout Keluar</span>
                </a>
            </div>
        </aside>

        <div id="mobileOverlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 md:hidden"></div>
        
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 w-72 bg-green-700 text-white z-50 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col shadow-2xl">
            
            <div class="p-6 border-b border-green-600 flex-shrink-0 flex justify-between items-center bg-green-700">
                <div class="flex items-center gap-3">
                    <img src="../logo.svg" alt="Logo" class="h-10 w-10 rounded-full border border-green-500"> 
                    <div>
                        <h2 class="text-lg font-bold leading-tight">Admin Panel</h2>
                    </div>
                </div>
                <button id="closeMobileBtn" class="text-green-200 hover:text-white bg-green-800 hover:bg-green-600 p-2 rounded-lg transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 overflow-y-auto sidebar-scroll pb-10">
                <a href="?page=stats" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'stats' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                    <i class="bx bxs-dashboard text-xl"></i> <span>Dashboard</span>
                </a>
                
                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Konten</p>
                    <div class="space-y-1.5">
                        <a href="?page=berita" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'berita' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-news text-xl"></i> <span>Berita</span>
                        </a>
                        <a href="?page=anggota" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'anggota' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-user-badge text-xl"></i> <span>Anggota</span>
                        </a>
                        <a href="?page=produk" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'produk' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-shopping-bag text-xl"></i> <span>Produk UMKM</span>
                        </a>
                        <a href="?page=wisata" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'wisata' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-map text-xl"></i> <span>Wisata</span>
                        </a>
                    </div>
                </div>

                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Data</p>
                    <div class="space-y-1.5">
                        <a href="?page=statistik" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'statistik' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-bar-chart-alt-2 text-xl"></i> <span>Statistik</span>
                        </a>
                        <a href="?page=elapor" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'elapor' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                            <i class="bx bxs-message-dots text-xl"></i> <span>E-Lapor</span>
                        </a>
                    </div>
                </div>

                <div class="pt-5 pb-2">
                    <p class="text-[10px] uppercase text-green-300 font-extrabold px-4 mb-3 tracking-wider">Pengaturan</p>
                    <a href="?page=user" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?php echo $current_page === 'user' ? 'bg-green-800 text-white font-bold' : 'text-green-100 hover:bg-green-600'; ?>">
                        <i class="bx bxs-user text-xl"></i> <span>User Admin</span>
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-green-600 flex-shrink-0 bg-green-700">
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-100 bg-red-600/20 hover:bg-red-600 hover:text-white transition-colors font-medium">
                    <i class="bx bx-log-out text-xl"></i> <span>Logout Keluar</span>
                </a>
            </div>
        </div>

        <script>
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeMobileBtn = document.getElementById('closeMobileBtn');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            function openMobileMenu() {
                mobileOverlay.classList.remove('hidden');
                setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
                mobileSidebar.classList.remove('-translate-x-full');
                document.body.style.overflow = 'hidden'; // Cegah body scrolling saat menu terbuka
            }

            function closeMobileMenu() {
                mobileSidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('opacity-0');
                setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }

            if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
            if (closeMobileBtn) closeMobileBtn.addEventListener('click', closeMobileMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);
        </script>

        <main class="flex-1 w-full relative min-h-screen">