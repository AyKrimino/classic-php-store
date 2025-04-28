<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");

$active = array(
    "dashboard" => false,
    "categories" => false,
    "subCategories" => false,
    "products" => false,
    "orders" => false,
    "customers" => false,
    "logout" => false,
);

$location = basename($_SERVER['REQUEST_URI']);
foreach ($active as $key => $value) {
    $active[$key] = false;
    if (str_contains($location, $key)) {
        $active[$key] = true;
    }
}
?>

<section class="sidebar-section">
    <div class="sidebar-container">
        <h1>Admin Panel Options</h1>
        <ul class="sidebar-items">
            <li class="sidebar-item <?php echo ($active["dashboard"]) ? "active" : "" ?>">
                <svg class="sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-dashboard.php">Dashboard</a>
            </li>

            <li class="sidebar-item <?php echo ($active["categories"]) ? "active" : "" ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-list-icon lucide-layout-list"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><path d="M14 4h7"/><path d="M14 9h7"/><path d="M14 15h7"/><path d="M14 20h7"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-categories.php">Categories</a>
            </li>

            <li class="sidebar-item <?php echo ($active["subCategories"]) ? "active" : "" ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-replace-icon lucide-replace"><path d="M14 4a2 2 0 0 1 2-2"/><path d="M16 10a2 2 0 0 1-2-2"/><path d="M20 2a2 2 0 0 1 2 2"/><path d="M22 8a2 2 0 0 1-2 2"/><path d="m3 7 3 3 3-3"/><path d="M6 10V5a3 3 0 0 1 3-3h1"/><rect x="2" y="14" width="8" height="8" rx="2"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-subCategories.php">Sub Categories</a>
            </li>

            <li class="sidebar-item <?php echo ($active["products"]) ? "active" : "" ?>">
                <svg class="sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shirt-icon lucide-shirt"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-products.php">Products</a>
            </li>

            <li class="sidebar-item <?php echo ($active["orders"]) ? "active" : "" ?>">
                <svg class="sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box-icon lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-orders.php">Orders</a>
            </li>

            <li class="sidebar-item <?php echo ($active["customers"]) ? "active" : "" ?>">
                <svg class="sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <a href="<?php echo BASE_URL; ?>admin-customers.php">Customers</a>
            </li>

            <li class="sidebar-item <?php echo ($active["logout"]) ? "active" : "" ?>">
                <svg class="sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <a href="<?php echo BASE_URL; ?>logout.php">Logout</a>
            </li>
        </ul>
    </div>
</section>
