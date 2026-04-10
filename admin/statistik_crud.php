<?php
include '../koneksi.php';

// Helper function untuk keamanan XSS
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Helper untuk membersihkan input (Mencegah SQL Injection dasar)
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input ?? ''));
}

// Menentukan tab aktif (default 'demografi') agar tidak reset setelah submit
$active_tab = 'demografi';

// ===== DEMOGRAFI KEPENDUDUKAN =====
if (isset($_POST['tambah_demografi']) || isset($_POST['update_demografi'])) {
    $active_tab = 'demografi';
    $tahun = sanitize($conn, $_POST['tahun']);
    $total_penduduk = sanitize($conn, $_POST['total_penduduk']);
    $laki_laki = sanitize($conn, $_POST['laki_laki']);
    $perempuan = sanitize($conn, $_POST['perempuan']);
    $rasio_jenis_kelamin = sanitize($conn, $_POST['rasio_jenis_kelamin']);
    $tingkat_kelahiran = sanitize($conn, $_POST['tingkat_kelahiran']);
    $tingkat_kematian = sanitize($conn, $_POST['tingkat_kematian']);
    $penduduk_masuk = sanitize($conn, $_POST['penduduk_masuk']);
    $penduduk_keluar = sanitize($conn, $_POST['penduduk_keluar']);

    if (isset($_POST['tambah_demografi'])) {
        $sql = "INSERT INTO demografi_kependudukan (tahun, total_penduduk, laki_laki, perempuan, rasio_jenis_kelamin, tingkat_kelahiran, tingkat_kematian, penduduk_masuk, penduduk_keluar) 
                VALUES ('$tahun', '$total_penduduk', '$laki_laki', '$perempuan', '$rasio_jenis_kelamin', '$tingkat_kelahiran', '$tingkat_kematian', '$penduduk_masuk', '$penduduk_keluar')";
        $success = mysqli_query($conn, $sql) ? "Data demografi berhasil ditambahkan!" : "Error: " . mysqli_error($conn);
    } else {
        $id = sanitize($conn, $_POST['id']);
        $sql = "UPDATE demografi_kependudukan SET tahun='$tahun', total_penduduk='$total_penduduk', laki_laki='$laki_laki', perempuan='$perempuan', 
                rasio_jenis_kelamin='$rasio_jenis_kelamin', tingkat_kelahiran='$tingkat_kelahiran', tingkat_kematian='$tingkat_kematian', 
                penduduk_masuk='$penduduk_masuk', penduduk_keluar='$penduduk_keluar' WHERE id='$id'";
        $success = mysqli_query($conn, $sql) ? "Data demografi berhasil diupdate!" : "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['hapus_demografi'])) {
    $active_tab = 'demografi';
    $id = sanitize($conn, $_GET['hapus_demografi']);
    $success = mysqli_query($conn, "DELETE FROM demografi_kependudukan WHERE id='$id'") ? "Data demografi berhasil dihapus!" : "Error menghapus data.";
}

// ===== GEOSPASIAL =====
if (isset($_POST['tambah_geospasial']) || isset($_POST['update_geospasial'])) {
    $active_tab = 'geospasial';
    $nama_lokasi = sanitize($conn, $_POST['nama_lokasi']);
    $jenis_data = sanitize($conn, $_POST['jenis_data']);
    $latitude = sanitize($conn, $_POST['latitude']);
    $longitude = sanitize($conn, $_POST['longitude']);
    $kondisi = sanitize($conn, $_POST['kondisi']);
    $deskripsi = sanitize($conn, $_POST['deskripsi']);
    
    $gambar = isset($_POST['gambar_lama']) ? sanitize($conn, $_POST['gambar_lama']) : '';
    
    // Keamanan Upload: Cek ekstensi file
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_ext)) {
            $gambar_baru = time() . '_' . basename($_FILES['gambar']['name']);
            $target_dir = '../admin/uploads/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_dir . $gambar_baru)) {
                $gambar = 'uploads/' . $gambar_baru;
            }
        } else {
            $error = "Format gambar tidak didukung! Gunakan JPG, PNG, atau WEBP.";
        }
    }

    if (!isset($error)) {
        if (isset($_POST['tambah_geospasial'])) {
            $sql = "INSERT INTO geospasial_infrastruktur (nama_lokasi, jenis_data, latitude, longitude, kondisi, deskripsi, gambar) 
                    VALUES ('$nama_lokasi', '$jenis_data', '$latitude', '$longitude', '$kondisi', '$deskripsi', '$gambar')";
            $success = mysqli_query($conn, $sql) ? "Data geospasial berhasil ditambahkan!" : "Error: " . mysqli_error($conn);
        } else {
            $id = sanitize($conn, $_POST['id']);
            $sql = "UPDATE geospasial_infrastruktur SET nama_lokasi='$nama_lokasi', jenis_data='$jenis_data', latitude='$latitude', longitude='$longitude', 
                    kondisi='$kondisi', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'";
            $success = mysqli_query($conn, $sql) ? "Data geospasial berhasil diupdate!" : "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_GET['hapus_geospasial'])) {
    $active_tab = 'geospasial';
    $id = sanitize($conn, $_GET['hapus_geospasial']);
    $success = mysqli_query($conn, "DELETE FROM geospasial_infrastruktur WHERE id='$id'") ? "Data geospasial berhasil dihapus!" : "Error menghapus data.";
}

// ===== SOSIAL EKONOMI PENDIDIKAN =====
if (isset($_POST['tambah_sosial']) || isset($_POST['update_sosial'])) {
    $active_tab = 'sosial';
    $tahun = sanitize($conn, $_POST['tahun']);
    $kategori = sanitize($conn, $_POST['kategori']);
    $pendapatan_rata_rata = sanitize($conn, $_POST['pendapatan_rata_rata']);
    $kepemilikan_aset = sanitize($conn, $_POST['kepemilikan_aset']);
    $desil_kemiskinan = sanitize($conn, $_POST['desil_kemiskinan']);
    $jumlah_termasuk_miskin = sanitize($conn, $_POST['jumlah_termasuk_miskin']);
    $partisipasi_sekolah_anak = sanitize($conn, $_POST['partisipasi_sekolah_anak']);
    $tingkat_pendidikan = sanitize($conn, $_POST['tingkat_pendidikan']);
    $data_detail = sanitize($conn, $_POST['data_detail']);

    if (isset($_POST['tambah_sosial'])) {
        $sql = "INSERT INTO sosial_ekonomi_pendidikan (tahun, kategori, pendapatan_rata_rata, kepemilikan_aset, desil_kemiskinan, jumlah_termasuk_miskin, partisipasi_sekolah_anak, tingkat_pendidikan, data_detail) 
                VALUES ('$tahun', '$kategori', '$pendapatan_rata_rata', '$kepemilikan_aset', '$desil_kemiskinan', '$jumlah_termasuk_miskin', '$partisipasi_sekolah_anak', '$tingkat_pendidikan', '$data_detail')";
        $success = mysqli_query($conn, $sql) ? "Data sosial-ekonomi berhasil ditambahkan!" : "Error: " . mysqli_error($conn);
    } else {
        $id = sanitize($conn, $_POST['id']);
        $sql = "UPDATE sosial_ekonomi_pendidikan SET tahun='$tahun', kategori='$kategori', pendapatan_rata_rata='$pendapatan_rata_rata', kepemilikan_aset='$kepemilikan_aset', 
                desil_kemiskinan='$desil_kemiskinan', jumlah_termasuk_miskin='$jumlah_termasuk_miskin', partisipasi_sekolah_anak='$partisipasi_sekolah_anak', 
                tingkat_pendidikan='$tingkat_pendidikan', data_detail='$data_detail' WHERE id='$id'";
        $success = mysqli_query($conn, $sql) ? "Data sosial-ekonomi berhasil diupdate!" : "Error: " . mysqli_error($conn);
    }
}

if (isset($_GET['hapus_sosial'])) {
    $active_tab = 'sosial';
    $id = sanitize($conn, $_GET['hapus_sosial']);
    $success = mysqli_query($conn, "DELETE FROM sosial_ekonomi_pendidikan WHERE id='$id'") ? "Data sosial-ekonomi berhasil dihapus!" : "Error menghapus data.";
}

// Penentuan Edit Mode & Overriding Active Tab
$edit_demografi = null;
$edit_geospasial = null;
$edit_sosial = null;

if (isset($_GET['edit_demografi'])) {
    $active_tab = 'demografi';
    $id = sanitize($conn, $_GET['edit_demografi']);
    $result = mysqli_query($conn, "SELECT * FROM demografi_kependudukan WHERE id='$id'");
    $edit_demografi = mysqli_fetch_assoc($result);
}

if (isset($_GET['edit_geospasial'])) {
    $active_tab = 'geospasial';
    $id = sanitize($conn, $_GET['edit_geospasial']);
    $result = mysqli_query($conn, "SELECT * FROM geospasial_infrastruktur WHERE id='$id'");
    $edit_geospasial = mysqli_fetch_assoc($result);
}

if (isset($_GET['edit_sosial'])) {
    $active_tab = 'sosial';
    $id = sanitize($conn, $_GET['edit_sosial']);
    $result = mysqli_query($conn, "SELECT * FROM sosial_ekonomi_pendidikan WHERE id='$id'");
    $edit_sosial = mysqli_fetch_assoc($result);
}

// Classes untuk input agar konsisten
$inputClass = "w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-gray-50 focus:bg-white";
$labelClass = "block text-sm font-semibold text-gray-700 mb-1";
?>

<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex items-center gap-3 mb-8">
        <div class="p-3 bg-green-100 text-green-700 rounded-lg">
            <i class="bx bx-data text-2xl"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pusat Manajemen Data</h2>
            <p class="text-sm text-gray-500">Kelola data statistik desa secara terpadu</p>
        </div>
    </div>

    <?php if (isset($success)): ?>
        <div class="bg-green-50 text-green-800 border-l-4 border-green-500 p-4 mb-6 rounded-r shadow-sm flex items-center justify-between" role="alert">
            <div class="flex items-center">
                <i class='bx bxs-check-circle text-xl mr-2'></i>
                <p class="font-medium"><?php echo $success; ?></p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800"><i class='bx bx-x text-xl'></i></button>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="bg-red-50 text-red-800 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-sm flex items-center justify-between" role="alert">
            <div class="flex items-center">
                <i class='bx bxs-error-circle text-xl mr-2'></i>
                <p class="font-medium"><?php echo $error; ?></p>
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-red-600 hover:text-red-800"><i class='bx bx-x text-xl'></i></button>
        </div>
    <?php endif; ?>

    <div class="flex gap-1 mb-6 border-b border-gray-200 overflow-x-auto">
        <button onclick="switchTab('demografi')" id="tab-demografi" class="px-5 py-3 font-semibold transition-colors flex items-center gap-2 whitespace-nowrap">
            <i class="bx bxs-bar-chart-alt-2"></i> Kependudukan
        </button>
        <button onclick="switchTab('geospasial')" id="tab-geospasial" class="px-5 py-3 font-semibold transition-colors flex items-center gap-2 whitespace-nowrap">
            <i class="bx bxs-map-alt"></i> Geospasial
        </button>
        <button onclick="switchTab('sosial')" id="tab-sosial" class="px-5 py-3 font-semibold transition-colors flex items-center gap-2 whitespace-nowrap">
            <i class="bx bxs-wallet-alt"></i> Sosial Ekonomi
        </button>
    </div>

    <div id="demografi" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="bx <?= $edit_demografi ? 'bx-edit text-blue-600' : 'bx-plus-circle text-green-600' ?>"></i>
                <?= $edit_demografi ? 'Edit Data Demografi' : 'Entri Data Demografi Baru'; ?>
            </h3>
            
            <form method="post" action="?page=statistik&tab=demografi" class="space-y-6">
                <input type="hidden" name="id" value="<?= $edit_demografi['id'] ?? '' ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Tahun Pencatatan</label>
                        <input type="number" name="tahun" value="<?= e($edit_demografi['tahun'] ?? date('Y')) ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Total Penduduk</label>
                        <input type="number" name="total_penduduk" value="<?= e($edit_demografi['total_penduduk'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Rasio Jenis Kelamin</label>
                        <input type="number" step="0.01" name="rasio_jenis_kelamin" placeholder="Laki per 100 Pr" value="<?= e($edit_demografi['rasio_jenis_kelamin'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Laki-laki</label>
                        <input type="number" name="laki_laki" value="<?= e($edit_demografi['laki_laki'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Perempuan</label>
                        <input type="number" name="perempuan" value="<?= e($edit_demografi['perempuan'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Tingkat Kelahiran (%)</label>
                        <input type="number" step="0.01" name="tingkat_kelahiran" value="<?= e($edit_demografi['tingkat_kelahiran'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Tingkat Kematian (%)</label>
                        <input type="number" step="0.01" name="tingkat_kematian" value="<?= e($edit_demografi['tingkat_kematian'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Penduduk Masuk (Migrasi In)</label>
                        <input type="number" name="penduduk_masuk" value="<?= e($edit_demografi['penduduk_masuk'] ?? 0) ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Penduduk Keluar (Migrasi Out)</label>
                        <input type="number" name="penduduk_keluar" value="<?= e($edit_demografi['penduduk_keluar'] ?? 0) ?>" required class="<?= $inputClass ?>">
                    </div>
                </div>
                
                <div class="pt-4 border-t border-gray-100 flex gap-3">
                    <button type="submit" name="<?= $edit_demografi ? 'update_demografi' : 'tambah_demografi' ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class='bx bx-save'></i> <?= $edit_demografi ? 'Simpan Perubahan' : 'Simpan Data'; ?>
                    </button>
                    <?php if ($edit_demografi): ?>
                        <a href="?page=statistik&tab=demografi" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-colors">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4 text-center">L/P</th>
                            <th class="px-6 py-4 text-center">Rasio JK</th>
                            <th class="px-6 py-4 text-center">L/M (%)</th>
                            <th class="px-6 py-4 text-center">Migrasi (+/-)</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $demografi = mysqli_query($conn, "SELECT * FROM demografi_kependudukan ORDER BY tahun DESC");
                        if(mysqli_num_rows($demografi) > 0):
                            while ($row = mysqli_fetch_assoc($demografi)): 
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-gray-800"><?= e($row['tahun']) ?></td>
                            <td class="px-6 py-3 text-right font-medium"><?= number_format($row['total_penduduk'], 0, ',', '.') ?></td>
                            <td class="px-6 py-3 text-center text-gray-600"><?= number_format($row['laki_laki']) ?> / <?= number_format($row['perempuan']) ?></td>
                            <td class="px-6 py-3 text-center"><span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-semibold"><?= e($row['rasio_jenis_kelamin']) ?></span></td>
                            <td class="px-6 py-3 text-center text-gray-600"><?= e($row['tingkat_kelahiran']) ?> / <?= e($row['tingkat_kematian']) ?></td>
                            <td class="px-6 py-3 text-center text-gray-600">+<?= number_format($row['penduduk_masuk']) ?> / -<?= number_format($row['penduduk_keluar']) ?></td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="?page=statistik&edit_demografi=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded transition-colors" title="Edit"><i class='bx bx-edit-alt text-lg'></i></a>
                                    <a href="?page=statistik&hapus_demografi=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data tahun <?= e($row['tahun']) ?>?')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1.5 rounded transition-colors" title="Hapus"><i class='bx bx-trash text-lg'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data terekam.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="geospasial" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="bx <?= $edit_geospasial ? 'bx-edit text-emerald-600' : 'bx-plus-circle text-emerald-600' ?>"></i>
                <?= $edit_geospasial ? 'Edit Titik Geospasial' : 'Entri Titik Geospasial Baru'; ?>
            </h3>
            
            <form method="post" action="?page=statistik&tab=geospasial" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id" value="<?= $edit_geospasial['id'] ?? '' ?>">
                <input type="hidden" name="gambar_lama" value="<?= e($edit_geospasial['gambar'] ?? '') ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Nama Lokasi / Infrastruktur</label>
                        <input type="text" name="nama_lokasi" value="<?= e($edit_geospasial['nama_lokasi'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Kategori / Jenis Data</label>
                        <select name="jenis_data" required class="<?= $inputClass ?>">
                            <option value="">Pilih Kategori</option>
                            <?php 
                            $options = [
                                'batas_wilayah' => 'Batas Wilayah', 
                                'tata_guna_lahan' => 'Tata Guna Lahan', 
                                'fasilitas_umum' => 'Fasilitas Umum', 
                                'infrastruktur' => 'Infrastruktur Publik'
                            ];
                            foreach($options as $val => $label) {
                                $selected = ($edit_geospasial['jenis_data'] ?? '') === $val ? 'selected' : '';
                                echo "<option value=\"$val\" $selected>$label</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Latitude (Titik Y)</label>
                        <input type="number" step="any" name="latitude" value="<?= e($edit_geospasial['latitude'] ?? '') ?>" class="<?= $inputClass ?>" placeholder="-7.xxxx">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Longitude (Titik X)</label>
                        <input type="number" step="any" name="longitude" value="<?= e($edit_geospasial['longitude'] ?? '') ?>" class="<?= $inputClass ?>" placeholder="113.xxxx">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Kondisi Fisik</label>
                        <input type="text" name="kondisi" value="<?= e($edit_geospasial['kondisi'] ?? '') ?>" class="<?= $inputClass ?>" placeholder="Contoh: Baik, Rusak Ringan">
                    </div>
                </div>

                <div>
                    <label class="<?= $labelClass ?>">Deskripsi Detail</label>
                    <textarea name="deskripsi" class="<?= $inputClass ?> min-h-[100px] resize-y"><?= e($edit_geospasial['deskripsi'] ?? '') ?></textarea>
                </div>

                <div>
                    <label class="<?= $labelClass ?>">Foto Dokumentasi (Opsional)</label>
                    <input type="file" name="gambar" accept="image/jpeg, image/png, image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                    <?php if(!empty($edit_geospasial['gambar'])): ?>
                        <p class="text-xs text-gray-500 mt-2">File saat ini: <?= basename(e($edit_geospasial['gambar'])) ?>. Upload baru untuk mengganti.</p>
                    <?php endif; ?>
                </div>

                <div class="pt-4 border-t border-gray-100 flex gap-3">
                    <button type="submit" name="<?= $edit_geospasial ? 'update_geospasial' : 'tambah_geospasial' ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class='bx bx-save'></i> <?= $edit_geospasial ? 'Simpan Perubahan' : 'Simpan Data'; ?>
                    </button>
                    <?php if ($edit_geospasial): ?>
                        <a href="?page=statistik&tab=geospasial" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-colors">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4">Informasi Lokasi</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Koordinat</th>
                            <th class="px-6 py-4">Kondisi</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $geospasial = mysqli_query($conn, "SELECT * FROM geospasial_infrastruktur ORDER BY jenis_data ASC, nama_lokasi ASC");
                        if(mysqli_num_rows($geospasial) > 0):
                            while ($row = mysqli_fetch_assoc($geospasial)): 
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800"><?= e($row['nama_lokasi']) ?></div>
                                <div class="text-xs text-gray-500 truncate max-w-xs" title="<?= e($row['deskripsi']) ?>"><?= e($row['deskripsi']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-2 py-1 rounded text-xs font-semibold"><?= ucwords(str_replace('_', ' ', e($row['jenis_data']))) ?></span></td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-600">
                                <?= $row['latitude'] ? round($row['latitude'], 5) . ',<br>' . round($row['longitude'], 5) : '<span class="italic text-gray-400">N/A</span>' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($row['kondisi']): ?>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-gray-400"></span><?= e($row['kondisi']) ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="?page=statistik&edit_geospasial=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded transition-colors" title="Edit"><i class='bx bx-edit-alt text-lg'></i></a>
                                    <a href="?page=statistik&hapus_geospasial=<?= $row['id'] ?>" onclick="return confirm('Hapus data lokasi <?= e($row['nama_lokasi']) ?>?')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1.5 rounded transition-colors" title="Hapus"><i class='bx bx-trash text-lg'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pemetaan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="sosial" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="bx <?= $edit_sosial ? 'bx-edit text-orange-600' : 'bx-plus-circle text-orange-600' ?>"></i>
                <?= $edit_sosial ? 'Edit Data Sosial-Ekonomi' : 'Entri Data Sosial-Ekonomi'; ?>
            </h3>
            
            <form method="post" action="?page=statistik&tab=sosial" class="space-y-6">
                <input type="hidden" name="id" value="<?= $edit_sosial['id'] ?? '' ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Tahun</label>
                        <input type="number" name="tahun" value="<?= e($edit_sosial['tahun'] ?? date('Y')) ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Kategori (Pekerjaan Utama/Klaster)</label>
                        <input type="text" name="kategori" value="<?= e($edit_sosial['kategori'] ?? 'Umum') ?>" required class="<?= $inputClass ?>" placeholder="Contoh: Petani, Buruh, Umum">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Pendapatan Rata-rata per Kapita (Rp)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">Rp</div>
                            <input type="number" name="pendapatan_rata_rata" value="<?= e($edit_sosial['pendapatan_rata_rata'] ?? '') ?>" required class="<?= $inputClass ?> pl-10">
                        </div>
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Profil Kepemilikan Aset Dominan</label>
                        <input type="text" name="kepemilikan_aset" value="<?= e($edit_sosial['kepemilikan_aset'] ?? '') ?>" class="<?= $inputClass ?>" placeholder="Rumah sendiri, motor, dll">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="<?= $labelClass ?>">Desil Kemiskinan Dominan</label>
                        <select name="desil_kemiskinan" required class="<?= $inputClass ?>">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($edit_sosial['desil_kemiskinan'] ?? '') == $i ? 'selected' : '' ?>>Desil <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Jumlah KK Termasuk Miskin</label>
                        <input type="number" name="jumlah_termasuk_miskin" value="<?= e($edit_sosial['jumlah_termasuk_miskin'] ?? 0) ?>" required class="<?= $inputClass ?>">
                    </div>
                    <div>
                        <label class="<?= $labelClass ?>">Partisipasi Sekolah Anak (%)</label>
                        <input type="number" step="0.01" max="100" name="partisipasi_sekolah_anak" value="<?= e($edit_sosial['partisipasi_sekolah_anak'] ?? '') ?>" required class="<?= $inputClass ?>">
                    </div>
                </div>

                <div>
                    <label class="<?= $labelClass ?>">Tingkat Pendidikan Rata-rata</label>
                    <input type="text" name="tingkat_pendidikan" value="<?= e($edit_sosial['tingkat_pendidikan'] ?? '') ?>" class="<?= $inputClass ?>" placeholder="Contoh: SD/Sederajat">
                </div>
                
                <div>
                    <label class="<?= $labelClass ?>">Catatan Analisis</label>
                    <textarea name="data_detail" class="<?= $inputClass ?> min-h-[100px] resize-y" placeholder="Temuan penting di lapangan..."><?= e($edit_sosial['data_detail'] ?? '') ?></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex gap-3">
                    <button type="submit" name="<?= $edit_sosial ? 'update_sosial' : 'tambah_sosial' ?>" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        <i class='bx bx-save'></i> <?= $edit_sosial ? 'Simpan Perubahan' : 'Simpan Data'; ?>
                    </button>
                    <?php if ($edit_sosial): ?>
                        <a href="?page=statistik&tab=sosial" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition-colors">Batal Edit</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Tahun / Kategori</th>
                            <th class="px-6 py-4 text-right">Pendapatan/Kapita</th>
                            <th class="px-6 py-4 text-center">Desil</th>
                            <th class="px-6 py-4 text-right">KK Miskin</th>
                            <th class="px-6 py-4 text-center">Partisipasi Edukasi</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $sosial = mysqli_query($conn, "SELECT * FROM sosial_ekonomi_pendidikan ORDER BY tahun DESC");
                        if(mysqli_num_rows($sosial) > 0):
                            while ($row = mysqli_fetch_assoc($sosial)): 
                        ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-800"><?= e($row['tahun']) ?></div>
                                <div class="text-xs text-gray-500"><?= e($row['kategori']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-gray-700">Rp <?= number_format($row['pendapatan_rata_rata'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-orange-100 text-orange-800 px-2.5 py-1 rounded-md text-xs font-bold border border-orange-200">D-<?= e($row['desil_kemiskinan']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600"><?= number_format($row['jumlah_termasuk_miskin'], 0, ',', '.') ?> KK</td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <span class="font-semibold <?= $row['partisipasi_sekolah_anak'] < 80 ? 'text-red-600' : 'text-green-600' ?>"><?= e($row['partisipasi_sekolah_anak']) ?>%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="?page=statistik&edit_sosial=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded transition-colors" title="Edit"><i class='bx bx-edit-alt text-lg'></i></a>
                                    <a href="?page=statistik&hapus_sosial=<?= $row['id'] ?>" onclick="return confirm('Hapus data tahun <?= e($row['tahun']) ?>?')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1.5 rounded transition-colors" title="Hapus"><i class='bx bx-trash text-lg'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        else: 
                        ?>
                            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pendataan sosial.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi Switch Tab yang disempurnakan dengan Styling Tailwind
function switchTab(tabName) {
    // Sembunyikan semua konten tab
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Reset styling semua tombol tab
    const tabs = {
        'demografi': { btn: 'tab-demografi', activeColor: 'text-blue-700', activeBorder: 'border-blue-600' },
        'geospasial': { btn: 'tab-geospasial', activeColor: 'text-emerald-700', activeBorder: 'border-emerald-600' },
        'sosial': { btn: 'tab-sosial', activeColor: 'text-orange-700', activeBorder: 'border-orange-600' }
    };

    Object.keys(tabs).forEach(key => {
        const btn = document.getElementById(tabs[key].btn);
        // Reset state
        btn.className = 'px-5 py-3 font-semibold transition-colors flex items-center gap-2 whitespace-nowrap text-gray-500 hover:bg-gray-50 hover:text-gray-700 border-b-2 border-transparent';
    });
    
    // Tampilkan konten tab yang dipilih
    document.getElementById(tabName).classList.remove('hidden');
    
    // Berikan styling aktif pada tombol yang ditekan (warna berbeda tiap kategori agar intuitif)
    const activeBtn = document.getElementById(tabs[tabName].btn);
    activeBtn.className = `px-5 py-3 font-semibold transition-colors flex items-center gap-2 whitespace-nowrap ${tabs[tabName].activeColor} border-b-2 ${tabs[tabName].activeBorder} bg-white`;
    
    // Update URL agar jika user merefresh, tab tidak berubah (tanpa mereload halaman)
    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.pushState({}, '', url);
}

// Inisialisasi tab berdasarkan variable PHP $active_tab
document.addEventListener("DOMContentLoaded", () => {
    switchTab('<?= $active_tab ?>');
});
</script>