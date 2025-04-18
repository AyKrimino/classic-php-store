<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
?>

<header>
    <div class="header-content">
        <div class="logo-section">
            <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-panel-right-close-icon lucide-panel-right-close"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
            <h3>Admin Panel</h3>
        </div>
        <div class="search-section">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" name="search" placeholder="Search..." id="">
        </div>
        <div class="user-section">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-user-icon lucide-shield-user"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M6.376 18.91a6 6 0 0 1 11.249.003"/><circle cx="12" cy="11" r="4"/></svg>
            <h3>
                <?php 
                if (isset($_SESSION["admin_email"]) && isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
                    echo substr($_SESSION["admin_email"], 0, strpos($_SESSION["admin_email"], "@"));
                } else {
                    echo "admin";
                }
                ?>
            </h3>
        </div>
    </div>
</header>
