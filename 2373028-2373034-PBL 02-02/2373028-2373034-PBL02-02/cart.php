<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $fullname = $_SESSION['fullname'];
    $userType = $_SESSION['user_type'];
}

// Ensure the cart session array exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle actions (add, remove, update quantity)
if (isset($_POST['action'])) {
    $bookId = $_POST['book_id'] ?? null;
    $quantity = (int)($_POST['quantity'] ?? 0);

    // Dummy book data for demonstration (you'd fetch this from your database)
    // In a real application, you'd fetch the book details (price, image, title) based on bookId
    $availableBooks = [
        'BK001' => ['title' => 'The Seven Husbands of Evelyn Hugo', 'price' => 98000, 'img' => '/img/seven.jpg'],
        'BK002' => ['title' => 'Atomic Habit', 'price' => 75000, 'img' => '/img/atomic.jpg'],
        // Add more books as needed, fetched from your database
    ];

    switch ($_POST['action']) {
        case 'add':
            if ($bookId && isset($availableBooks[$bookId])) {
                if (isset($_SESSION['cart'][$bookId])) {
                    $_SESSION['cart'][$bookId]['quantity'] += $quantity > 0 ? $quantity : 1;
                } else {
                    $_SESSION['cart'][$bookId] = [
                        'title' => $availableBooks[$bookId]['title'],
                        'price' => $availableBooks[$bookId]['price'],
                        'img' => $availableBooks[$bookId]['img'],
                        'quantity' => $quantity > 0 ? $quantity : 1,
                        'checked' => true // Default to checked when added
                    ];
                }
            }
            break;
        case 'update_quantity':
            if ($bookId && isset($_SESSION['cart'][$bookId])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$bookId]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$bookId]); // Remove if quantity is 0 or less
                }
            }
            break;
        case 'remove':
            if ($bookId && isset($_SESSION['cart'][$bookId])) {
                unset($_SESSION['cart'][$bookId]);
            }
            break;
        case 'update_checked':
            if ($bookId && isset($_SESSION['cart'][$bookId])) {
                $_SESSION['cart'][$bookId]['checked'] = isset($_POST['checked']) && $_POST['checked'] === 'true';
            }
            break;
        case 'clear_cart':
            $_SESSION['cart'] = [];
            break;
    }
    // Redirect to prevent form resubmission on refresh
    header('Location: cart.php');
    exit();
}

// Calculate total for checked items
$totalPrice = 0;
foreach ($_SESSION['cart'] as $bookId => $item) {
    if (isset($item['checked']) && $item['checked']) {
        $totalPrice += $item['quantity'] * $item['price'];
    }
}

// Function to format IDR currency
function formatRupiah($amount) {
    return 'Rp' . number_format($amount, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - PaperNest</title>
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

        /* Cart specific styles */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .kontainerCart {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .cart-title {
            text-align: center;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .cartItem {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ecf0f1;
            padding: 20px 0;
            gap: 20px;
        }

        .cartItem:last-child {
            border-bottom: none;
        }

        .cartItem input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #e74c3c;
            cursor: pointer;
        }

        .cartItem img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .infoItem {
            flex: 1;
        }

        .infoItem h3 {
            margin: 0 0 8px;
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
        }

        .infoItem p {
            margin: 4px 0;
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .kuantitas {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 10px;
        }

        .kuantitas button {
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 35px;
        }

        .kuantitas button:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }

        .kuantitas span {
            font-weight: bold;
            min-width: 30px;
            text-align: center;
            font-size: 16px;
            color: #2c3e50;
        }

        .removeItem {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .removeItem:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }

        .total {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
            color: #2c3e50;
        }

        .btnCheckout {
            display: block;
            margin-left: auto;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            width: fit-content;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btnCheckout:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-cart p {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .continue-shopping {
            background-color: #e74c3c;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .continue-shopping:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
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

            .main-content {
                padding: 20px;
            }

            .cartItem {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .cartItem img {
                align-self: center;
            }

            .kuantitas {
                justify-content: center;
            }

            .removeItem {
                align-self: center;
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
                
                <?php include 'profile_dropdown.php'; ?>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="kontainerCart">
            <h1 class="cart-title">Shopping Cart</h1>

            <?php if (empty($_SESSION['cart'])): ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                    <a href="categories.php" class="continue-shopping">Continue Shopping</a>
                </div>
            <?php else: ?>
                <?php foreach ($_SESSION['cart'] as $bookId => $item): ?>
                    <div class="cartItem">
                        <input type="checkbox" class="itemCheckbox" data-book-id="<?php echo htmlspecialchars($bookId); ?>" <?php echo (isset($item['checked']) && $item['checked']) ? 'checked' : ''; ?>>
                        <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <div class="infoItem">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p>Price: <?php echo formatRupiah($item['price']); ?></p>
                            <div class="kuantitas">
                                <button class="quantity-btn" data-action="decrease" data-book-id="<?php echo htmlspecialchars($bookId); ?>">-</button>
                                <span class="quantity-display" id="quantity_<?php echo htmlspecialchars($bookId); ?>"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                <button class="quantity-btn" data-action="increase" data-book-id="<?php echo htmlspecialchars($bookId); ?>">+</button>
                            </div>
                        </div>
                        <button class="removeItem" data-book-id="<?php echo htmlspecialchars($bookId); ?>">Remove</button>
                    </div>
                <?php endforeach; ?>

                <div class="total">
                    Total: <span id="cartTotalPrice"><?php echo formatRupiah($totalPrice); ?></span>
                </div>

                <form action="checkout.php" method="POST" id="checkoutForm">
                    <button type="submit" class="btnCheckout">Checkout</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

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
            const cartContainer = document.querySelector('.kontainerCart');
            const cartCountElement = document.getElementById('cartCount');
            const cartTotalPriceElement = document.getElementById('cartTotalPrice');
            const checkoutForm = document.getElementById('checkoutForm');

            // Function to update cart count in header
            function updateCartCount() {
                const itemCount = document.querySelectorAll('.cartItem').length;
                cartCountElement.textContent = itemCount;
            }

            // Function to update total price
            function updateTotalPrice() {
                let currentTotal = 0;
                document.querySelectorAll('.cartItem').forEach(itemElement => {
                    const checkbox = itemElement.querySelector('.itemCheckbox');
                    if (checkbox && checkbox.checked) {
                        const bookId = checkbox.dataset.bookId;
                        const quantity = parseInt(itemElement.querySelector('.quantity-display').textContent);
                        const priceText = itemElement.querySelector('.infoItem p').textContent;
                        const price = parseFloat(priceText.replace('Price: Rp', '').replace(/\./g, ''));

                        currentTotal += quantity * price;
                    }
                });
                cartTotalPriceElement.textContent = formatRupiah(currentTotal);
            }

            // Helper function to format Rupiah
            function formatRupiah(amount) {
                return 'Rp' + Math.round(amount).toLocaleString('id-ID');
            }

            // Event listeners for quantity buttons
            cartContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('quantity-btn')) {
                    const button = event.target;
                    const action = button.dataset.action;
                    const bookId = button.dataset.bookId;
                    const quantitySpan = document.getElementById(`quantity_${bookId}`);
                    let currentQuantity = parseInt(quantitySpan.textContent);

                    if (action === 'increase') {
                        currentQuantity++;
                    } else if (action === 'decrease' && currentQuantity > 1) {
                        currentQuantity--;
                    } else if (action === 'decrease' && currentQuantity <= 1) {
                        if (confirm('Are you sure you want to remove this item from your cart?')) {
                            sendCartUpdate(bookId, 0, 'update_quantity');
                            return;
                        } else {
                            return;
                        }
                    }

                    quantitySpan.textContent = currentQuantity;
                    sendCartUpdate(bookId, currentQuantity, 'update_quantity');
                }
            });

            // Event listener for remove buttons
            cartContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('removeItem')) {
                    const bookId = event.target.dataset.bookId;
                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        sendCartUpdate(bookId, 0, 'remove');
                    }
                }
            });

            cartContainer.addEventListener('change', function(event) {
                if (event.target.classList.contains('itemCheckbox')) {
                    const checkbox = event.target;
                    const bookId = checkbox.dataset.bookId;
                    const isChecked = checkbox.checked;
                    sendCartUpdate(bookId, null, 'update_checked', isChecked);
                }
            });

            function sendCartUpdate(bookId, quantity, action, checked = null) {
                const formData = new FormData();
                formData.append('action', action);
                formData.append('book_id', bookId);
                if (quantity !== null) {
                    formData.append('quantity', quantity);
                }
                if (checked !== null) {
                    formData.append('checked', checked ? 'true' : 'false');
                }

                fetch('cart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Cart update response:', data);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                    alert('Failed to update cart. Please try again.');
                });
            }

            // Checkout form submission
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(event) {
                    checkoutForm.querySelectorAll('input[name="selected_items[]"]').forEach(input => input.remove());
                    checkoutForm.querySelectorAll('input[name^="quantity_"]').forEach(input => input.remove());

                    let selectedItems = [];
                    document.querySelectorAll('.cartItem .itemCheckbox:checked').forEach(checkbox => {
                        const bookId = checkbox.dataset.bookId;
                        const quantity = parseInt(document.getElementById(`quantity_${bookId}`).textContent);
                        selectedItems.push({ book_id: bookId, quantity: quantity });
                    });

                    if (selectedItems.length === 0) {
                        alert('Please select at least one item to checkout.');
                        event.preventDefault();
                        return;
                    }

                    selectedItems.forEach(item => {
                        const bookIdInput = document.createElement('input');
                        bookIdInput.type = 'hidden';
                        bookIdInput.name = 'selected_items[]';
                        bookIdInput.value = item.book_id;
                        checkoutForm.appendChild(bookIdInput);

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'hidden';
                        quantityInput.name = `quantity_${item.book_id}`;
                        quantityInput.value = item.quantity;
                        checkoutForm.appendChild(quantityInput);
                    });
                });
            }

            updateCartCount();
            updateTotalPrice();

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
    </script>
</body>
</html>