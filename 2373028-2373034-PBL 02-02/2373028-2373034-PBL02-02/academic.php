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
    <title>Academic Books - PaperNest</title>
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

        /* Header Styles */
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

        /* Academic Page Specific Styles - Consistent with Fiction & Non-Fiction */
        .bannerKategori {
            background: linear-gradient(135deg, #e74c3c, #c0392b); /* Consistent red/orange gradient */
            color: white;
            text-align: center;
            padding: 60px 20px;
            margin-bottom: 40px;
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
            height: 250px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .coverBuku img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .detailBuku {
            padding: 20px;
            flex-grow: 1;
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
            flex-grow: 1;
        }

        .ratingBuku {
            font-size: 14px;
            color: #f39c12;
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
            margin-top: auto;
        }

        .tambahKeranjang {
            background-color: #e74c3c; /* Consistent red */
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
            background-color: #c0392b; /* Darker red on hover */
        }

        .btnWishlist {
            background-color: #f39c12; /* Consistent orange for wishlist */
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
            width: 40px;
            text-align: center;
        }

        .btnWishlist:hover {
            background-color: #e67e22; /* Darker orange on hover */
        }

        /* Footer Styles */
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
        <h1>Academic Books</h1>
        <p>Explore the world of knowledge with top academic books from various disciplines.</p>
    </section>

    <section class="kontainerBuku">
        <div class="gridBuku">

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/micro" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Microeconomics</h3>
                    <p class="penulisBuku">By Robert S, Daniel R</p>
                    <div class="ratingBuku">★★★★★ (4.9)</div>
                    <p class="hargaBuku">Rp. 245.000,00</p>
                    <p class="deskripsiBuku">Discusses the basic principles of microeconomics, including demand, supply,
                        and competitive markets.</p>
                    <p class="stokBuku">Stock: 12 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/writing" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Writing Essays</h3>
                    <p class="penulisBuku">By Thomas Sowell</p>
                    <div class="ratingBuku">★★★★★ (4.8)</div>
                    <p class="hargaBuku">Rp. 220.000,00</p>
                    <p class="deskripsiBuku">A comprehensive guide to writing academic essays systematically and
                        effectively.</p>
                    <p class="stokBuku">Stock: 10 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/pysco.jpg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Psychology for Designers</h3>
                    <p class="penulisBuku">By Joe Leech</p>
                    <div class="ratingBuku">★★★★☆ (4.5)</div>
                    <p class="hargaBuku">Rp. 278.000,00</p>
                    <p class="deskripsiBuku">Connects psychological principles with UI/UX design for better user
                        experiences.</p>
                    <p class="stokBuku">Stock: 8 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/math.jpeg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Math Geek</h3>
                    <p class="penulisBuku">By Raphael Rosen</p>
                    <div class="ratingBuku">★★★★☆ (4.6)</div>
                    <p class="hargaBuku">Rp. 190.000,00</p>
                    <p class="deskripsiBuku">Presents math concepts in a fun and easy-to-understand way for all
                        audiences.</p>
                    <p class="stokBuku">Stock: 14 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/chem" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Chemistry 1</h3>
                    <p class="penulisBuku">By Cliff Curtis</p>
                    <div class="ratingBuku">★★★★★ (4.9)</div>
                    <p class="hargaBuku">Rp. 210.000,00</p>
                    <p class="deskripsiBuku">Chemistry basics for beginners, covering atomic structure, chemical bonds,
                        and basic reactions.</p>
                    <p class="stokBuku">Stock: 9 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/choices" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Choices Upper-Inter: WB+CD</h3>
                    <p class="penulisBuku">By Yuval Noah Harari</p>
                    <div class="ratingBuku">★★★★★ (4.9)</div>
                    <p class="hargaBuku">Rp. 600.000,00</p>
                    <p class="deskripsiBuku">A complete interactive workbook with CD for upper-intermediate English
                        practice.</p>
                    <p class="stokBuku">Stock: 6 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/new english.jpeg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">New English Parade</h3>
                    <p class="penulisBuku">By Mario Herera</p>
                    <div class="ratingBuku">★★★★★ (4.9)</div>
                    <p class="hargaBuku">Rp. 450.000,00</p>
                    <p class="deskripsiBuku">English textbook for children, complete with illustrations and interactive
                        exercises.</p>
                    <p class="stokBuku">Stock: 11 available</p>
                    <div class="aksiBuku">
                        <a href="#" class="tambahKeranjang">Add to Cart</a>
                        <a href="#" class="btnWishlist">♡</a>
                    </div>
                </div>
            </div>

            <div class="kotakBuku">
                <div class="coverBuku">
                    <img src="/img/ValuePack.jpeg" alt="Book Cover">
                </div>
                <div class="detailBuku">
                    <h3 class="judulBuku">Value Pack: Longman Introductory</h3>
                    <p class="penulisBuku">By Mario Herera</p>
                    <div class="ratingBuku">★★★★★ (4.5)</div>
                    <p class="hargaBuku">Rp. 350.000,00</p>
                    <p class="deskripsiBuku">A complete Longman book pack for beginner English learners with a practical
                        approach.</p>
                    <p class="stokBuku">Stock: 13 available</p>
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