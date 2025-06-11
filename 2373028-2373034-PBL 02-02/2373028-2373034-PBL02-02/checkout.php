<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Dummy data for demonstration. In a real application, you'd fetch this from a database
// based on the user's cart or a specific order ID.
// For cart integration, you'd likely retrieve $_SESSION['cart'] or similar.
$orderId = "ORD" . date("Ymd") . rand(1000, 9999); // Dynamic Order ID
$customerId = "CUST" . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Guest'); // Assuming user_id in session
$orderDate = date("F j, Y"); // Current date
$status = "Pending Payment";

// Example cart items (replace with actual cart data from session or database)
$cartItems = [
    [
        'book_id' => 'BK001',
        'product_name' => 'The Seven Husbands of Evelyn Hugo',
        'quantity' => 1,
        'price' => 98000 // Price in IDR
    ],
    [
        'book_id' => 'BK002',
        'product_name' => 'Atomic Habit',
        'quantity' => 2,
        'price' => 150000 // Price in IDR
    ]
];

$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['quantity'] * $item['price'];
}

// Function to format IDR currency
function formatRupiah($amount) {
    return 'Rp' . number_format($amount, 0, ',', '.');
}

// Include profile dropdown if exists (replace with actual path if different)
// Assuming profile_dropdown.php contains the logic for user session and display
// if (file_exists('profile_dropdown.php')) {
//     include 'profile_dropdown.php';
// } else {
//     // Fallback for non-logged-in users or if file is missing
//     $username = null;
//     $fullname = null;
//     $userType = null;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - PaperNest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .checkoutContainer {
            max-width: 900px;
            margin: 3em auto;
            padding: 2em;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 2em;
        }

        .orderDetails {
            margin-bottom: 2em;
            padding-bottom: 1em;
            border-bottom: 1px solid #eee;
        }

        .orderDetails p {
            margin: 0.5em 0;
            line-height: 1.6;
        }

        .productList {
            border-top: 1px solid #ddd;
            margin-top: 1em;
            padding-top: 1em;
        }

        .productItem {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1em;
            padding: 0.5em 0;
            border-bottom: 1px dashed #eee;
        }

        .productItem:last-child {
            border-bottom: none;
        }

        .productItem span {
            width: 25%; /* Adjusted width for better alignment */
            text-align: left;
        }
        .productItem span:nth-child(2) {
            width: 40%; /* Product name takes more space */
        }
        .productItem span:last-child {
            text-align: right; /* Price aligned right */
        }


        .paymentSection {
            margin-top: 2em;
            padding-top: 1em;
            border-top: 1px solid #eee;
        }

        .paymentSection select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 0.5em;
            font-size: 1em;
            background-color: #fefefe;
        }

        .totalAmount {
            text-align: right;
            font-weight: bold;
            font-size: 20px;
            margin-top: 1.5em;
            padding-top: 1em;
            border-top: 2px solid #2c3e50; /* Stronger line for total */
        }

        .btnConfirm {
            margin-top: 2em;
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btnConfirm:hover {
            background-color: #34495e;
        }

        /* --- Header & Footer (as per your existing style.css or embedded in previous PHP files) --- */
        /* Assuming your header and footer styles are either in style.css or
           are consistent with the previous PHP files.
           If not, you might need to copy relevant header/footer styles here. */

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .kontainerHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 1.8em;
            font-weight: bold;
        }

        .logo span {
            color: #ecf0f1; /* Light grey for the "Nest" part */
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        nav ul li a:hover,
        nav ul li a.active {
            color: #f39c12; /* Orange highlight for active/hover */
        }

        .headerKanan {
            display: flex;
            align-items: center;
        }

        .searchBar {
            display: flex;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 5px 10px;
            background-color: white;
            margin-right: 20px;
        }

        .searchBar input {
            border: none;
            outline: none;
            padding: 5px;
            width: 150px;
            background-color: transparent;
            color: #333;
        }

        .searchBar .iconSearch {
            color: #333;
            cursor: pointer;
            padding: 5px;
            text-decoration: none; /* remove underline from link */
        }

        .iconCart, .wishlistIcon, .loginIcon {
            margin-left: 20px;
            position: relative;
        }

        .iconCart a, .wishlistIcon a, .loginIcon a {
            color: white;
            font-size: 1.5em;
            text-decoration: none;
        }

        .cartCount {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7em;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        /* Footer Styles */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
            margin-top: 3em;
            font-size: 0.9em;
        }

        .footerKontainer {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            flex-wrap: wrap;
        }

        .kolomFooter {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .kolomFooter h3 {
            color: #f39c12;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .kolomFooter p, .kolomFooter ul {
            color: #ecf0f1;
            line-height: 1.8;
            margin: 0;
            padding: 0;
        }

        .kolomFooter ul {
            list-style: none;
        }

        .kolomFooter ul li a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .kolomFooter ul li a:hover {
            color: #f39c12;
        }

        .iconSocmed a {
            color: white;
            font-size: 1.5em;
            margin-right: 10px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .iconSocmed a:hover {
            color: #f39c12;
        }

        .copyright {
            text-align: center;
            border-top: 1px solid #4a6572;
            padding-top: 20px;
            margin-top: 30px;
            color: #ecf0f1;
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
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="headerKanan">
                <div class="searchBar">
                    <input type="text" placeholder="Search books...">
                    <a href="#"><span class="iconSearch">🔍</span></a>
                </div>
                <div class="iconCart" id="iconCart">
                    <a href="cart.php">🛒</a>
                    <span class="cartCount" id="cartCount">2</span>
                </div>
                <div class="wishlistIcon">
                    <a href="wishlist.php" class="wishlist-link">❤️</a>
                </div>
                <div class="loginIcon">
                    <?php
                    // This section would typically include your profile dropdown logic
                    // if (isset($_SESSION['username'])) {
                    //     // Include your profile dropdown HTML here
                    //     echo '<div class="profile-dropdown">';
                    //     echo '<a href="#" class="profile-link">Hello, ' . htmlspecialchars($_SESSION['fullname']) . '</a>';
                    //     echo '<div class="dropdown-content">';
                    //     echo '<a href="profile.php">My Profile</a>';
                    //     echo '<a href="logout.php">Logout</a>';
                    //     echo '</div>';
                    //     echo '</div>';
                    // } else {
                        echo '<a href="loginRegister.php" class="loginRegister">🧑🏻‍💼</a>';
                    // }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="checkoutContainer">
        <h1>Checkout</h1>

        <div class="orderDetails">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderId); ?></p>
            <p><strong>Customer ID:</strong> <?php echo htmlspecialchars($customerId); ?></p>
            <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDate); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>
        </div>

        <div class="productList">
            <div class="productItem">
                <span><strong>Book ID</strong></span>
                <span><strong>Product</strong></span>
                <span><strong>Quantity</strong></span>
                <span><strong>Price</strong></span>
            </div>
            <?php foreach ($cartItems as $item): ?>
                <div class="productItem">
                    <span><?php echo htmlspecialchars($item['book_id']); ?></span>
                    <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                    <span><?php echo htmlspecialchars($item['quantity']); ?></span>
                    <span><?php echo formatRupiah($item['price']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="paymentSection">
            <p><strong>Payment Method:</strong></p>
            <select>
                <option value="transfer">Bank Transfer</option>
                <option value="cod">Cash on Delivery</option>
                <option value="ewallet">E-Wallet</option>
                <option value="creditcard">Credit Card</option>
            </select>
        </div>

        <div class="totalAmount">
            Total Amount: <?php echo formatRupiah($totalAmount); ?>
        </div>
        <p><strong>Status:</strong> Waiting for Payment</p>

        <a href="confirmOrder.php"><button class="btnConfirm">Confirm Order</button></a>
    </div>

    <footer>
        <div class="footerKontainer">
            <div class="kolomFooter">
                <h3>About PaperNest</h3>
                <p>Your haven for books and a community for passionate readers.</p>
                <div class="iconSocmed">
                    <a href="https://www.facebook.com/universitaskristenmaranathaofficial">f</a>
                    <a href="https://x.com/ukm_official?s=11">t</a>
                    <a href="https://www.linkedin.com/in/jesye-octavia-nainggolan/">in</a>
                    <a href="https://www.instagram.com/revaniaapp/">ig</a>
                </div>
            </div>
            <div class="kolomFooter">
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="contact.php#faq">FAQs</a></li>
                </ul>
            </div>
            <div class="kolomFooter">
                <h3>My Account</h3>
                <ul>
                    <li><a href="loginRegister.php">Login / Register</a></li>
                    <li><a href="wishlist.php">Wishlist</a></li>
                    <li><a href="cart.php">My Cart</a></li>
                </ul>
            </div>
            <div class="kolomFooter">
                <h3>Store Locations</h3>
                <p>
                    PaperNest Bookstore<br>
                    Jl. Surya Sumantri No.65<br>
                    Phone: +62 8111 200 6543<br>
                    Email: papernest@gmail.com
                </p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 PaperNest. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>