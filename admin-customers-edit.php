<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/db_connection.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Customers edit</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
        <link rel="stylesheet" href="./assets/css/admin-customers-edit.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <form method="POST" action="admin-customers-edit.php">
                    <h1>Customer Edit</h1>
                    <input type="text" name="user-id" id="user-id" value="1" readonly />
                    <input type="text" name="name" id="name" placeholder="Name" required />
                    <input type="email" name="email" id="email" placeholder="Email" required />
                    <input type="text" name="phone" id="phone" placeholder="Phone" />
                    <input type="text" name="address" id="address" placeholder="Address" required />
                    <input type="text" name="role" id="role" value="Customer" readonly />
                    <input type="date" name="created-at" id="created-at" value="2024-03-14" readonly />
                    <input type="date" name="updated-at" id="updated-at" value="2024-03-14" readonly />
                    <button type="submit" name="edit" id="edit">Edit</button>
                </form>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
