<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
?>

<header>
    <div class="header-container">
        <nav>
            <div> 
                <ul class="nav-links">
                    <li class="nav-link">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            My Account
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            My Cart
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo BASE_URL; ?>sign-in.php" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in-icon lucide-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                           Sign in 
                        </a>
                    </li>
            </div>
            <div class="call-us-link">
                <a href="#"><span class="phone">Call Us:</span> (+91) 90129 83208</a>
            </div>
            <div>
                <ul class="secondary-links">
                    <li class="secondary-link">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-helping-icon lucide-hand-helping"><path d="M11 12h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 14"/><path d="m7 18 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 13 6 6"/></svg>
                            Support
                        </a>
                    </li>
                    <li class="secondary-link">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                            Store Location
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="line"></div>
        <section>
            <div class="logo">
                <a href="<?php echo BASE_URL; ?>index.php">
                    <h1>Shopping Online</h1>
                </a>
            </div>
            <div class="search-bar">
                <input type="text" class="search__input" placeholder="Search for products...">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-icon lucide-search">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
            </div>
            <div class="cart">
                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                    <div class="cart_icon"> 
                        <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918704/cart.png" alt="cart icon">
                        <div class="cart_count"><span>0</span></div>
                    </div>
                    <div class="cart_content">
                        <div class="cart_text"><a href="#">Cart</a></div>
                        <div class="cart_price">$0</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</header>
