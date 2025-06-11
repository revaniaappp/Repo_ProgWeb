<?php
if (!isset($_SESSION)) {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
}

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$fullname = $isLoggedIn ? $_SESSION['fullname'] : '';
$userType = $isLoggedIn ? $_SESSION['user_type'] : '';
?>

<style>
.profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-btn {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 8px 16px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s;
}

.profile-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.profile-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #e74c3c;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    min-width: 280px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    border-radius: 8px;
    z-index: 1000;
    border: 1px solid #e0e0e0;
    margin-top: 5px;
}

.dropdown-content.show {
    display: block;
}

.profile-header {
    padding: 20px;
    border-bottom: 1px solid #e0e0e0;
    background-color: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.profile-info h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 16px;
    font-weight: 600;
}

.profile-info p {
    margin: 4px 0 0 0;
    color: #7f8c8d;
    font-size: 14px;
}

.user-type-badge {
    display: inline-block;
    background-color: #e74c3c;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    text-transform: uppercase;
    margin-top: 5px;
}

.dropdown-menu {
    padding: 10px 0;
}

.dropdown-item {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: #2c3e50;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.2s;
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item i {
    margin-right: 12px;
    width: 16px;
    color: #7f8c8d;
}

.logout-item {
    border-top: 1px solid #e0e0e0;
    color: #e74c3c !important;
}

.logout-item:hover {
    background-color: #fdf2f2;
}

.login-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s;
}

.login-btn:hover {
    background-color: #c0392b;
}
</style>

<div class="profile-dropdown">
    <?php if ($isLoggedIn): ?>
        <button class="profile-btn" onclick="toggleDropdown()">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($fullname, 0, 1)); ?>
            </div>
            <span><?php echo htmlspecialchars($username); ?></span>
            <i>▼</i>
        </button>
        
        <div class="dropdown-content" id="profileDropdown">
            <div class="profile-header">
                <div class="profile-info">
                    <h3><?php echo htmlspecialchars($fullname); ?></h3>
                    <p>@<?php echo htmlspecialchars($username); ?></p>
                    <span class="user-type-badge"><?php echo htmlspecialchars($userType); ?></span>
                </div>
            </div>
            
            <div class="dropdown-menu">
                <a href="profile.php" class="dropdown-item">
                    <i>👤</i> My Profile
                </a>
                <a href="profile_settings.php" class="dropdown-item">
                    <i>⚙️</i> Account Settings
                </a>
                <?php if ($userType === 'admin'): ?>
                <a href="admin_header.php" class="dropdown-item">
                    <i>🛠️</i> Admin Panel
                </a>
                <?php endif; ?>
                <a href="order_history.php" class="dropdown-item">
                    <i>📦</i> Order History
                </a>
                <hr style="margin: 10px 0; border: none; border-top: 1px solid #e0e0e0;">
                <a href="logout.php" class="dropdown-item logout-item">
                    <i>🚪</i> Sign Out
                </a>
            </div>
        </div>
    <?php else: ?>
        <a href="loginRegister.php" class="login-btn">Login</a>
    <?php endif; ?>
</div>

<script>
function toggleDropdown() {
    var dropdown = document.getElementById("profileDropdown");
    dropdown.classList.toggle("show");
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-btn') && !event.target.closest('.profile-btn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>