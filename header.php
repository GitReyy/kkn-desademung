<?php
// header.php - Header universal
$currentPage = basename($_SERVER['PHP_SELF']);

// 1. REFAKTOR: Pindahkan semua logika pengecekan "Active" ke atas agar HTML lebih bersih
$is_beranda_active   = ($currentPage === 'index.php');
$is_profil_active    = in_array($currentPage, ['sejarah.php', 'visi.php', 'perangkat.php']);
$is_potensi_active   = ($currentPage === 'potensi.php');
$is_statistik_active = ($currentPage === 'statistik.php');
// Cek array agar 'detail_berita' juga membuat menu Berita menyala
$is_berita_active    = in_array($currentPage, ['berita.php', 'detail_berita.php']); 
$is_kontak_active    = ($currentPage === 'kontak.php');

// Helper variable untuk class navigasi agar HTML lebih bersih
$navClass_Base = "flex items-center w-full md:w-auto px-4 py-3 md:px-3 lg:px-4 md:py-2.5 rounded-xl md:rounded-full font-semibold text-[15px] transition-all duration-300 whitespace-nowrap cursor-pointer ";
$navClass_Active = $navClass_Base . "bg-emerald-50 text-emerald-700 md:bg-emerald-50/80 md:text-emerald-700";
$navClass_Inactive = $navClass_Base . "text-gray-600 hover:bg-gray-50 md:hover:bg-emerald-50/60 hover:text-emerald-600";

// Fungsi helper untuk menentukan class berdasarkan status aktif
function getNavClass($isActive, $activeClass, $inactiveClass) {
    return $isActive ? $activeClass : $inactiveClass;
}
?>

<header id="main-header" class="bg-white/95 backdrop-blur-lg shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border-b border-gray-100/50 sticky top-0 z-[60] transition-transform duration-500">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-3.5 px-4 sm:px-6 lg:px-8">
        
        <a href="index.php" class="flex items-center gap-3 group flex-shrink-0">
            <div class="w-10 h-10 md:w-11 md:h-11 rounded-full overflow-hidden shadow-sm group-hover:shadow-md transition-shadow bg-white flex items-center justify-center p-0.5 border border-gray-50">
                <img src="logo.svg" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="text-xl md:text-2xl font-extrabold text-emerald-700 tracking-tight group-hover:text-emerald-800 transition-colors leading-none mb-0.5">Desa Demung</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest hidden md:block">Portal Resmi</span>
            </div>
        </a>

        <button id="navbar-toggle" type="button" class="inline-flex items-center p-2 text-gray-500 rounded-xl md:hidden hover:bg-emerald-50 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100 transition-colors relative z-[60]" aria-label="Buka Menu">
            <i class='bx bx-menu-alt-right text-3xl'></i>
        </button>

        <div id="navbar-overlay" class="fixed inset-0 w-screen h-screen bg-gray-900/60 backdrop-blur-sm hidden opacity-0 pointer-events-none transition-opacity duration-300 md:hidden" style="z-index: 60; top: 0; left: 0;"></div>

        <nav id="navbar" class="fixed md:static top-0 right-0 h-[100dvh] md:h-auto w-[85vw] max-w-sm md:w-auto bg-white md:bg-transparent shadow-2xl md:shadow-none flex flex-col md:flex-row items-start md:items-center transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto md:overflow-visible md:flex-1 md:justify-end" style="z-index: 70;">

            <div class="flex items-center justify-between w-full px-6 py-5 border-b border-gray-100 md:hidden flex-shrink-0">
                <span class="font-bold text-emerald-700 text-lg">Menu Navigasi</span>
                <button id="navbar-close" type="button" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-lg transition-colors" aria-label="Tutup Menu">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <div class="w-full px-6 py-4 md:p-0 flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-1 lg:gap-2 flex-grow md:flex-grow-0">
                
                <a href="index.php" class="<?= getNavClass($is_beranda_active, $navClass_Active, $navClass_Inactive) ?>">Beranda</a>

                <div class="relative group w-full md:w-auto">
                    <button type="button" id="profilDropdownBtn" class="justify-between focus:outline-none <?= getNavClass($is_profil_active, $navClass_Active, $navClass_Inactive) ?>">
                        <span>Profil Desa</span> 
                        <i id="chevronIcon" class='bx bx-chevron-down text-xl md:text-lg ml-1.5 transition-transform duration-300 opacity-60'></i>
                    </button>

                    <div id="profilDropdown" class="static md:absolute md:top-full md:left-1/2 md:-translate-x-1/2 mt-1 md:mt-3 w-full md:w-56 bg-gray-50 md:bg-white/95 md:backdrop-blur-xl md:rounded-2xl md:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] opacity-0 pointer-events-none transition-all duration-300 z-20 border-l-2 border-gray-200/50 md:border md:border-gray-100 overflow-hidden transform md:-translate-y-2 h-0 md:h-auto">
                        <div class="p-2 flex flex-col gap-1">
                            <a href="sejarah.php" class="block px-4 py-3 md:py-2.5 text-[14px] text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 md:rounded-xl mx-0 md:mx-1 transition-colors <?= $currentPage === 'sejarah.php' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium' ?>">Sejarah Desa</a>
                            <a href="visi.php" class="block px-4 py-3 md:py-2.5 text-[14px] text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 md:rounded-xl mx-0 md:mx-1 transition-colors <?= $currentPage === 'visi.php' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium' ?>">Visi & Misi</a>
                            <a href="perangkat.php" class="block px-4 py-3 md:py-2.5 text-[14px] text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 md:rounded-xl mx-0 md:mx-1 transition-colors <?= $currentPage === 'perangkat.php' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'font-medium' ?>">Perangkat Desa</a>
                        </div>
                    </div>
                </div>

                <a href="potensi.php" class="<?= getNavClass($is_potensi_active, $navClass_Active, $navClass_Inactive) ?>">Potensi</a>
                <a href="statistik.php" class="<?= getNavClass($is_statistik_active, $navClass_Active, $navClass_Inactive) ?>">Statistik</a>
                <a href="berita.php" class="<?= getNavClass($is_berita_active, $navClass_Active, $navClass_Inactive) ?>" style="pointer-events: auto; position: relative; z-index: 10;">Berita</a>
                <a href="kontak.php" class="<?= getNavClass($is_kontak_active, $navClass_Active, $navClass_Inactive) ?>" style="pointer-events: auto; position: relative; z-index: 10;">Kontak</a>

            </div>

            <div class="w-full px-6 pb-8 md:p-0 md:ml-4 mt-auto md:mt-0 flex-shrink-0 flex items-center justify-end">
                <a href="admin/login.php" class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 text-white px-5 py-2.5 md:px-5 md:py-2 rounded-xl md:rounded-full hover:bg-emerald-700 shadow-[0_4px_14px_0_rgba(5,150,105,0.39)] hover:shadow-[0_6px_20px_rgba(5,150,105,0.23)] hover:-translate-y-0.5 transition-all duration-300 font-semibold text-sm w-max active:scale-95">
                    <i class='bx bx-lock-alt text-base'></i> 
                    <span>Login Admin</span>
                </a>
            </div>

        </nav>
    </div>
</header>

<style>
    /* Override untuk memastikan Berita dan Kontak selalu clickable */
    a[href="berita.php"],
    a[href="kontak.php"] {
        pointer-events: auto !important;
        cursor: pointer !important;
        display: block !important;
        position: relative !important;
        z-index: 50 !important;
    }
</style>

<script>
    // --- FITUR SMART NAVBAR (Scroll Hide/Show) ---
    let lastScrollTop = 0;
    const header = document.getElementById('main-header');

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (!document.body.style.overflow) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; 
    });

    // --- LOGIK DRAWER MOBILE MENU ---
    const navToggle = document.getElementById('navbar-toggle');
    const navClose = document.getElementById('navbar-close');
    const navbar = document.getElementById('navbar');
    const overlay = document.getElementById('navbar-overlay');

    function openMenu() {
        header.style.transform = 'translateY(0)';
        overlay.classList.remove('hidden', 'pointer-events-none');
        setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
        navbar.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        navbar.classList.add('translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => { overlay.classList.add('hidden', 'pointer-events-none'); }, 300);
        document.body.style.overflow = '';
    }

    if (navToggle) navToggle.addEventListener('click', openMenu);
    if (navClose) navClose.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    // 3. REFAKTOR JS: Cegah Desktop memanggil closeMenu()
    // Menjalankan animasi close hanya untuk layar HP agar tidak menginterupsi klik Desktop
    const navLinks = navbar.querySelectorAll('a[href]');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Tutup dropdown jika terbuka
            if (dropdownOpen) {
                closeDropdown();
            }
            // Tutup menu mobile
            if (window.innerWidth < 768) {
                closeMenu();
            }
        });
    });

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