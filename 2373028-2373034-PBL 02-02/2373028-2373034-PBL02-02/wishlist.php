<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $fullname = $_SESSION['fullname'];
    $userType = $_SESSION['user_type'];
}

// Ensure the wishlist and cart session arrays exist
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle actions (add to wishlist, remove from wishlist, add to cart)
if (isset($_POST['action'])) {
    $bookId = $_POST['book_id'] ?? null;
    $quantity = (int)($_POST['quantity'] ?? 1);

    // Dummy book data for demonstration (you'd fetch this from your database)
    $availableBooks = [
        'BK003' => ['title' => 'The Silent Patient', 'author' => 'Alex Michaelides', 'price' => 140000, 'img' => '/img/silent2.jpg', 'rating' => '4.2'],
        'BK004' => ['title' => 'The Seven Husbands Of Evelyn Hugo', 'author' => 'Taylor Jenskin Reid', 'price' => 85000, 'img' => '/img/seven.jpg', 'rating' => '4.8'],
        'BK005' => ['title' => 'The Summer I Turned Pretty', 'author' => 'Jenny Han', 'price' => 90000, 'img' => '/img/the summer.jpg', 'rating' => '4.1'],
        'BK006' => ['title' => 'Beneath the Surface', 'author' => 'Kaira Rouda', 'price' => 65000, 'img' => '/img/beneath.jpg', 'rating' => '3.9'],
    ];

    switch ($_POST['action']) {
        case 'add_to_wishlist':
            if ($bookId && isset($availableBooks[$bookId])) {
                $_SESSION['wishlist'][$bookId] = [
                    'title' => $availableBooks[$bookId]['title'],
                    'author' => $availableBooks[$bookId]['author'],
                    'price' => $availableBooks[$bookId]['price'],
                    'img' => $availableBooks[$bookId]['img'],
                    'rating' => $availableBooks[$bookId]['rating']
                ];
            }
            break;
        case 'remove_from_wishlist':
            if ($bookId && isset($_SESSION['wishlist'][$bookId])) {
                unset($_SESSION['wishlist'][$bookId]);
            }
            break;
        case 'add_to_cart':
            if ($bookId && isset($availableBooks[$bookId])) {
                if (isset($_SESSION['cart'][$bookId])) {
                    $_SESSION['cart'][$bookId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$bookId] = [
                        'title' => $availableBooks[$bookId]['title'],
                        'price' => $availableBooks[$bookId]['price'],
                        'img' => $availableBooks[$bookId]['img'],
                        'quantity' => $quantity,
                        'checked' => true
                    ];
                }
            }
            break;
        case 'clear_wishlist':
            $_SESSION['wishlist'] = [];
            break;
    }
    // Redirect to prevent form resubmission on refresh
    header('Location: wishlist.php');
    exit();
}

// Initialize wishlist with sample data if empty (for demonstration)
if (empty($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [
        'BK003' => ['title' => 'The Silent Patient', 'author' => 'Alex Michaelides', 'price' => 140000, 'img' => '/img/silent2.jpg', 'rating' => '4.2'],
        'BK004' => ['title' => 'The Seven Husbands Of Evelyn Hugo', 'author' => 'Taylor Jenskin Reid', 'price' => 85000, 'img' => '/img/seven.jpg', 'rating' => '4.8'],
        'BK005' => ['title' => 'The Summer I Turned Pretty', 'author' => 'Jenny Han', 'price' => 90000, 'img' => '/img/the summer.jpg', 'rating' => '4.1'],
        'BK006' => ['title' => 'Beneath the Surface', 'author' => 'Kaira Rouda', 'price' => 65000, 'img' => '/img/beneath.jpg', 'rating' => '3.9'],
    ];
}

// Function to format IDR currency
function formatRupiah($amount) {
    return 'Rp. ' . number_format($amount, 0, ',', '.') . ',00';
}

// Function to display star rating
function displayStarRating($rating) {
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;
    
    $stars = str_repeat('★', $fullStars);
    if ($halfStar) $stars .= '☆';
    $stars .= str_repeat('☆', $emptyStars);
    
    return $stars;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - PaperNest</title>
    <style>
        /* General Styles */
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

        /* Header Styles (Copied from fiction.php for consistency) */
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

        nav ul li a:hover,
        nav ul li a.active {
            color: #e74c3c; /* Added hover and active state for navigation */
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

        /* Wishlist Page Specific Styles - Matching Fiction.php */
        .bannerKategori {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            text-align: center;
            padding: 60px 20px;
            margin-bottom: 40px; /* Added margin for separation */
        }

        .bannerKategori h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .bannerKategori p {
            font-size: 18px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .kontainerBuku {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .gridBuku {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .kotakBuku {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .kotakBuku:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .coverBuku {
            width: 100%;
            height: 250px; /* Fixed height for covers */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0; /* Placeholder background */
        }

        .coverBuku img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures image covers the area, cropping if necessary */
            display: block;
        }

        .detailBuku {
            padding: 20px;
            flex-grow: 1; /* Allows content to expand and push footer down */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .judulBuku {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 600;
            line-height: 1.3;
        }

        .penulisBuku {
            font-size: 15px;
            color: #7f8c8d;
            margin-bottom: 15px;
            font-style: italic;
        }

        .deskripsiBuku {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
            line-height: 1.5;
            flex-grow: 1; /* Allows description to take up available space */
        }

        .ratingBuku {
            font-size: 14px;
            color: #f39c12; /* Star color */
            margin-bottom: 10px;
        }

        .hargaBuku {
            font-size: 18px;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stokBuku {
            font-size: 13px;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .aksiBuku {
            display: flex;
            gap: 10px;
            margin-top: auto; /* Pushes action buttons to the bottom */
        }

        .tambahKeranjang {
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
            flex-grow: 1;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .tambahKeranjang:hover {
            background-color: #217dbb;
        }

        .btnWishlist {
            background-color: #f39c12;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
            width: 40px; /* Fixed width for wishlist button */
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .btnWishlist:hover {
            background-color: #e67e22;
        }

        /* Empty wishlist styles */
        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .empty-wishlist p {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .continue-shopping {
            background-color: #e74c3c;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .continue-shopping:hover {
            background-color: #c0392b;
        }

        /* Footer Styles (Copied from fiction.php for consistency) */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0 20px;
            margin-top: 80px;
        }

        .footerKontainer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .kolomFooter h3 {
            margin-bottom: 20px;
            color: #e74c3c;
        }

        .kolomFooter p {
            line-height: 1.6;
            color: #bdc3c7;
        }

        .kolomFooter ul {
            list-style: none;
        }

        .kolomFooter ul li {
            margin-bottom: 10px;
        }

        .kolomFooter ul li a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .kolomFooter ul li a:hover {
            color: #e74c3c;
        }

        .iconSocmed {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .iconSocmed a {
            width: 40px;
            height: 40px;
            background-color: #34495e;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .iconSocmed a:hover {
            background-color: #e74c3c;
        }

        .copyright {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            color: #bdc3c7;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .kontainerHeader {
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            .headerKanan {
                flex-wrap: wrap;
                justify-content: center;
            }

            .searchBar input {
                width: 250px;
            }

            .bannerKategori h1 {
                font-size: 36px;
            }

            .gridBuku {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                padding: 0 15px;
            }
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="headerKanan">
                <div class="searchBar">
                    <input type="text" id="searchInputHeader" placeholder="Search books...">
                    <a href="#" id="searchButtonHeader" class="iconSearch">🔍</a>
                </div>
                <div class="iconCart" id="iconCart">
                    <a href="cart.php">🛒</a>
                    <span class="cartCount" id="cartCount"><?php echo count($_SESSION['cart']); ?></span>
                </div>
                <div class="wishlistIcon">
                    <a href="wishlist.php" class="wishlist-link">❤️</a>
                </div>
                
                <?php if (isset($username)): ?>
                    <div class="profileDropdown">
                        <a href="#" class="loginRegister">Hi, <?php echo htmlspecialchars($username); ?>!</a>
                        <div class="dropdownContent">
                            <a href="profile.php">Profile</a>
                            <a href="orders.php">My Orders</a>
                            <?php if ($userType === 'admin'): ?>
                                <a href="admin_dashboard.php">Admin Dashboard</a>
                            <?php endif; ?>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="loginIcon">
                        <a href="loginRegister.php" class="loginRegister">🧑🏻‍💼</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="bannerKategori">
        <h1>My Wishlist</h1>
        <p>Discover and save your favorite books for later.</p>
    </section>

    <section class="kontainerBuku">
        <?php if (empty($_SESSION['wishlist'])): ?>
            <div class="empty-wishlist">
                <p>Your wishlist is empty.</p>
                <a href="categories.php" class="continue-shopping">Browse Books</a>
            </div>
        <?php else: ?>
            <div class="gridBuku">
                <?php foreach ($_SESSION['wishlist'] as $bookId => $item): ?>
                    <div class="kotakBuku">
                        <div class="coverBuku">
                            <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                        <div class="detailBuku">
                            <h3 class="judulBuku"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="penulisBuku">By <?php echo htmlspecialchars($item['author']); ?></p>
                            <div class="ratingBuku"><?php echo displayStarRating(floatval($item['rating'])); ?> (<?php echo htmlspecialchars($item['rating']); ?>)</div>
                            <p class="hargaBuku"><?php echo formatRupiah($item['price']); ?></p>
                            <div class="aksiBuku">
                                <button class="tambahKeranjang" onclick="addToCart('<?php echo htmlspecialchars($bookId); ?>')">Add to Cart</button>
                                <button class="btnWishlist" onclick="removeFromWishlist('<?php echo htmlspecialchars($bookId); ?>')">♡</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartCountElement = document.getElementById('cartCount');

            // Header search functionality
            document.getElementById('searchButtonHeader').addEventListener('click', function(event) {
                event.preventDefault();
                const searchTerm = document.getElementById('searchInputHeader').value;
                window.location.href = 'categories.php?search=' + encodeURIComponent(searchTerm);
            });

            document.getElementById('searchInputHeader').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const searchTerm = document.getElementById('searchInputHeader').value;
                    window.location.href = 'categories.php?search=' + encodeURIComponent(searchTerm);
                }
            });
        });

        // Function to add item to cart
        function addToCart(bookId) {
            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('book_id', bookId);
            formData.append('quantity', '1');

            fetch('wishlist.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Book added to cart successfully!');
                // Update cart count
                const cartCount = document.getElementById('cartCount');
                cartCount.textContent = parseInt(cartCount.textContent) + 1;
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('Failed to add book to cart. Please try again.');
            });
        }

        // Function to remove item from wishlist
        function removeFromWishlist(bookId) {
            if (confirm('Are you sure you want to remove this book from your wishlist?')) {
                const formData = new FormData();
                formData.append('action', 'remove_from_wishlist');
                formData.append('book_id', bookId);

                fetch('wishlist.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error removing from wishlist:', error);
                    alert('Failed to remove book from wishlist. Please try again.');
                });
            }
        }
    </script>
</body>
</html>