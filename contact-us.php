<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
        <link rel="stylesheet" href="./assets/css/styles.css" />
        <link rel="stylesheet" href="./assets/css/contact-us-styles.css" />
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="contact-page">
            <section class="contact-hero">
                <div class="container">
                    <h1>Contact Us</h1>
                    <p class="tagline">We’d love to hear from you!</p>
                </div>
            </section>

            <section class="contact-content container">
                <div class="contact-details">
                    <h2>Get in Touch</h2>
                    <p>If you have any questions, feel free to reach out:</p>
                    <ul>
                        <li><strong>Address:</strong> 123 Demo Street, Sample City, Country</li>
                        <li><strong>Phone:</strong> +123 456 7890</li>
                        <li><strong>Email:</strong> support@example.com</li>
                        <li><strong>Hours:</strong> Mon – Fri, 9:00 AM – 6:00 PM</li>
                    </ul>
                </div>

                <div class="contact-form">
                    <h2>Send Us a Message</h2>
                    <form action="#" method="POST">
                        <div class="form-row">
                            <input type="text" name="name" placeholder="Your Name" required />
                            <input type="email" name="email" placeholder="Your Email" required />
                        </div>
                        <div class="form-row">
                            <input type="text" name="subject" placeholder="Subject" required />
                        </div>
                        <div class="form-row">
                            <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn submit-btn">Send Message</button>
                    </form>
                </div>
            </section>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
