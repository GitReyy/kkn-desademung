<?php
// Pastikan ini dipanggil dari dashboard.php
if (!isset($_SESSION['admin'])) {
    die("Akses ditolak.");
}

include '../koneksi.php';

// Helper function untuk keamanan
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input ?? ''));
}

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

$pesan = '';
$tipe_pesan = '';

// ==========================================
// 1. PROSES TAMBAH WISATA
// ==========================================
if (isset($_POST['tambah'])) {
    $nama = sanitize($conn, $_POST['nama']);
    $deskripsi = sanitize($conn, $_POST['deskripsi']);
    $foto = '';
    
    if (!empty($_FILES['foto']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $foto_baru = time() . '_wisata_' . rand(100,999) . '.' . $file_ext;
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
        $sql = "INSERT INTO wisata (nama, foto, deskripsi) VALUES ('$nama', '$foto', '$deskripsi')";
        if (mysqli_query($conn, $sql)) {
            $pesan = "Destinasi wisata berhasil ditambahkan!";
            $tipe_pesan = "success";
        } else {
            $pesan = "Error: " . mysqli_error($conn);
            $tipe_pesan = "error";
        }
    }
}

// ==========================================
// 2. PROSES UPDATE WISATA
// ==========================================
if (isset($_POST['update'])) {
    $id = sanitize($conn, $_POST['id']);
    $nama = sanitize($conn, $_POST['nama']);
    $deskripsi = sanitize($conn, $_POST['deskripsi']);
    $foto = sanitize($conn, $_POST['foto_lama']);
    
    if (!empty($_FILES['foto']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $foto_baru = time() . '_wisata_' . rand(100,999) . '.' . $file_ext;
            $target_dir = 'uploads/';
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_baru)) {
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
        $sql = "UPDATE wisata SET nama='$nama', foto='$foto', deskripsi='$deskripsi' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            $pesan = "Data wisata berhasil diperbarui!";
            $tipe_pesan = "success";
        } else {
            $pesan = "Error: " . mysqli_error($conn);
            $tipe_pesan = "error";
        }
    }
}

// ==========================================
// 3. PROSES HAPUS WISATA
// ==========================================
if (isset($_GET['hapus'])) {
    $id = sanitize($conn, $_GET['hapus']);
    $q_foto = mysqli_query($conn, "SELECT foto FROM wisata WHERE id='$id'");
    if ($r_foto = mysqli_fetch_assoc($q_foto)) {
        if (!empty($r_foto['foto']) && file_exists($r_foto['foto'])) {
            unlink($r_foto['foto']);
        }
    }
    mysqli_query($conn, "DELETE FROM wisata WHERE id='$id'");
    $pesan = "Destinasi wisata telah dihapus!";
    $tipe_pesan = "success";
    echo "<script>window.history.replaceState(null, null, window.location.pathname + '?page=wisata');</script>";
}

// ==========================================
// 4. FETCH DATA
// ==========================================
$edit = null;
if (isset($_GET['edit'])) {
    $id = sanitize($conn, $_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM wisata WHERE id='$id'");
    $edit = mysqli_fetch_assoc($result);
}

$wisata_list = mysqli_query($conn, "SELECT * FROM wisata ORDER BY id DESC");

$inputClass = "w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors bg-gray-50 focus:bg-white";
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
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                        <i class='bx <?php echo $edit ? 'bx-edit-alt' : 'bx-landscape'; ?>'></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        <?php echo $edit ? 'Edit Wisata' : 'Wisata Baru'; ?>
                    </h2>
                </div>

                <form method="post" action="dashboard.php?page=wisata" enctype="multipart/form-data" class="space-y-5">
                    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                    <input type="hidden" name="foto_lama" value="<?= $edit['foto'] ?? '' ?>">
                    
                    <div>
                        <label class="<?= $labelClass ?>">Nama Destinasi</label>
                        <input type="text" name="nama" placeholder="Contoh: Pantai Demung Indah" value="<?= e($edit['nama'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>

                    <div>
                        <label class="<?= $labelClass ?>">Deskripsi Wisata</label>
                        <textarea name="deskripsi" placeholder="Ceritakan daya tarik tempat ini..." required class="<?= $inputClass ?> min-h-[120px] resize-y"><?= e($edit['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="<?= $labelClass ?>">Foto Lokasi</label>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-xl cursor-pointer bg-gray-50">
                        
                        <?php if (!empty($edit['foto'])): ?>
                            <div class="mt-3 rounded-xl overflow-hidden border border-gray-200">
                                <img src="<?= e($edit['foto']) ?>" class="w-full h-32 object-cover">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-4 flex flex-col gap-3">
                        <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                            <i class='bx bx-save text-xl'></i> <?= $edit ? 'Simpan Perubahan' : 'Tambah Destinasi' ?>
                        </button>
                        <?php if ($edit): ?>
                            <a href="dashboard.php?page=wisata" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-all">Batal Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900">Daftar Objek Wisata</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 font-medium">
                            <tr>
                                <th class="px-6 py-4 w-32">Foto</th>
                                <th class="px-6 py-4">Nama & Deskripsi</th>
                                <th class="px-6 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (mysqli_num_rows($wisata_list) > 0): 
                                while ($row = mysqli_fetch_assoc($wisata_list)): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-24 h-16 rounded-lg overflow-hidden bg-gray-100 border">
                                        <?php if ($row['foto']): ?>
                                            <img src="<?= e($row['foto']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class='bx bx-image'></i></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <h4 class="font-bold text-gray-900 mb-1"><?= e($row['nama']) ?></h4>
                                    <p class="text-gray-500 text-xs line-clamp-2"><?= e($row['deskripsi']) ?></p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col gap-2">
                                        <a href="?page=wisata&edit=<?= $row['id'] ?>" class="text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all">Edit</a>
                                        <a href="?page=wisata&hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus destinasi ini?')" class="text-red-600 bg-red-50 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada data wisata.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>