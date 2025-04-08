<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (isset($_SESSION["user_id"]) && isset($_SESSION["email"])) {
    header("location:index.php");
}

/**
 * login user
 *
 * @param mysqli $connection The database connection.
 * @param array  $data       The login data (email, password).
 *
 * @return array An associative array with keys 'message' and 'toast_class'.
 */
function loginUser($connection, $data) {
    $email = $data["email"];
    $password = $data["password"];

    $query = "SELECT user_id, password FROM User WHERE email = '$email'";
    $res = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($res);

    if ($num_rows === 0) {
        return [
            "message" => "Invalid email or password",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    $row = mysqli_fetch_assoc($res);
    if (!password_verify($password, $row["password"])) {
        return [
            "message" => "Invalid email or password",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    $_SESSION["user_id"] = $row["user_id"];
    $_SESSION["email"] = $email;
    header("location:index.php");
    exit();

    return [];
}

$result = null;
if (isset($_POST["signin"])) {
    $result = loginUser($connection, $_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/sign-in-styles.css">
        <title>Sign In</title>
    </head>
    <body>
        <?php include("./includes/header.php"); ?>
        <section class="auth-container">
            <div class="">
                <form method="POST" class="credentials-section" action="./sign-in.php">
                    <?php if ($result) { ?>
                    <div style="color: <?php echo $result["toast_class"]; ?>;">
                        <?php echo $result["message"]; ?>
                    </div>
                    <?php } ?>
                    <h1>Sign in</h1>
                    <input type="email" name="email" id="email" placeholder="Email" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <a href="#">Forgot you password?</a>
                    <button type="submit" name="signin">SIGN IN</button>
                </form>
                <div class="helper-section">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us.</p>
                    <a class="redirect-btn" href="./sign-up.php">SIGN UP</a>
                </div>
            </div>
        </section>
        <?php include("./includes/footer.php"); ?>
    </body>
</html>
