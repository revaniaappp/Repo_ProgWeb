<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$userType = $_SESSION['user_type'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PaperNest</title>
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

        .admin-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 3px solid #e74c3c;
        }

        .admin-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-brand {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-badge {
            background-color: #e74c3c;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .brand .paper {
            color: white;
        }

        .brand .nest {
            color: #e74c3c;
        }

        .admin-nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .admin-nav a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            padding: 8px 16px;
            border-radius: 6px;
        }

        .admin-nav a:hover {
            color: #e74c3c;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .admin-nav a.active {
            background-color: #e74c3c;
            color: white;
        }

        .admin-tools {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 8px 16px;
        }

        .search-container input {
            background: none;
            border: none;
            color: white;
            outline: none;
            padding: 4px 8px;
            width: 200px;
        }

        .search-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
        }

        .admin-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .admin-welcome {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .welcome-title {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #e74c3c;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .action-card:hover {
            transform: translateY(-5px);
        }

        .action-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .action-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .action-desc {
            color: #7f8c8d;
            margin-bottom: 20px;
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
            background-color: #e74c3c;
            color: white;
        }

        .btn:hover {
            background-color: #c0392b;
        }

        @media (max-width: 768px) {
            .admin-header-content {
                flex-direction: column;
                gap: 15px;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .admin-tools {
                flex-direction: column;
                gap: 10px;
            }

            .search-container input {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-content">
            <div class="admin-brand">
                <div class="brand">
                    <span class="paper">Paper</span><span class="nest">Nest</span>
                </div>
                <span class="admin-badge">Admin</span>
            </div>
            
            <nav class="admin-nav">
                <a href="home.php" class="active">Home</a>
                <a href="categories.php">Categories</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </nav>

            <div class="admin-tools">
                <div class="search-container">
                    <input type="text" placeholder="Search books...">
                    <button class="search-btn">🔍</button>
                </div>
                <?php include 'profile_dropdown.php'; ?>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="admin-welcome">
            <h1 class="welcome-title">Welcome to Admin Panel</h1>
            <p class="welcome-subtitle">Manage your PaperNest bookstore from here</p>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Books</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Revenue</div>
            </div>
        </div>

        <div class="admin-actions">
            <div class="action-card">
                <div class="action-icon">📚</div>
                <h3 class="action-title">Manage Books</h3>
                <p class="action-desc">Add, edit, or remove books from your inventory</p>
                <a href="#" class="btn">Manage Books</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">📦</div>
                <h3 class="action-title">Orders</h3>
                <p class="action-desc">View and manage customer orders</p>
                <a href="#" class="btn">View Orders</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">👥</div>
                <h3 class="action-title">Users</h3>
                <p class="action-desc">Manage user accounts and permissions</p>
                <a href="#" class="btn">Manage Users</a>
            </div>
            
            <div class="action-card">
                <div class="action-icon">📊</div>
                <h3 class="action-title">Analytics</h3>
                <p class="action-desc">View sales reports and analytics</p>
                <a href="#" class="btn">View Analytics</a>
            </div>
        </div>
    </div>
</body>
</html>