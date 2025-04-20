<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/config/db_connection.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}

function loadCustomers($connection) {
    $query = "SELECT * FROM User, Customer where User.user_id = Customer.user_id";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

function deleteCustomer($connection, $userID) {
    $query = "DELETE FROM User WHERE user_id = $userID";
    $res = mysqli_query($connection, $query);

    if ($res) {
        echo mysqli_error($connection);
        return "User with id " . $userID . " deleted successfully.";
    }
    return "Error on delete User with id " . $userID;
}

function deleteSelectedCustomers($connection, $selectedCustomers) {
    foreach ($selectedCustomers as $selectedCustomer) {
        deleteCustomer($connection, (int)$selectedCustomer);
    }
}

if (isset($_POST["action"])) {
    foreach ($_POST["action"] as $action) {
        if (str_starts_with($action, "delete")) {
            $userID = substr($action, 6);
            deleteCustomer($connection, (int)$userID);
        }
    }
}

if (isset($_POST["action"]) && in_array("suspend_selected", $_POST["action"])) {
    deleteSelectedCustomers($connection, $_POST["selected_customers"]);
}

$customers = loadCustomers($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Customers</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
        <link rel="stylesheet" href="./assets/css/admin-customers.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <form method="POST" action="admin-customers.php" id="bulk-form">

                    <div class="bulk-actions">
                        <label>
                            <input type="checkbox" id="select-all" />
                            Select All
                        </label>

                        <button type="submit" name="action[]" value="suspend_selected" class="bulk-btn">
                            Suspend Selected
                        </button>
                    </div>

                    <table class="customers-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Address</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($customers as $customer) { ?>
                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        name="selected_customers[]"
                                        class="row-checkbox"
                                        value="<?php echo $customer['user_id']; ?>"
                                    />
                                </td>
                                <td><?php echo $customer['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone'] ?: '—'); ?></td>
                                <td><?php echo htmlspecialchars($customer['role']); ?></td>
                                <td><?php echo htmlspecialchars($customer['address']); ?></td>
                                <td><?php echo date('Y‑m‑d', strtotime($customer['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="admin-customers-edit.php?id=<?php echo $customer["user_id"]; ?>">
                                        <svg 
                                            class="lucide lucide-pencil-line-icon lucide-pencil-line edit"
                                            xmlns="http://www.w3.org/2000/svg" 
                                            width="24" 
                                            height="24" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round">
                                            <path d="M12 20h9"/>
                                            <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/>
                                            <path d="m15 5 3 3"/>
                                        </svg>
                                    </a>

                                    <button type="submit" name="action[]" value="delete<?php echo $customer["user_id"]; ?>" class="delete-btn">
                                        <svg 
                                            class="lucide lucide-trash2-icon lucide-trash-2 delete"
                                            xmlns="http://www.w3.org/2000/svg" 
                                            width="24" 
                                            height="24" 
                                            viewBox="0 0 24 24" 
                                            fill="none" 
                                            stroke="currentColor" 
                                            stroke-width="2" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            <line x1="10" x2="10" y1="11" y2="17"/>
                                            <line x1="14" x2="14" y1="11" y2="17"/>
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
        <script src="./assets/js/adminCustomers.js"></script>
    </body>
</html>
