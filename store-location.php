<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Store Location</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/store-location-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="store-page">
            <section class="store-hero">
                <div class="container">
                    <h1>Our Store Locations</h1>
                    <p class="tagline">Find a store near you</p>
                </div>
            </section>

            <section class="map-section container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9992366981875!2d2.295015651124501!3d48.85837007928745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66ef3e815bb47%3A0x9e5377d2d479fc35!2sEiffel%20Tower!5e0!3m2!1sen!2sfr!4v1692481287383!5m2!1sen!2sfr" 
                    width="100%" 
                    height="350" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </section>

            <section class="stores-section container">
                <h2>Visit Us In Person</h2>
                <div class="stores-grid">
                    <div class="store-card">
                        <i class="fas fa-store"></i>
                        <h3>Downtown Flagship</h3>
                        <p>123 Main Street, Metropolis</p>
                        <p><strong>Hours:</strong> Mon – Sat 9 AM – 8 PM</p>
                        <p><strong>Phone:</strong> +123 456 7890</p>
                    </div>
                    <div class="store-card">
                        <i class="fas fa-store"></i>
                        <h3>Uptown Outlet</h3>
                        <p>456 Elm Avenue, Gotham City</p>
                        <p><strong>Hours:</strong> Mon – Fri 10 AM – 7 PM</p>
                        <p><strong>Phone:</strong> +123 555 0123</p>
                    </div>
                    <div class="store-card">
                        <i class="fas fa-store"></i>
                        <h3>Suburb Mall</h3>
                        <p>789 Oak Drive, Star City</p>
                        <p><strong>Hours:</strong> Daily 11 AM – 9 PM</p>
                        <p><strong>Phone:</strong> +123 987 6543</p>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
