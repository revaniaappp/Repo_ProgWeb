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
$fullname = $_SESSION['fullname'];
$userType = $_SESSION['user_type'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - PaperNest</title>
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

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .profile-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            font-weight: bold;
            border: 4px solid rgba(255,255,255,0.3);
        }

        .profile-name {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-username {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .user-badge {
            display: inline-block;
            background-color: rgba(255,255,255,0.2);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .profile-content {
            padding: 40px;
        }

        .profile-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e74c3c;
            display: inline-block;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
        }

        .info-label {
            font-weight: 600;
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
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
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .profile-header {
                padding: 20px;
            }

            .profile-content {
                padding: 20px;
            }

            .action-buttons {
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
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php echo strtoupper(substr($fullname, 0, 1)); ?>
                </div>
                <div class="profile-name"><?php echo htmlspecialchars($fullname); ?></div>
                <div class="profile-username">@<?php echo htmlspecialchars($username); ?></div>
                <span class="user-badge"><?php echo htmlspecialchars($userType); ?></span>
            </div>

            <div class="profile-content">
                <div class="profile-section">
                    <h2 class="section-title">Account Information</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-label">Full Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['fullname']); ?></div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Username</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Email Address</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Account Type</div>
                            <div class="info-value"><?php echo ucfirst(htmlspecialchars($user['user_type'])); ?></div>
                        </div>
                    </div>
                </div>

                <div class="profile-section">
                    <h2 class="section-title">Account Statistics</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Orders Placed</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Books Purchased</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Reviews Written</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">Member</div>
                            <div class="stat-label">Since Today</div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="profile_settings.php" class="btn btn-primary">Edit Profile</a>
                    <a href="order_history.php" class="btn btn-secondary">Order History</a>
                    <?php if ($userType === 'admin'): ?>
                    <a href="admin_header.php" class="btn btn-secondary">Admin Panel</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>