<?php
// header.php - Header universal untuk semua halaman
$is_profil_active = (strpos($_SERVER['PHP_SELF'], 'sejarah.php') !== false || 
                     strpos($_SERVER['PHP_SELF'], 'visi.php') !== false || 
                     strpos($_SERVER['PHP_SELF'], 'perangkat.php') !== false);
?>

<header id="main-header" class="bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50 transition-transform duration-500">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4 sm:px-6 lg:px-8">
        
        <a href="index.php" class="flex items-center gap-3 group">
            <img src="logo.svg" alt="Logo Desa Demung" class="h-10 w-10 md:h-12 md:w-12 rounded-full object-cover shadow-sm group-hover:shadow-md transition-shadow">
            <span class="text-xl md:text-2xl font-extrabold text-emerald-700 tracking-tight group-hover:text-emerald-800 transition-colors">Desa Demung</span>
        </a>

        <button id="navbar-toggle" type="button" class="inline-flex items-center p-2 text-gray-500 rounded-xl md:hidden hover:bg-emerald-50 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition-colors z-50" aria-label="Buka Menu">
            <i class='bx bx-menu-alt-right text-3xl'></i>
        </button>

        <nav id="navbar" class="fixed md:static top-0 right-0 h-full md:h-auto w-64 md:w-auto bg-white md:bg-transparent shadow-2xl md:shadow-none flex flex-col md:flex-row gap-2 md:gap-8 items-start md:items-center px-6 md:px-0 py-20 md:py-0 transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">

            <button id="navbar-close" type="button" class="absolute top-5 right-5 text-gray-400 hover:text-red-500 md:hidden transition-colors" aria-label="Tutup Menu">
                <i class='bx bx-x text-3xl'></i>
            </button>

            <a href="index.php" class="w-full md:w-auto py-3 md:py-0 border-b border-gray-50 md:border-none <?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">Beranda</a>

            <div class="relative group w-full md:w-auto border-b border-gray-50 md:border-none">
                <button type="button" id="profilDropdownBtn" class="flex items-center justify-between w-full md:w-auto py-3 md:py-0 focus:outline-none <?php echo $is_profil_active ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">
                    Profil Desa <i id="chevronIcon" class='bx bx-chevron-down ml-1 transition-transform duration-300 text-lg'></i>
                </button>

                <div id="profilDropdown" class="static md:absolute md:top-full md:left-1/2 md:-translate-x-1/2 mt-1 md:mt-4 w-full md:w-56 bg-white md:rounded-2xl md:shadow-xl opacity-0 pointer-events-none transition-all duration-300 z-20 border-l-2 md:border border-gray-100 overflow-hidden transform md:-translate-y-2 pl-2 md:pl-0 h-0 md:h-auto">
                    <div class="py-2 flex flex-col gap-1">
                        <a href="sejarah.php" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg mx-2 transition-colors <?php echo strpos($_SERVER['PHP_SELF'], 'sejarah.php') !== false ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium'; ?>">Sejarah Desa</a>
                        <a href="visi.php" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg mx-2 transition-colors <?php echo strpos($_SERVER['PHP_SELF'], 'visi.php') !== false ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium'; ?>">Visi & Misi</a>
                        <a href="perangkat.php" class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg mx-2 transition-colors <?php echo strpos($_SERVER['PHP_SELF'], 'perangkat.php') !== false ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium'; ?>">Perangkat Desa</a>
                    </div>
                </div>
            </div>

            <a href="potensi.php" class="w-full md:w-auto py-3 md:py-0 border-b border-gray-50 md:border-none <?php echo strpos($_SERVER['PHP_SELF'], 'potensi.php') !== false ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">Potensi Desa</a>
            <a href="statistik.php" class="w-full md:w-auto py-3 md:py-0 border-b border-gray-50 md:border-none <?php echo strpos($_SERVER['PHP_SELF'], 'statistik.php') !== false ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">Statistik</a>
            <a href="berita.php" class="w-full md:w-auto py-3 md:py-0 border-b border-gray-50 md:border-none <?php echo strpos($_SERVER['PHP_SELF'], 'berita.php') !== false ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">Berita</a>
            <a href="kontak.php" class="w-full md:w-auto py-3 md:py-0 border-b border-gray-50 md:border-none <?php echo strpos($_SERVER['PHP_SELF'], 'kontak.php') !== false ? 'text-emerald-600 font-bold' : 'text-gray-600 hover:text-emerald-600 font-medium'; ?> transition-colors">Kontak & Lapor</a>

            <div class="w-full md:w-auto pt-6 md:pt-0 mt-auto md:mt-0">
                <a href="admin/login.php" class="flex items-center justify-center gap-2 bg-emerald-600 text-white px-6 py-2.5 rounded-xl hover:bg-emerald-700 shadow-md hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 font-semibold w-full md:w-auto">
                    <i class='bx bx-lock-alt text-lg'></i> Login Admin
                </a>
            </div>
        </nav>
    </div>
</header>

<div id="navbar-overlay" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-30 hidden opacity-0 transition-opacity duration-300"></div>

<script>
    // --- FITUR SMART NAVBAR (Scroll Hide/Show) ---
    let lastScrollTop = 0;
    const header = document.getElementById('main-header');

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scroll ke bawah - Sembunyikan header
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scroll ke atas - Munculkan header
            header.style.transform = 'translateY(0)';
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Untuk menangani mobile elastic scrolling
    });

    // --- LOGIK DRAWER MOBILE MENU ---
    const navToggle = document.getElementById('navbar-toggle');
    const navClose = document.getElementById('navbar-close');
    const navbar = document.getElementById('navbar');
    const overlay = document.getElementById('navbar-overlay');

    function openMenu() {
        overlay.classList.remove('hidden');
        setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
        navbar.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        navbar.classList.add('translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => { overlay.classList.add('hidden'); }, 300);
        document.body.style.overflow = '';
    }

    if (navToggle) navToggle.addEventListener('click', openMenu);
    if (navClose) navClose.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    // --- LOGIK DROPDOWN PROFIL DESA ---
    const profilBtn = document.getElementById('profilDropdownBtn');
    const profilDropdown = document.getElementById('profilDropdown');
    const chevronIcon = document.getElementById('chevronIcon');
    let dropdownOpen = false;

    function openDropdown() {
        dropdownOpen = true;
        chevronIcon.classList.add('rotate-180');
        profilDropdown.classList.remove('opacity-0', 'pointer-events-none', 'md:-translate-y-2');
        profilDropdown.classList.add('opacity-100', 'pointer-events-auto', 'md:translate-y-0');
        if (window.innerWidth < 768) {
            profilDropdown.style.height = profilDropdown.scrollHeight + "px";
        }
    }

    function closeDropdown() {
        dropdownOpen = false;
        chevronIcon.classList.remove('rotate-180');
        profilDropdown.classList.add('opacity-0', 'pointer-events-none', 'md:-translate-y-2');
        profilDropdown.classList.remove('opacity-100', 'pointer-events-auto', 'md:translate-y-0');
        if (window.innerWidth < 768) {
            profilDropdown.style.height = "0px";
        }
    }

    if (profilBtn) {
        profilBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropdownOpen ? closeDropdown() : openDropdown();
        });
    }

    window.addEventListener('click', (e) => {
        if (dropdownOpen && !profilBtn.contains(e.target) && !profilDropdown.contains(e.target)) {
            closeDropdown();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeMenu();
            profilDropdown.style.height = "auto";
        } else {
            if(!dropdownOpen) profilDropdown.style.height = "0px";
        }
    });
</script>