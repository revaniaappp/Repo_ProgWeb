<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: loginRegister.php');
    exit;
}

$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$userType = $_SESSION['user_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - PaperNest</title>
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

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }

        .empty-state {
            background: white;
            padding: 60px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .empty-text {
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
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

        .coming-soon {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        .coming-soon h3 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Order History</h1>
            <p class="page-subtitle">Track and view all your past book orders</p>
        </div>

        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h2 class="empty-title">No Orders Yet</h2>
            <p class="empty-text">
                You haven't placed any orders yet. Start exploring our collection and find your next great read!
            </p>
            <a href="categories.php" class="btn btn-primary">Browse Books</a>
            
            <div class="coming-soon">
                <h3>🚀 Coming Soon</h3>
                <p>Order tracking, purchase history, and order management features will be available soon!</p>
            </div>
        </div>
    </div>
</body>
</html>