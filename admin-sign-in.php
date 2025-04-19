<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/db_connection.php");

if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "admin") {
    header("location:admin-dashboard.php");
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

    $query = "SELECT user_id, password, role FROM User WHERE email = '$email'";
    $res = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($res);

    if ($num_rows === 0) {
        return [
            "message" => "Invalid email or password",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    $row = mysqli_fetch_assoc($res);

    if ($row["role"] !== "admin") {
        return [
            "message" => "Invalid email or password",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    if (!password_verify($password, $row["password"])) {
        return [
            "message" => "Invalid email or password",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    $_SESSION["admin_user_id"] = $row["user_id"];
    $_SESSION["admin_email"] = $email;
    $_SESSION["user_role"] = $row["role"];
    header("location:admin-dashboard.php");
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
        <title>Admin - Sign In</title>
        <link rel="stylesheet" href="assets/css/admin_styles.css">
        <link rel="stylesheet" href="assets/css/admin-sign-in-styles.css">
    </head>
    <body>
        <?php include_once("includes/admin_header.php"); ?>
        <section class="auth-container">
            <div>
                <form method="POST" class="credentials-section" action="admin-sign-in.php">
                    <?php if ($result) { ?>
                    <div style="color: <?php echo $result["toast_class"]; ?>;">
                        <?php echo $result["message"]; ?>
                    </div>
                    <?php } ?>
                    <h1>Sign in</h1>
                    <input type="email" name="email" id="email" placeholder="Email" />
                    <input type="password" name="password" id="password" placeholder="Password" />
                    <button type="submit" name="signin">SIGN IN</button>
                </form>
            </div>
        </section>
        <?php include_once("includes/admin_footer.php"); ?>
    </body>
</html>
