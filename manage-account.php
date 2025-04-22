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
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Manage Account</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/manage-account-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>

        <main class="manage-account-page">
            <section class="container">
                <h1>Manage Your Account</h1>

                <div class="forms-grid">
                    <form action="manage-account.php" method="POST" class="account-form">
                        <h2>Account Details</h2>
                        <label>
                            <span>Name</span>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>
                        </label>
                        <label>
                            <span>Email (cannot change)</span>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>" readonly>
                        </label>
                        <label>
                            <span>Phone</span>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>">
                        </label>
                        <label>
                            <span>Address</span>
                            <textarea name="address" rows="3"><?php echo htmlspecialchars($user["address"]); ?></textarea>
                        </label>
                        <button type="submit" name="update_profile" class="btn submit-btn">
                            Update Profile
                        </button>
                    </form>
                </div>
            </section>
        </main>

        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
