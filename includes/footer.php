<?php
include_once("./config/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
?>
<footer>
    <div class="footer-container">
        <div class="newsletter">
            <h1>Subscribe To Our Newsletter</h1>
            <p>Stay in touch with the latest news and releases</p>
            <form action="">
                <div class="newsletter-subscribe">
                    <input type="text" name="" id="" placeholder="Enter your email address">
                    <button type="submit">Subscribe</button>
                </div>
            </form>
        </div>

        <div class="line"></div>

        <div class="main-footer">
            <div class="description">
                <h3>Shopping Online</h3>
                <p>Your trusted destination for quality products, seamless shopping, and fast delivery. Enjoy a smooth and secure online shopping experience, anytime, anywhere.</p>
                <ul class="social-media-icons">
                    <li>
                        <a class="social-media-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook-icon lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a class="social-media-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                    </li>
                    <li>
                        <a class="social-media-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter-icon lucide-twitter"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a class="social-media-icon" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin-icon lucide-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="company">
                <h3>Company</h3>
                <ul class="company-links">
                    <li>
                        <a href="#">About Us</a>
                    </li>
                    <li>
                        <a href="#">Our Products</a>
                    </li>
                    <li>
                        <a href="#">Contact Us</a>
                    </li>
                    <li>
                        <a href="#">How It Works</a>
                    </li>
                </ul>
            </div>
            <div class="ressources">
                <h3>Ressources</h3>
                <ul class="ressources-links">
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Terms Of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="account">
                <h3>Account</h3>
                <ul class="account-links">
                    <?php 
                    if (isset($_SESSION["user_id"]) && isset($_SESSION["email"])) {
                    ?>
<li><a href="<?php echo BASE_URL ?>profile.php">My Account</a></li>
<li><a href="<?php echo BASE_URL ?>logout.php">Logout</a></li>
                    <?php
                    } else {
                    ?>
<li><a href="<?php echo BASE_URL ?>sign-in.php">Sign In</a></li>
<li><a href="<?php echo BASE_URL ?>sign-up.php">Sign Up</a></li>
                    <?php
                    }
                    ?>
</ul>
</div>
        </div>

        <div class="line"></div>

        <div class="copyright">
            <p>&copy; <?php echo date("Y"); ?> Shopping Online - All Rights Reserved.</p>
        </div>

    </div>


</footer>
