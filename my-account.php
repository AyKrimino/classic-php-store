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
                <a href="#" class="logout-btn">Logout</a>
            </div>
            <div class="account-info">
                <h1>Saimon Hewitt</h1>
                <h3>saimon@gmail.com</h3>
                <div class="phone">
                    <h3>Phone Number</h3>
                    <h3>(+91) 90129 83208</h3>
                </div>
                <div class="line"></div>
                <div class="address">
                    <h3>Address</h3>
                    <h3>123 Demo Street, Sample City, Country</h3>
                </div>
                <div class="line"></div>
                <div class="joined-at">
                    <h3>Member Since</h3>
                    <h3>15 Jan 2025</h3>
                </div>
            </div>
        </div>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
