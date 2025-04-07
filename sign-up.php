<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

/**
 * Registers a new user and returns an array with a message and a toast class color.
 *
 * @param mysqli $connection The database connection.
 * @param array  $data       The registration data (name, email, phone, address, password, confirm_password).
 *
 * @return array An associative array with keys 'message' and 'toast_class'.
 */
function registerUser($connection, $data) {
    $name = $data["name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $address = $data["address"];
    $password = $data["password"];
    $confirm_password = $data["confirm_password"];

    if ($password !== $confirm_password) {
        return [
            "message" => "Passwords didn't match.",
            "toast_class" => "#dc3545" // Danger color
        ];
    }

    $select_query = "SELECT user_id FROM User WHERE email = '$email'";
    $res = mysqli_query($connection, $select_query);
    if (!$res) {
        return [
            "message" => "Database query error.",
            "toast_class" => "#dc3545"
        ];
    }
    if (mysqli_num_rows($res) > 0) {
        return [
            "message" => "Email already exist with another account. Please try with another email",
            "toast_class" => "#007bff" // Primary color
        ];
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user_insert_query = "INSERT INTO User (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
    if (!mysqli_query($connection, $user_insert_query)) {
        return [
            "message" => "Internal server error during user insertion.",
            "toast_class" => "#dc3545"
        ];
    }

    $user_id = mysqli_insert_id($connection);

    $customer_insert_query = "INSERT INTO Customer (user_id, address) VALUES ($user_id, '$address')";
    if (!mysqli_query($connection, $customer_insert_query)) {
        return [
            "message" => "Internal server error during customer insertion.",
            "toast_class" => "#dc3545"
        ];
    }

    return [
        "message" => "Registered successfully",
        "toast_class" => "#28a745" // Success color
    ];
}

$result = null;
if (isset($_POST["signup"])) {
    $result = registerUser($connection, $_POST);
}
?>

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
                <form class="credentials-section" action="./sign-up.php" method="POST">
                    <?php if ($result) { ?>
                    <div style="color: <?php echo $result["toast_class"]; ?>;">
                        <?php echo $result["message"]; ?>
                    </div>
                    <?php } ?>
                    <h1>Create Account</h1>
                    <input type="email" name="email" id="email" placeholder="Email" required />
                    <input type="text" name="name" id="name" placeholder="Name" required />
                    <input type="text" name="phone" id="phone" placeholder="Phone" required />
                    <input type="text" name="address" id="address" placeholder="Address" required />
                    <input type="password" name="password" id="password" placeholder="Password" required />
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                    <button type="submit" name="signup">SIGN UP</button>
                </form>
            </div>
        </section>
        <?php include("./includes/footer.php"); ?>
    </body>
</html>
