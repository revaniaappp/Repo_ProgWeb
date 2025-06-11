<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if a user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $fullname = $_SESSION['fullname'];
    $userType = $_SESSION['user_type'];
} else {
    // If not logged in, you might want to redirect them to the login page
    // or display a generic login/register link.
    // For now, I'll just ensure the variables are not set if no session exists.
    $username = null;
    $fullname = null;
    $userType = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiction Books - PaperNest</title>
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

        /* Header Styles (Copied from categories.php for consistency) */
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

        /* Fiction Page Specific Styles */
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
        }

        .btnWishlist:hover {
            background-color: #e67e22;
        }

        /* Footer Styles (Copied from categories.php for consistency) */
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
        <h1>Fiction Books</h1>
        <p>Immerse yourself in captivating stories, diverse characters, and imaginative worlds.</p>
    </section>

    <section class="kontainerBuku">
        <div class="gridBuku">

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/silent2.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Silent Patient</h3>
                    <p class="penulisBuku">By Alex Michaelides</p>
                    <p class="deskripsiBuku">A gripping psychological thriller about a woman’s act of violence against her husband—and the therapist obsessed with uncovering her motive.</p>
                    <div class="ratingBuku">★★★★☆ (4.2)</div>
                    <p class="hargaBuku">Rp. 140.000,00</p>
                    <p class="stokBuku">Stock: 12 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/seven.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Seven Husbands Of Evelyn Hugo</h3>
                    <p class="penulisBuku">By Taylor Jenskin Reid</p>
                    <p class="deskripsiBuku">A reclusive Hollywood legend shares her scandalous life story and deepest secrets with a young journalist.</p>
                    <div class="ratingBuku">★★★★★ (4.8)</div>
                    <p class="hargaBuku">Rp. 85.000,00</p>
                    <p class="stokBuku">Stock: 10 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/the summer.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Summer I Turned Pretty</h3>
                    <p class="penulisBuku">By Jenny Han</p><p class="deskripsiBuku">A tender coming-of-age story about first love, family, and the magic of summer.</p>
                    <div class="ratingBuku">★★★★☆ (4.1)</div>
                    <p class="hargaBuku">Rp. 90.000,00</p>
                    <p class="stokBuku">Stock: 8 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/beneath.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Beneath the Surface</h3>
                    <p class="penulisBuku">By Kaira Rouda</p>
                    <p class="deskripsiBuku">A suspenseful tale about dark family secrets and the price of ambition.</p>
                    <div class="ratingBuku">★★★☆☆ (3.9)</div>
                    <p class="hargaBuku">Rp. 65.000,00</p>
                    <p class="stokBuku">Stock: 8 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/the memory.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Memory Keeper</h3>
                    <p class="penulisBuku">By Kim Edwards</p>
                    <p class="deskripsiBuku">A moving story about a father's life-changing decision and its emotional aftermath.</p>
                    <div class="ratingBuku">★★★★★ (4.7)</div>
                    <p class="hargaBuku">Rp. 84.000,00</p>
                    <p class="stokBuku">Stock: 9 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/marriage.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Marriage Potrait</h3>
                    <p class="penulisBuku">By Hamnet</p>
                    <p class="deskripsiBuku">A rich historical drama set in Renaissance Italy, centered on a young duchess in a dangerous royal court.</p>
                    <div class="ratingBuku">★★★★☆ (4.3)</div>
                    <p class="hargaBuku">Rp. 190.000,00</p>
                    <p class="stokBuku">Stock: 6 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/garden.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">The Forgotten Garden</h3>
                    <p class="penulisBuku">By Kate Morton</p>
                    <p class="deskripsiBuku">A century-spanning mystery of a woman's search for her family's hidden past.</p>
                    <div class="ratingBuku">★★★★☆ (4.5)</div>
                    <p class="hargaBuku">Rp. 175.999,99</p>
                    <p class="stokBuku">Stock: 7 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/ocean.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">No Ocean Too Wide</h3>
                    <p class="penulisBuku">By Carrie Turansky</p>
                    <p class="deskripsiBuku">A powerful story of love, loss, and hope set against the backdrop of early 20th-century child migration.</p>
                    <div class="ratingBuku">★★★★☆ (4.0)</div>
                    <p class="hargaBuku">Rp. 99.000,00</p>
                    <p class="stokBuku">Stock: 5 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/song of.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Song Of Achilles</h3>
                    <p class="penulisBuku">By Madeline MIller</p>
                    <p class="deskripsiBuku">A lyrical retelling of the Iliad through the eyes of Patroclus, exploring love, honor, and fate.</p>
                    <div class="ratingBuku">★★★★☆ (4.0)</div>
                    <p class="hargaBuku">Rp. 88.000,00</p>
                    <p class="stokBuku">Stock: 11 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/once upon.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Once Upon a Curfew</h3>
                    <p class="penulisBuku">By Srishti Chaudary</p>
                    <p class="deskripsiBuku">A charming romance set in post-independence India, blending nostalgia with youthful rebellion.</p>
                    <div class="ratingBuku">★★★☆☆ (3.0)</div>
                    <p class="hargaBuku">Rp. 58.000,00</p>
                    <p class="stokBuku">Stock: 4 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>
        </div>
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
</body>
</html>