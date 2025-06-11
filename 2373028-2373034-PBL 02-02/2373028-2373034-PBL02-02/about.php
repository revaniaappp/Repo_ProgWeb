<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {
    header('Location: loginRegister.php');
    // exit;
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
    <title>About Us - PaperNest</title>
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
            color: #333;
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

        .aboutSection {
            padding: 4rem 5%;
            background-color: #fff;
            max-width: 1200px;
            margin: 0 auto;
        }

        .aboutSection h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 700;
            position: relative;
        }

        .aboutSection h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: #e74c3c;
            margin: 1rem auto;
            border-radius: 2px;
        }

        .aboutContent {
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.8;
            text-align: center;
            font-size: 1.1rem;
        }

        .aboutContent p {
            margin-bottom: 1.5rem;
            color: #34495e;
        }

        .aboutContent strong {
            color: #e74c3c;
        }

        .missionSection {
            background: linear-gradient(135deg, #ecf0f1, #bdc3c7);
            padding: 4rem 5%;
            text-align: center;
            margin: 3rem 0;
        }

        .missionSection h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 700;
            position: relative;
        }

        .missionSection h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: #e74c3c;
            margin: 1rem auto;
            border-radius: 2px;
        }

        .missionSection p {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.2rem;
            line-height: 1.8;
            color: #34495e;
        }

        .teamSection {
            padding: 4rem 5%;
            text-align: center;
            background-color: #fff;
            max-width: 1200px;
            margin: 0 auto;
        }

        .teamSection h2 {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #2c3e50;
            font-weight: 700;
            position: relative;
        }

        .teamSection h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: #e74c3c;
            margin: 1rem auto;
            border-radius: 2px;
        }

        .teamGrid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 4rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .teamMember {
            background-color: white;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 280px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .teamMember:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .teamMember img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1.5rem;
            border: 4px solid #e74c3c;
            transition: transform 0.3s ease;
        }

        .teamMember:hover img {
            transform: scale(1.05);
        }

        .teamMember h3 {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .teamMember p {
            color: #7f8c8d;
            font-size: 1rem;
            font-weight: 500;
        }

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

            .aboutSection {
                padding: 2rem 5%;
            }

            .aboutSection h2,
            .missionSection h2,
            .teamSection h2 {
                font-size: 2rem;
            }

            .teamGrid {
                gap: 2rem;
            }

            .teamMember {
                max-width: 250px;
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
                    <li><a href="about.php" class="active">About</a></li>
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

    <section class="aboutSection">
        <h2>About Us</h2>
        <div class="aboutContent">
            <p>Welcome to <strong>PaperNest</strong>, your haven for books and a community for passionate readers. Our platform is built with love for literature, and a mission to make quality reading accessible to everyone, everywhere.</p>
            <p>Whether you're looking for a gripping novel, an inspiring memoir, or a fun read for your kids, PaperNest is here to connect you with the books you'll love — and maybe even change your life along the way.</p>
        </div>
    </section>

    <section class="missionSection">
        <h2>Our Mission</h2>
        <p>Nurturing a love for reading, forever. We aim to inspire readers of all ages by making literature engaging, inclusive, and within reach of every heart and home.</p>
    </section>

    <section class="teamSection">
        <h2>Meet the Team</h2>
        <div class="teamGrid">
            <div class="teamMember">
                <img src="img/jesye.png" alt="Jesye">
                <h3>Jesye</h3>
                <p>Founder & CEO</p>
            </div>
            <div class="teamMember">
                <img src="img/reva.png" alt="Revania">
                <h3>Revania</h3>
                <p>Founder & CEO</p>
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