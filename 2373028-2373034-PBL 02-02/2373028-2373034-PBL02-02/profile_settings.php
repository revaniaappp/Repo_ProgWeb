<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: loginRegister.php');
    exit;
}

$username = $_SESSION['username'];
$message = '';
$error = '';

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (isset($_POST['update_profile'])) {
    $new_fullname = trim($_POST['fullname']);
    $new_email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!password_verify($current_password, $user['password'])) {
        $error = 'Current password is incorrect.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND username != ?");
        $stmt->bind_param("ss", $new_email, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Email already used by another account.';
        } else {
            if (empty($new_password)) {
                $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ? WHERE username = ?");
                $stmt->bind_param("sss", $new_fullname, $new_email, $username);
            } else {
                if ($new_password !== $confirm_password) {
                    $error = 'New password confirmation does not match.';
                } elseif (strlen($new_password) < 6) {
                    $error = 'New password must be at least 6 characters long.';
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, password = ? WHERE username = ?");
                    $stmt->bind_param("ssss", $new_fullname, $new_email, $hashed_password, $username);
                }
            }

            if (empty($error)) {
                if ($stmt->execute()) {
                    $_SESSION['fullname'] = $new_fullname;
                    $message = 'Profile updated successfully!';
                    $user['fullname'] = $new_fullname;
                    $user['email'] = $new_email;
                } else {
                    $error = 'Failed to update profile. Please try again.';
                }
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - PaperNest</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
        }

        .brand .paper {
            background-color: #2c3e50;
            color: white;
        }

        .brand .nest {
            color: #e74c3c;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #e74c3c;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .settings-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .settings-header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .settings-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .settings-subtitle {
            opacity: 0.9;
            font-size: 14px;
        }

        .settings-content {
            padding: 40px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e74c3c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        .form-help {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .password-section {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #e74c3c;
            color: white;
        }

        .btn-primary:hover {
            background-color: #c0392b;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
            margin-right: 10px;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .current-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3498db;
            margin-bottom: 20px;
        }

        .current-info-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .current-info-value {
            color: #34495e;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .settings-content {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .kontainerHeader {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

            .logo {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .logo span {
            color: #e74c3c;
        }

        .headerKanan {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .searchBar {
            position: relative;
            display: flex;
            align-items: center;
        }

        .searchBar input {
            padding: 8px 40px 8px 16px;
            border: none;
            border-radius: 20px;
            width: 300px;
            font-size: 14px;
        }

        .iconSearch {
            position: absolute;
            right: 12px;
            color: #7f8c8d;
            text-decoration: none;
        }

        .iconCart {
            position: relative;
        }

        .iconCart a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .cartCount {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            min-width: 18px;
            text-align: center;
        }

        .wishlistIcon a,
        .loginIcon a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }
    </style>
</head>
<body>
<header class="header">
        <div class="kontainerHeader">
            <div class="logo">Paper<span>Nest</span></div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="categories.php" class="active">Categories</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="headerKanan">
                <div class="searchBar">
                    <input type="text" placeholder="Search books...">
                    <a href="" class="iconSearch">🔍</a>
                </div>
                <div class="iconCart" id="iconCart">
                    <a href="cart.php">🛒</a>
                    <span class="cartCount" id="cartCount">2</span>
                </div>
                <div class="wishlistIcon">
                    <a href="wishlist.php" class="wishlist-link">❤️</a>
                </div>
                
                <!-- Include profile dropdown -->
                <?php include 'profile_dropdown.php'; ?>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="settings-container">
            <div class="settings-header">
                <h1 class="settings-title">Account Settings</h1>
                <p class="settings-subtitle">Manage your account information and security settings</p>
            </div>

            <div class="settings-content">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-section">
                        <h2 class="section-title">Basic Information</h2>
                        
                        <div class="current-info">
                            <div class="current-info-label">Current Username</div>
                            <div class="current-info-value"><?php echo htmlspecialchars($user['username']); ?> (Cannot be changed)</div>
                        </div>

                        <div class="form-group">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-input" 
                                value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-input" 
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">Security Settings</h2>
                        <div class="password-section">
                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-input" required>
                                <div class="form-help">Required to save any changes</div>
                            </div>

                            <div class="form-group">
                                <label for="new_password" class="form-label">New Password (Optional)</label>
                                <input type="password" id="new_password" name="new_password" class="form-input">
                                <div class="form-help">Leave blank if you don't want to change your password</div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-input">
                                <div class="form-help">Required only if you entered a new password</div>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                        <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword && confirmPassword !== '') {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('new_password').addEventListener('input', function() {
            const confirmPassword = document.getElementById('confirm_password');
            confirmPassword.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>