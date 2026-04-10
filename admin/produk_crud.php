<?php
// Pastikan ini dipanggil dari dashboard.php, bukan diakses langsung
if (!isset($_SESSION['admin'])) {
    die("Akses ditolak.");
}

include '../koneksi.php';

// Helper function untuk membersihkan input
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input ?? ''));
}

// Helper untuk format teks
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

$pesan = '';
$tipe_pesan = '';

// ==========================================
// 1. PROSES TAMBAH PRODUK
// ==========================================
if (isset($_POST['tambah'])) {
    $nama = sanitize($conn, $_POST['nama']);
    $alamat = sanitize($conn, $_POST['alamat']);
    $deskripsi = sanitize($conn, $_POST['deskripsi']);
    
    // Membersihkan format nomor WA (menghapus spasi, strip, tanda plus, atau awalan 0)
    $nomor_wa_raw = sanitize($conn, $_POST['nomor_wa']);
    $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa_raw); // Hanya ambil angka
    if (substr($nomor_wa, 0, 1) === '0') {
        $nomor_wa = '62' . substr($nomor_wa, 1); // Ganti 0 depan jadi 62
    }

    $foto = '';
    
    // Keamanan Upload: Hanya izinkan gambar
    if (!empty($_FILES['foto']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $foto_baru = time() . '_umkm_' . rand(100,999) . '.' . $file_ext;
            $target_dir = 'uploads/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_baru)) {
                $foto = 'uploads/' . $foto_baru;
            }
        } else {
            $pesan = "Gagal: Format foto harus JPG, PNG, atau WEBP!";
            $tipe_pesan = "error";
        }
    }

    if (empty($pesan)) {
        $sql = "INSERT INTO produk (nama, foto, alamat, deskripsi, nomor_wa) VALUES ('$nama', '$foto', '$alamat', '$deskripsi', '$nomor_wa')";
        if (mysqli_query($conn, $sql)) {
            $pesan = "Produk UMKM berhasil ditambahkan!";
            $tipe_pesan = "success";
        } else {
            $pesan = "Error DB: " . mysqli_error($conn);
            $tipe_pesan = "error";
        }
    }
}

// ==========================================
// 2. PROSES UPDATE PRODUK
// ==========================================
if (isset($_POST['update'])) {
    $id = sanitize($conn, $_POST['id']);
    $nama = sanitize($conn, $_POST['nama']);
    $alamat = sanitize($conn, $_POST['alamat']);
    $deskripsi = sanitize($conn, $_POST['deskripsi']);
    $foto = sanitize($conn, $_POST['foto_lama']);
    
    // Membersihkan format nomor WA
    $nomor_wa_raw = sanitize($conn, $_POST['nomor_wa']);
    $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa_raw);
    if (substr($nomor_wa, 0, 1) === '0') {
        $nomor_wa = '62' . substr($nomor_wa, 1);
    }
    
    if (!empty($_FILES['foto']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $foto_baru = time() . '_umkm_' . rand(100,999) . '.' . $file_ext;
            $target_dir = 'uploads/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_baru)) {
                // Hapus foto lama jika ada
                if (!empty($foto) && file_exists($foto)) {
                    unlink($foto);
                }
                $foto = 'uploads/' . $foto_baru;
            }
        } else {
            $pesan = "Gagal: Format foto harus JPG, PNG, atau WEBP!";
            $tipe_pesan = "error";
        }
    }

    if (empty($pesan)) {
        $sql = "UPDATE produk SET nama='$nama', foto='$foto', alamat='$alamat', deskripsi='$deskripsi', nomor_wa='$nomor_wa' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            $pesan = "Data Produk UMKM berhasil diperbarui!";
            $tipe_pesan = "success";
        } else {
            $pesan = "Error DB: " . mysqli_error($conn);
            $tipe_pesan = "error";
        }
    }
}

// ==========================================
// 3. PROSES HAPUS PRODUK
// ==========================================
if (isset($_GET['hapus'])) {
    $id = sanitize($conn, $_GET['hapus']);
    
    // Cari nama file foto sebelum dihapus untuk di-unlink
    $q_foto = mysqli_query($conn, "SELECT foto FROM produk WHERE id='$id'");
    if ($r_foto = mysqli_fetch_assoc($q_foto)) {
        if (!empty($r_foto['foto']) && file_exists($r_foto['foto'])) {
            unlink($r_foto['foto']); // Hapus file fisik
        }
    }
    
    mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");
    $pesan = "Produk berhasil dihapus!";
    $tipe_pesan = "success";
    // Bersihkan URL agar tidak ke-hapus dua kali
    echo "<script>window.history.replaceState(null, null, window.location.pathname + '?page=produk');</script>";
}

// ==========================================
// 4. FETCH DATA (Untuk Form Edit & Tabel)
// ==========================================
$edit = null;
if (isset($_GET['edit'])) {
    $id = sanitize($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
    $edit = mysqli_fetch_assoc($result);
}

$produk_list = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

// Classes untuk konsistensi form
$inputClass = "w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors bg-gray-50 focus:bg-white";
$labelClass = "block text-sm font-semibold text-gray-700 mb-1.5";
?>

<div class="max-w-7xl mx-auto pb-12">
    
    <?php if ($pesan): ?>
        <div class="mb-6 p-4 rounded-xl border flex items-center justify-between shadow-sm animate-fade-in-up <?php echo $tipe_pesan === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800'; ?>">
            <div class="flex items-center gap-3">
                <i class='bx <?php echo $tipe_pesan === 'success' ? 'bxs-check-circle' : 'bxs-error-circle'; ?> text-2xl'></i>
                <span class="font-medium"><?php echo $pesan; ?></span>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="hover:opacity-70"><i class='bx bx-x text-xl'></i></button>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 sticky top-24">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl">
                        <i class='bx <?php echo $edit ? 'bx-edit-alt' : 'bxs-shopping-bag-alt'; ?>'></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        <?php echo $edit ? 'Edit Produk' : 'Tambah Produk Baru'; ?>
                    </h2>
                </div>

                <form method="post" action="dashboard.php?page=produk" enctype="multipart/form-data" class="space-y-5">
                    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                    <input type="hidden" name="foto_lama" value="<?= $edit['foto'] ?? '' ?>">
                    
                    <div>
                        <label class="<?= $labelClass ?>">Nama Produk / Usaha</label>
                        <input type="text" name="nama" placeholder="Contoh: Kripik Singkong Makmur" value="<?= e($edit['nama'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>

                    <div>
                        <label class="<?= $labelClass ?>">Alamat Lengkap / Lokasi</label>
                        <input type="text" name="alamat" placeholder="Contoh: Jl. Diponegoro RT 01/RW 02" value="<?= e($edit['alamat'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    
                    <div>
                        <label class="<?= $labelClass ?>">Deskripsi Usaha</label>
                        <textarea name="deskripsi" placeholder="Jelaskan produk, keunggulan, atau jam buka..." required class="<?= $inputClass ?> min-h-[100px] resize-y"><?= e($edit['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="<?= $labelClass ?>">Nomor WhatsApp Penjual</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-600 font-bold">
                                <i class='bx bxl-whatsapp text-lg'></i>
                            </div>
                            <input type="text" name="nomor_wa" placeholder="081234567890" value="<?= e($edit['nomor_wa'] ?? '') ?>" required class="<?= $inputClass ?> pl-11">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Gunakan awalan 08 atau 62.</p>
                    </div>

                    <div>
                        <label class="<?= $labelClass ?>">Foto Produk (Rasio Lanskap/Square)</label>
                        <input type="file" name="foto" accept="image/jpeg, image/png, image/webp" class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors border border-gray-200 rounded-xl cursor-pointer bg-gray-50 mb-3">
                        
                        <?php if (!empty($edit['foto'])): ?>
                            <div class="relative w-full h-32 rounded-xl overflow-hidden border border-gray-200 group">
                                <img src="<?= e($edit['foto']) ?>" alt="Preview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white text-xs font-semibold">Foto Saat Ini</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-4 flex flex-col gap-3">
                        <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <i class='bx bx-cloud-upload text-xl'></i> <?= $edit ? 'Simpan Perubahan' : 'Tambahkan Produk' ?>
                        </button>
                        
                        <?php if ($edit): ?>
                            <a href="dashboard.php?page=produk" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-all duration-300">
                                Batal Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Etalase UMKM Desa</h2>
                        <p class="text-sm text-gray-500 mt-1">Daftar produk usaha warga yang ditampilkan ke publik.</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class='bx bx-store text-xl'></i>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 w-24">Produk</th>
                                <th class="px-6 py-4">Informasi Bisnis</th>
                                <th class="px-6 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php 
                            if (mysqli_num_rows($produk_list) > 0):
                                while ($row = mysqli_fetch_assoc($produk_list)): 
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 align-top">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                        <?php if (!empty($row['foto'])): ?>
                                            <img src="<?= e($row['foto']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex justify-center items-center text-gray-400"><i class='bx bx-image text-2xl'></i></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 align-top">
                                    <h4 class="font-bold text-gray-900 text-base mb-1 group-hover:text-emerald-600 transition-colors">
                                        <?= e($row['nama']) ?>
                                    </h4>
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-2 font-medium">
                                        <i class='bx bxs-map text-emerald-600'></i> <?= e($row['alamat']) ?>
                                    </div>
                                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-3">
                                        <?= e($row['deskripsi']) ?>
                                    </p>
                                    
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', e($row['nomor_wa'])) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 px-2 py-1 rounded-md hover:bg-green-600 hover:text-white transition-colors border border-green-100 w-fit">
                                        <i class='bx bxl-whatsapp'></i> <?= e($row['nomor_wa']) ?>
                                    </a>
                                </td>
                                
                                <td class="px-6 py-4 align-middle text-center">
                                    <div class="flex flex-col gap-2">
                                        <a href="dashboard.php?page=produk&edit=<?= $row['id'] ?>" class="inline-flex items-center justify-center gap-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors duration-200 w-full">
                                            <i class='bx bx-edit'></i> Edit
                                        </a>
                                        <a href="dashboard.php?page=produk&hapus=<?= $row['id'] ?>" onclick="return confirm('Peringatan: Data produk UMKM ini akan dihapus secara permanen. Lanjutkan?')" class="inline-flex items-center justify-center gap-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors duration-200 w-full">
                                            <i class='bx bx-trash'></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                        <i class='bx bx-store-alt text-4xl mb-3 text-gray-300'></i>
                                        <p class="font-medium">Belum ada produk UMKM yang didaftarkan.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
/* CSS Animasi Notifikasi */
.animate-fade-in-up {
    animation: fadeInUp 0.4s ease-out forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
/* Membatasi baris teks (Tailwind line-clamp plugin polyfill) */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>