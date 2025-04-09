<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Dashboard</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <?php include_once("./includes/admin_sidebar.php"); ?>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
