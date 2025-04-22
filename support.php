<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Support</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/support-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="support-page">
            <section class="support-hero">
                <div class="container">
                    <h1>Support Center</h1>
                    <p class="tagline">We’re here to help you 24/7</p>
                </div>
            </section>

            <section class="support-content container">
                <h2>How can we assist you today?</h2>
                <div class="support-grid">
                    <div class="support-card">
                        <i class="fas fa-book"></i>
                        <h3>Knowledge Base</h3>
                        <p>Find quick answers in our comprehensive articles.</p>
                        <a href="#" class="link-btn">Go to KB</a>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-life-ring"></i>
                        <h3>Submit a Ticket</h3>
                        <p>Have an issue? Create a support ticket and we’ll respond ASAP.</p>
                        <a href="#" class="link-btn">Open Ticket</a>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-comments"></i>
                        <h3>Live Chat</h3>
                        <p>Chat with our support agents in real time.</p>
                        <a href="#" class="link-btn">Start Chat</a>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-phone"></i>
                        <h3>Phone Support</h3>
                        <p>Call us at <strong>+123 456 7890</strong>, Mon–Fri 9am–6pm.</p>
                        <a href="tel:+1234567890" class="link-btn">Call Now</a>
                    </div>

                    <div class="support-card">
                        <i class="fas fa-envelope"></i>
                        <h3>Email Us</h3>
                        <p>Send your queries to <a href="#">support@example.com</a>.</p>
                        <a href="#" class="link-btn">Send Email</a>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
