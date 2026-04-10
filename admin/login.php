<?php
session_start();
include '../koneksi.php';

if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gunakan real_escape_string untuk keamanan tambahan (SQL Injection dasar)
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1");
    
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['admin'] = $row['username'];
        $session_id = session_id();
        mysqli_query($conn, "UPDATE user SET session_admin='$session_id' WHERE id=" . $row['id']);
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Desa Demung</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } } }
        }
    </script>
    
    <link rel="shortcut icon" href="../logo.svg" type="image/x-icon">
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <header class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-6">
            <a href="../index.php" class="flex items-center gap-2.5 group">
                <img src="../logo.svg" alt="Logo" class="h-10 w-10 rounded-full shadow-sm">
                <span class="text-xl font-extrabold text-emerald-700 tracking-tight">Desa Demung</span>
            </a>
            <a href="../index.php" class="text-sm font-semibold text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1">
                <i class='bx bx-arrow-back'></i> Kembali ke Web
            </a>
        </div>
    </header>
    
    <div class="flex-grow flex items-center justify-center px-4 py-12 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:20px_20px]">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-8 sm:p-10">
                    <div class="text-center mb-10">
                        <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class='bx bxs-lock-alt text-4xl text-emerald-600'></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Admin Panel</h2>
                        <p class="text-gray-500 mt-1 text-sm">Masuk untuk mengelola data desa</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-center gap-3 text-red-600 animate-pulse">
                            <i class='bx bx-error-circle text-xl'></i>
                            <span class="text-sm font-medium"><?= $error ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class='bx bx-user text-xl'></i>
                                </div>
                                <input type="text" name="username" required 
                                    class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all outline-none text-sm"
                                    placeholder="Masukkan username">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class='bx bx-key text-xl'></i>
                                </div>
                                <input type="password" name="password" id="passwordInput" required 
                                    class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all outline-none text-sm"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors">
                                    <i id="eyeIcon" class='bx bx-show text-xl'></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full bg-emerald-600 text-white py-3.5 rounded-xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            Masuk Ke Dashboard <i class='bx bx-right-arrow-alt text-xl'></i>
                        </button>
                    </form>
                </div>
                
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100">
                    <p class="text-center text-xs text-gray-500">
                        &copy; <?= date('Y') ?> Pemerintah Desa Demung. <br>
                        Hanya untuk petugas resmi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bx-show', 'bx-hide');
            } else {
                input.type = 'password';
                icon.classList.replace('bx-hide', 'bx-show');
            }
        }
    </script>

</body>
</html>