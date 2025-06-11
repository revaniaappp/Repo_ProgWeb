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
    <title>Contact Us - PaperNest</title>
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

        .contactSection {
            padding: 3rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sectionTitle {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .contactGrid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .contactCard {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .contactCard:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .contactCard h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .contactCard p {
            color: #7f8c8d;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .whatsappButton {
            background-color: #25D366;
            color: white;
            font-weight: bold;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .whatsappButton:hover {
            background-color: #128C7E;
            transform: translateY(-2px);
        }

        iframe {
            width: 100%;
            height: 300px;
            border: none;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .faq {
            margin-top: 4rem;
        }

        .faqContainer {
            max-width: 800px;
            margin: 0 auto;
        }

        .faqItem {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
            background-color: white;
        }

        .faqItem:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .faqItem summary {
            background-color: #fff;
            padding: 1.5rem;
            cursor: pointer;
            font-weight: 600;
            list-style: none;
            color: #2c3e50;
            font-size: 1.1rem;
            border-bottom: 1px solid #ecf0f1;
        }

        .faqItem summary::after {
            content: "▼";
            float: right;
            transition: transform 0.3s ease;
            color: #e74c3c;
        }

        .faqItem[open] summary::after {
            transform: rotate(180deg);
        }

        .faqItem p {
            padding: 1.5rem;
            margin: 0;
            background-color: #fafafa;
            color: #34495e;
            line-height: 1.6;
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

            .contactSection {
                padding: 2rem 5%;
            }

            .sectionTitle {
                font-size: 2rem;
            }

            .contactGrid {
                gap: 2rem;
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
                    <li><a href="contact.php" class="active">Contact</a></li>
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

    <section class="contactSection" id="contact-top">
        <h2 class="sectionTitle">Contact Us</h2>
        <div class="contactGrid">
            <div class="contactCard">
                <h3>Chat with Us</h3>
                <p>Need help? Reach out via WhatsApp and our team will respond shortly.</p>
                <a class="whatsappButton" href="https://wa.me/6281112006543" target="_blank">Message on WhatsApp</a>
            </div>
            <div class="contactCard">
                <h3>Visit Our Store</h3>
                <p>Jl. Surya Sumantri No.65</p>
                <p>Phone: +62 8111 200 6543</p>
                <p>Email: papernest@gmail.com</p>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.039918534067!2d107.57847567499613!3d-6.885822093113164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6873a8cf5a7%3A0xf8f474dec4efb56!2sUniversitas%20Kristen%20Maranatha!5e0!3m2!1sen!2sid!4v1743778282414!5m2!1sen!2sid"
                    allowfullscreen loading="lazy"></iframe>
            </div>
        </div>

        <section class="faq" id="faq">
            <h2 class="sectionTitle">Frequently Asked Questions</h2>
            <div class="faqContainer">
                <details class="faqItem">
                    <summary>What payment methods do you accept?</summary>
                    <p>We accept bank transfer, e-wallet, Cash on Delivery, and Credit Card.</p>
                </details>
                <details class="faqItem">
                    <summary>How long does shipping take?</summary>
                    <p>Delivery takes 1-5 business days depending on your location.</p>
                </details>
                <details class="faqItem">
                    <summary>Do you offer cash on delivery?</summary>
                    <p>Of course! We provide cash on delivery service for your convenience.</p>
                </details>
                <details class="faqItem">
                    <summary>Can I return a book?</summary>
                    <p>Yes, you can return books within 3 days of delivery as long as they are in good condition.</p>
                </details>
                <details class="faqItem">
                    <summary>Do you sell e-books?</summary>
                    <p>Some books are available in digital format. Check the product page for availability.</p>
                </details>
                <details class="faqItem">
                    <summary>Can I buy in bulk?</summary>
                    <p>Absolutely! Contact us for bulk purchase discounts and special rates.</p>
                </details>
                <details class="faqItem">
                    <summary>What if I ordered the wrong book?</summary>
                    <p>Please contact us immediately to cancel or change your order before it's processed.</p>
                </details>
                <details class="faqItem">
                    <summary>When is your customer support available?</summary>
                    <p>Our customer support is available Monday–Friday, 9 AM–5 PM (WIB).</p>
                </details>
                <details class="faqItem">
                    <summary>Are your books original?</summary>
                    <p>Yes, all our books are 100% original and official publications.</p>
                </details>
            </div>
        </section>
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