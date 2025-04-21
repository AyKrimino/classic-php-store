<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FAQS</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/faqs-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="faqs-page">
            <section class="faq-hero">
                <div class="container">
                    <h1>FAQs</h1>
                    <p class="tagline">Your questions, answered</p>
                </div>
            </section>

            <section class="faqs-content container">
                <h2>Frequently Asked Questions</h2>
                <div class="faqs-list">
                    <details>
                        <summary>What payment methods do you accept?</summary>
                        <p>We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and Apple Pay. All transactions are secure and encrypted.</p>
                    </details>

                    <details>
                        <summary>How can I track my order?</summary>
                        <p>Once your order ships, you’ll receive an email with a tracking number. Use that number on our courier’s website to see real‑time delivery updates.</p>
                    </details>

                    <details>
                        <summary>Do you ship internationally?</summary>
                        <p>Yes! We ship to over 50 countries worldwide. Shipping costs and delivery times vary by destination—enter your address at checkout for exact rates.</p>
                    </details>

                    <details>
                        <summary>How can I contact customer support?</summary>
                        <p>Reach us by email at <a href="#">support@example.com</a>, or call +123 456 7890 Mon–Fri, 9am–6pm.</p>
                    </details>
                </div>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
