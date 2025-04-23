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
        <title>Privacy Policy</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/privacy-policy-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="privacy-page">
            <section class="privacy-hero">
                <div class="container">
                    <h1>Privacy Policy</h1>
                    <p class="tagline">Your privacy is important to us</p>
                </div>
            </section>

            <section class="privacy-content container">
                <h2>1. Introduction</h2>
                <p>Welcome to <strong>Shopping Online</strong>. We respect your privacy and are committed to protecting your personal data. This policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

                <h2>2. Information We Collect</h2>
                <ul>
                    <li><strong>Personal Data:</strong> Name, email address, phone number, billing and shipping addresses.</li>
                    <li><strong>Payment Information:</strong> Credit card details (processed securely via our payment gateway).</li>
                    <li><strong>Usage Data:</strong> Pages viewed, time spent, search queries, and other analytics.</li>
                </ul>

                <h2>3. How We Use Your Data</h2>
                <p>We use your information to:</p>
                <ul>
                    <li>Process and fulfill your orders.</li>
                    <li>Communicate order confirmations and updates.</li>
                    <li>Improve our website and personalize your experience.</li>
                    <li>Send you marketing offers (with your consent).</li>
                </ul>

                <h2>4. Cookies & Tracking</h2>
                <p>We use cookies and similar tracking technologies to track activity on our site and hold certain information. You can disable cookies in your browser settings, but some features may not function properly.</p>

                <h2>5. Data Sharing</h2>
                <p>We may share your data with:</p>
                <ul>
                    <li><strong>Service Providers:</strong> Payment processors, shipping partners, and analytics providers.</li>
                    <li><strong>Legal Authorities:</strong> When required by law or to protect our rights.</li>
                </ul>

                <h2>6. Data Security</h2>
                <p>We implement industry‑standard security measures (SSL encryption, firewalls) to protect your data. However, no method of transmission over the Internet is 100% secure.</p>

                <h2>7. Your Rights</h2>
                <p>You have the right to access, correct, delete, or restrict the processing of your personal data. To exercise these rights, please contact us using the details below.</p>

                <h2>8. Contact Us</h2>
                <p>If you have questions about this Privacy Policy, please email us at <a href="#">privacy@example.com</a>.</p>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
