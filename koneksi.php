<?php
// koneksi.php
$host = 'localhost';
$user = 'root'; // Ganti jika username database berbeda
$pass = '';    // Ganti jika ada password database
$db   = 'desademung';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // Tampilkan error tapi jangan stop halaman sepenuhnya
    error_log('Database Connection Error: ' . mysqli_connect_error());
    $conn = null; // Set null agar bisa dicek dengan isset()
}
?>
