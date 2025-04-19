<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/db_connection.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}

if (!isset($_GET["id"])) {
    header("location:admin-customers.php");
} else {
    $userID = $_GET["id"];
}

function loadCustomer($connection, $userID) {
    $query = "select * from User, Customer where User.user_id = $userID and Customer.user_id = $userID";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res);
}

function updateCustomer($connection, $data, $userID) {
    $name = $data["name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $address = $data["address"];
    $currentDate = date("Y-m-d H:i:s");

    $userUpdateQuery = "UPDATE User set name = ?, email = ?, phone = ?, updated_at = ? WHERE user_id = ?";
    $userUpdateStatement = mysqli_prepare($connection, $userUpdateQuery);
    if (!$userUpdateStatement) {
        return "Error preparing query " . mysqli_error($connection);
    }
    mysqli_stmt_bind_param($userUpdateStatement, "ssssi", $name, $email, $phone, $currentDate, $userID);
    if (!mysqli_stmt_execute($userUpdateStatement)) {
        return "Error executing statement.";
    }

    $customerUpdateQuery = "UPDATE Customer SET address = ? WHERE user_id = ?";
    $customerUpdateStatement = mysqli_prepare($connection, $customerUpdateQuery);
    if (!$customerUpdateStatement) {
        return "Error preparing query " . mysqli_error($connection);
    }
    mysqli_stmt_bind_param($customerUpdateStatement, "si", $address, $userID);
    if (!mysqli_stmt_execute($customerUpdateStatement)) {
        return "Error executing statement.";
    }
    header("location:admin-customers-edit.php?id=$userID");
}

$customer = loadCustomer($connection, $userID);

if (isset($_POST["edit"])) {
    updateCustomer($connection, $_POST, (int)$userID);
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
                <form method="POST" action="admin-customers-edit.php?id=<?php echo $userID; ?>">
                    <h1>Customer Edit</h1>
                    <input type="text" name="user-id" id="user-id" value="<?php echo $userID; ?>" readonly />
                    <input value="<?php echo $customer["name"]; ?>" type="text" name="name" id="name" placeholder="Name" required />
                    <input value="<?php echo $customer["email"]; ?>" type="email" name="email" id="email" placeholder="Email" required />
                    <input value="<?php echo $customer["phone"]; ?>" type="text" name="phone" id="phone" placeholder="Phone" />
                    <input value="<?php echo $customer["address"]; ?>" type="text" name="address" id="address" placeholder="Address" required />
                    <input type="text" name="role" id="role" value="Customer" readonly />
                    <input type="date" name="created-at" id="created-at" value="<?php echo date("Y-m-d", strtotime($customer["created_at"])); ?>" readonly />
                    <input type="date" name="updated-at" id="updated-at" value="<?php echo date("Y-m-d", strtotime($customer["updated_at"])); ?>" readonly />
                    <button type="submit" name="edit" id="edit">Edit</button>
                </form>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
