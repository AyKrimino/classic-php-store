<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

function getUserByID($connection, $userID) {
    $query = "select * from User, Customer where User.user_id = Customer.user_id and User.user_id = $userID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return null;
    }
    return mysqli_fetch_assoc($res);
}

$userID = $_SESSION["user_id"];
$user = getUserByID($connection, $userID);
if ($user === null) {
    header("location:sign-in.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Account</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/my-account-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <div class="account-page-container">
            <div class="banner">
                <img src="assets/images/profile-banner.jpg" alt="Account Banner" />
            </div>
            <div class="avatar">
                <img src="assets/images/avatar.png" alt="Account Avatar" />
            </div>
            <div class="account-buttons">
                <a href="#" class="manage-account-btn">Manage account</a>
                <a href="./logout.php" class="logout-btn">Logout</a>
            </div>
            <div class="account-info">
                <h1><?php echo $user["name"]; ?></h1>
                <h3><?php echo $user["email"]; ?></h3>
                <div class="phone">
                    <h3>Phone Number</h3>
                    <h3><?php echo $user["phone"]; ?></h3>
                </div>
                <div class="line"></div>
                <div class="address">
                    <h3>Address</h3>
                    <h3><?php echo $user["address"]; ?></h3>
                </div>
                <div class="line"></div>
                <div class="joined-at">
                    <h3>Member Since</h3>
                    <h3><?php echo date_format(date_create($user["created_at"]), "Y-m-d"); ?></h3>
                </div>
            </div>
        </div>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
