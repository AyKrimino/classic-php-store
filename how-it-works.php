<?php 
require_once("./config/config.php");
require_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>How It Works</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/how-it-works-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="how-it-works-page">
            <section class="how-hero">
                <div class="container">
                    <h1>How It Works</h1>
                    <p class="tagline">Shop in 5 easy steps</p>
                </div>
            </section>

            <section class="steps-section container">
                <div class="steps-grid">
                    <div class="step">
                        <i class="fas fa-search"></i>
                        <h3>1. Browse Products</h3>
                        <p>Explore our wide catalog of quality items across multiple categories.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>2. Add to Cart</h3>
                        <p>Select your favorites and add them to your cart with a single click.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-credit-card"></i>
                        <h3>3. Secure Checkout</h3>
                        <p>Enter payment and shipping details on our encrypted checkout page.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-truck"></i>
                        <h3>4. Fast Delivery</h3>
                        <p>We process your order immediately and ship it to your door.</p>
                    </div>
                    <div class="step">
                        <i class="fas fa-smile-beam"></i>
                        <h3>5. Enjoy & Support</h3>
                        <p>Receive your order, enjoy it—and contact us anytime for help.</p>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
