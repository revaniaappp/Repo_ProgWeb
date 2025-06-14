<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT username, password, user_type, fullname 
                            FROM users 
                            WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_type']     = $user['user_type'];

            if ($user['user_type'] === 'admin') {
                header('Location: admin_header.php');
            } else {
                header('Location: home.php');
            }
            exit;

        } else {
            $error = 'Password salah.';
        }
    } else {
        $error = 'Username tidak ditemukan.';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .loginContainer {
            position: relative;
            background-color: white;
            padding: 2.5rem 2rem 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .closeButton {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 20px;
            color: #999;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .closeButton:hover {
            color: #e74c3c;
        }

        .brand {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .brand .paper {
            background-color: #2c3e50;
            color: white;
            padding: 0 6px;
            border-radius: 4px;
        }

        .brand .nest {
            color: #e74c3c;
            margin-left: 4px;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 1.5rem;
            color: #e74c3c;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.2s;
        }

        input:focus {
            border-color: #e74c3c;
            outline: none;
        }

        button {
            width: 100%;
            margin-top: 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #c0392b;
        }

        .registerLink {
            margin-top: 1.2rem;
            display: block;
            font-size: 0.95rem;
            color: #333;
            text-decoration: none;
        }

        .registerLink:hover {
            color: #e74c3c;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="loginContainer">
        <a href="#" onclick="handleClose()" class="closeButton">&times;</a>
        <div class="brand">
            <span class="paper">Paper</span><span class="nest">Nest</span>
        </div>
        <h2>Login to Your Account</h2>
        <form action="loginRegister.php" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
        <a class="registerLink" href="register.php">Don't have an account? Register here</a>
    </div>

    <script>
        function handleClose() {
            // Cek apakah ada referrer (halaman sebelumnya)
            if (document.referrer && document.referrer !== window.location.href) {
                // Cek apakah referrer bukan dari register.php untuk menghindari loop
                if (!document.referrer.includes('register.php') && 
                    !document.referrer.includes('loginRegister.php')) {
                    window.history.back();
                } else {
                    // Jika dari register atau login, redirect ke home atau halaman utama
                    window.location.href = 'index.php'; // atau 'home.php' sesuai halaman utama Anda
                }
            } else {
                // Jika tidak ada referrer, redirect ke halaman utama
                window.location.href = 'index.php'; // atau 'home.php' sesuai halaman utama Anda
            }
        }

        // Alternatif: Simpan halaman asal saat pertama kali masuk
        if (!sessionStorage.getItem('originalPage')) {
            if (document.referrer && 
                !document.referrer.includes('register.php') && 
                !document.referrer.includes('loginRegister.php')) {
                sessionStorage.setItem('originalPage', document.referrer);
            } else {
                sessionStorage.setItem('originalPage', 'index.php'); // halaman default
            }
        }

        // Fungsi alternatif yang menggunakan sessionStorage
        function handleCloseWithStorage() {
            const originalPage = sessionStorage.getItem('originalPage');
            if (originalPage) {
                window.location.href = originalPage;
                sessionStorage.removeItem('originalPage'); // bersihkan setelah digunakan
            } else {
                window.location.href = 'index.php'; // fallback
            }
        }
    </script>
</body>
</html>