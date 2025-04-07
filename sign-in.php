<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/auth-styles.css">
        <title>Document</title>
    </head>
    <body>
        <?php include("./includes/header.php"); ?>
        <section class="auth-container">
            <div class="">
                <form class="credentials-section" action="">
                    <h1>Sign in</h1>
                    <input type="email" name="email" id="email" placeholder="Email" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <a href="#">Forgot you password?</a>
                    <button type="submit">SIGN IN</button>
                </form>
                <div class="helper-section">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us.</p>
                    <button type="submit">SIGN UP</button>
                </div>
            </div>
        </section>
        <?php include("./includes/footer.php"); ?>
    </body>
</html>
