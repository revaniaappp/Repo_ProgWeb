<?php
include 'config.php';

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Cek apakah username atau email sudah digunakan
        $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' OR username = '$username'") or die('Query failed');

        if (mysqli_num_rows($check_user) > 0) {
            $error = 'Username atau email sudah digunakan!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_query = "INSERT INTO users (fullname, username, email, password, user_type) 
                        VALUES ('$name', '$username', '$email', '$hashed_password', '$user_type')";
            
            $result = mysqli_query($conn, $insert_query);
            
            if ($result) {
                $success = 'Registrasi berhasil! Silakan login.';
                // Auto redirect ke login setelah 3 detik
                $redirect_url = 'loginRegister.php' . (isset($_GET['from']) ? '?from=' . urlencode($_GET['from']) : '');
                echo "<script>
                    setTimeout(function() {
                        window.location.href = '$redirect_url';
                    }, 3000);
                </script>";
            } else {
                $error = 'Registrasi gagal. Silakan coba lagi.';
            }
        }
    }
}

// Tentukan halaman tujuan untuk tombol close
$close_destination = 'index.php'; // Default ke halaman utama

// Jika ada parameter 'from' di URL, gunakan itu sebagai tujuan
if (isset($_GET['from']) && !empty($_GET['from'])) {
    $allowed_pages = ['index.php', 'home.php', 'about.php', 'contact.php', 'dashboard.php']; // Daftar halaman yang diizinkan
    $from_page = $_GET['from'];
    if (in_array($from_page, $allowed_pages)) {
        $close_destination = $from_page;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PaperNest</title>
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
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .registerContainer {
            position: relative;
            background-color: white;
            padding: 2.5rem 2rem 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
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

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background-color: #fafafa;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #e74c3c;
            background-color: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        select {
            cursor: pointer;
        }

        select option {
            padding: 10px;
        }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            text-align: left;
        }

        button {
            width: 100%;
            margin-top: 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        button:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        .loginLink {
            margin-top: 1.5rem;
            display: block;
            font-size: 14px;
            color: #666;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .loginLink:hover {
            color: #e74c3c;
            text-decoration: underline;
        }

        /* Loading state */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading button {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .registerContainer {
                padding: 2rem 1.5rem 2.5rem;
                margin: 10px;
            }
            
            .brand {
                font-size: 22px;
            }
            
            h2 {
                font-size: 18px;
            }
        }

        /* Animation for success message */
        .success {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form validation styles */
        .form-group.error input,
        .form-group.error select {
            border-color: #e74c3c;
            background-color: #fdf2f2;
        }

        .form-group.success input,
        .form-group.success select {
            border-color: #27ae60;
            background-color: #f8fff8;
        }

        /* Countdown timer */
        .countdown {
            font-weight: bold;
            color: #e74c3c;
        }
    </style>
</head>

<body>
    <div class="registerContainer">
        <a href="<?php echo $close_destination; ?>" class="closeButton" title="Close">&times;</a>
        
        <div class="brand">
            <span class="paper">Paper</span><span class="nest">Nest</span>
        </div>
        
        <h2>Create Your Account</h2>
        
        <?php if ($error): ?>
            <div class="error" role="alert">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success" role="alert">
                <strong>Success!</strong> <?php echo htmlspecialchars($success); ?>
                <br><small>Redirecting to login in <span class="countdown" id="countdown">3</span> seconds...</small>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" id="registerForm" novalidate>
            <div class="form-group">
                <label for="fullname">Full Name *</label>
                <input 
                    type="text" 
                    id="fullname"
                    name="fullname" 
                    placeholder="Enter your full name" 
                    required 
                    value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>"
                    maxlength="100"
                >
            </div>
            
            <div class="form-group">
                <label for="username">Username *</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    placeholder="Choose a username" 
                    required 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    maxlength="50"
                    pattern="[a-zA-Z0-9_]+"
                    title="Username can only contain letters, numbers, and underscores"
                >
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    placeholder="Enter your email address" 
                    required 
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    maxlength="100"
                >
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Create a strong password" 
                    required
                    minlength="6"
                >
                <div class="password-requirements">
                    Password must be at least 6 characters long
                </div>
            </div>
            
            <div class="form-group">
                <label for="user_type">User Type *</label>
                <select name="user_type" id="user_type" required>
                    <option value="">Select User Type</option>
                    <option value="user" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 'user') ? 'selected' : ''; ?>>Regular User</option>
                    <option value="admin" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 'admin') ? 'selected' : ''; ?>>Administrator</option>
                </select>
            </div>
            
            <button type="submit" name="submit" id="submitBtn">
                Create Account
            </button>
        </form>
        
        <a class="loginLink" href="loginRegister.php<?php echo isset($_GET['from']) ? '?from=' . urlencode($_GET['from']) : ''; ?>">
            Already have an account? Login here
        </a>
    </div>

    <script>
        // Form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const inputs = form.querySelectorAll('input, select');

            // Real-time validation
            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', clearError);
            });

            function validateField(e) {
                const field = e.target;
                const formGroup = field.closest('.form-group');
                
                formGroup.classList.remove('error', 'success');
                
                if (!field.value.trim() && field.hasAttribute('required')) {
                    formGroup.classList.add('error');
                } else if (field.value.trim()) {
                    if (field.type === 'email') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(field.value)) {
                            formGroup.classList.add('success');
                        } else {
                            formGroup.classList.add('error');
                        }
                    } else if (field.name === 'password') {
                        if (field.value.length >= 6) {
                            formGroup.classList.add('success');
                        } else {
                            formGroup.classList.add('error');
                        }
                    } else if (field.name === 'username') {
                        const usernameRegex = /^[a-zA-Z0-9_]+$/;
                        if (usernameRegex.test(field.value)) {
                            formGroup.classList.add('success');
                        } else {
                            formGroup.classList.add('error');
                        }
                    } else {
                        formGroup.classList.add('success');
                    }
                }
            }

            function clearError(e) {
                const formGroup = e.target.closest('.form-group');
                formGroup.classList.remove('error');
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                // Add loading state
                form.classList.add('loading');
                submitBtn.textContent = 'Creating Account...';
            });

            // Countdown timer for redirect
            <?php if ($success): ?>
            let timeLeft = 3;
            const countdownElement = document.getElementById('countdown');
            
            if (countdownElement) {
                const timer = setInterval(function() {
                    timeLeft--;
                    countdownElement.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        countdownElement.textContent = '0';
                    }
                }, 1000);
            }
            <?php endif; ?>
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>