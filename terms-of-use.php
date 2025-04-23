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
        <title>Terms Of Use</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/terms-of-use-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="terms-page">
            <!-- Hero/Banner -->
            <section class="terms-hero">
                <div class="container">
                    <h1>Terms of Use</h1>
                    <p class="tagline">Please read these terms carefully before using our site</p>
                </div>
            </section>

            <!-- Content -->
            <section class="terms-content container">
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing or using our website, you agree to be bound by these Terms of Use and all applicable laws and regulations. If you do not agree, please do not use this site.</p>

                <h2>2. Changes to Terms</h2>
                <p>We may revise these terms at any time by updating this page. Your continued use after changes constitutes acceptance of the new terms.</p>

                <h2>3. User Responsibilities</h2>
                <ul>
                    <li>You must be at least 18 years old to make purchases.</li>
                    <li>Keep your account credentials confidential.</li>
                    <li>Provide accurate information when placing orders.</li>
                </ul>

                <h2>4. Intellectual Property</h2>
                <p>All content on this site, including text, graphics, logos, and images, is the property of <strong>Shopping Online</strong> or its licensors and is protected by copyright and trademark laws.</p>

                <h2>5. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, <strong>Shopping Online</strong> shall not be liable for any indirect, incidental, or consequential damages arising from your use of the site.</p>

                <h2>6. Governing Law</h2>
                <p>These terms are governed by the laws of Tunisia, without regard to its conflict of laws principles.</p>

                <h2>7. Contact Us</h2>
                <p>If you have any questions about these Terms of Use, please contact us at <a href="#">support@example.com</a>.</p>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
