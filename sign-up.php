<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/sign-up-styles.css">
        <title>Sign Up</title>
    </head>
    <body>
        <?php include("./includes/header.php"); ?>
        <section class="auth-container">
            <div class="">
                <div class="helper-section">
                    <h1>Welcome, Back!</h1>
                    <p>To keep connected with us please login with your personal info.</p>
                    <a href="./sign-in.php" class="redirect-btn">SIGN IN</a>
                </div>
                <form class="credentials-section" action="">
                    <h1>Create Account</h1>
                    <input type="email" name="email" id="email" placeholder="Email" />
                    <input type="text" name="name" id="name" placeholder="Name" />
                    <input type="text" name="phone" id="phone" placeholder="Phone" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <button type="submit">SIGN UP</button>
                </form>
            </div>
        </section>
        <?php include("./includes/footer.php"); ?>
    </body>
</html>
