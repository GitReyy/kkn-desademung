<?php
session_start();

// Proteksi Autentikasi
if (!isset($_SESSION['admin'])) {
    header('Location: login');
    exit();
}

// Router Aman (Mencegah Local File Inclusion & Lebih Rapi dari If-Else)
$allowed_pages = [
    'berita'    => 'berita_crud.php',
    'user'      => 'user_crud.php',
    'anggota'   => 'anggota_crud.php',
    'produk'    => 'produk_crud.php',
    'wisata'    => 'wisata_crud.php',
    'statistik' => 'statistik_crud.php',
    'stats'     => 'stats.php',
    'elapor'    => 'elapor.php'
];

// Definisi Judul Halaman Otomatis
$page_titles = [
    'berita'    => 'Manajemen Berita',
    'user'      => 'Manajemen Pengguna',
    'anggota'   => 'Perangkat Desa',
    'produk'    => 'UMKM & Produk',
    'wisata'    => 'Destinasi Wisata',
    'statistik' => 'Data Statistik',
    'stats'     => 'Dashboard Analitik',
    'elapor'    => 'Laporan Masyarakat'
];

$current_page = $_GET['page'] ?? 'berita';

// Fallback jika halaman tidak valid / ada yang iseng mengubah URL
if (!array_key_exists($current_page, $allowed_pages)) {
    $current_page = 'berita';
}

$file_to_include = $allowed_pages[$current_page];
$page_title = $page_titles[$current_page];

// Include Admin Header (Sidebar, Topbar, Tag Head)
include 'header_admin.php';
?>

<main class="flex-1 bg-gray-50 min-h-screen transition-all duration-300 ease-in-out flex flex-col">
    
    <div class="bg-white border-b border-gray-100 px-6 sm:px-8 py-5 shadow-sm sticky top-0 z-30">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?php echo $page_title; ?></h1>
                <div class="text-xs sm:text-sm text-gray-500 font-medium flex items-center gap-2 mt-1.5 uppercase tracking-wide">
                    <i class='bx bx-home-alt text-gray-400'></i> Admin Panel 
                    <i class='bx bx-chevron-right text-gray-300'></i> 
                    <span class="text-emerald-600 font-bold"><?php echo $page_title; ?></span>
                </div>
            </div>
            
            <div class="hidden md:flex items-center gap-2 bg-gray-50 border border-gray-200 px-4 py-2 rounded-lg text-sm text-gray-600 font-medium">
                <i class='bx bx-calendar text-emerald-600 text-lg'></i>
                <?php 
                    setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'indonesian');
                    echo date('d F Y'); 
                ?>
            </div>
        </div>
    </div>

    <div class="p-4 sm:p-6 lg:p-8 flex-grow animate-fade-in-up">
        <?php
        // Memuat file modul CRUD sesuai request
        if (file_exists($file_to_include)) {
            include $file_to_include;
        } else {
            // Tampilan Error 404 Estetik jika file fisiknya terhapus/hilang
            echo '
            <div class="bg-white rounded-3xl shadow-sm border border-dashed border-red-300 p-12 flex flex-col items-center justify-center text-center max-w-2xl mx-auto mt-10">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-4xl mb-4">
                    <i class="bx bx-error"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Modul Tidak Ditemukan</h2>
                <p class="text-gray-500 mb-6">File sistem untuk fitur ini tidak tersedia atau telah dipindahkan.</p>
                <code class="bg-gray-100 text-red-600 font-mono px-4 py-2 rounded-lg text-sm border border-gray-200">Error: Missing '.$file_to_include.'</code>
            </div>';
        }
        ?>
    </div>
</main>

<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php 
// Include Admin Footer
include 'footer_admin.php'; 
?>