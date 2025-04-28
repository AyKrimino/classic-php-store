<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}

if (!isset($_GET["id"])) {
    header("location:admin-customers.php");
}
$orderID = $_GET["id"];

function getCorrectImagePath($originalPath) {
    if ($originalPath === "") return "";
    return "http://" . HOSTNAME . substr($originalPath, strpos($originalPath, "/classic"));
}

function getItems($connection, $orderID) {
    $query = "
    select 
        OrderDetails.quantity,
        OrderDetails.price_to_purchase,
        Product.name,
        Product.image1
    from 
        OrderDetails,
        Product
    where 
        OrderDetails.product_id = Product.product_id
    and
        order_id = $orderID;
    ";
    $res = mysqli_query($connection, $query);

    $items = [];
    while ($item = mysqli_fetch_assoc($res)) {
        $item["subtotal"] = $item["quantity"] * $item["price_to_purchase"];
        array_push($items, $item);
    }
    return $items;
}

function getStatuses($connection, $orderID) {
    $query = "
    select 
        Orders.status as order_status,
        Payment.status as payment_status,
        Shipping.status as shipping_status 
    from 
        Orders,
        Payment,
        Shipping 
    where 
        Orders.order_id = Payment.order_id 
    and 
        Orders.order_id = Shipping.order_id
    and 
        Orders.order_id = $orderID;
    ";
    $res = mysqli_query($connection, $query);

    return mysqli_fetch_assoc($res);
}

function updateStatuses($connection, $data, $orderID) {
    $orderStatus = $data["order_status"];
    $paymentStatus = $data["payment_status"];
    $shippingStatus = $data["shipping_status"];

    mysqli_begin_transaction($connection);

    try {
        $orderQuery = "update Orders set status = ? where order_id = ?";

        $orderStatement = mysqli_prepare($connection, $orderQuery);
        mysqli_stmt_bind_param($orderStatement, "si", $orderStatus, $orderID);
        mysqli_stmt_execute($orderStatement);

        $paymentQuery = "update Payment set status = ?, payment_date = CURRENT_TIMESTAMP where order_id = ?";
        $paymentStatement = mysqli_prepare($connection, $paymentQuery);
        mysqli_stmt_bind_param($paymentStatement, "si", $paymentStatus, $orderID);
        mysqli_stmt_execute($paymentStatement);

        if ($shippingStatus === "shpped") {
            $shippingQuery = "update Shipping set status = ?, shipping_date = CURRENT_TIMESTAMP where order_id = ?";
            $shippingStatement = mysqli_prepare($connection, $shippingQuery);
        } else {
            $shippingQuery = "update Shipping set status = ? where order_id = ?";
            $shippingStatement = mysqli_prepare($connection, $shippingQuery);
        }
        mysqli_stmt_bind_param($shippingStatement, "si", $shippingStatus, $orderID);
        mysqli_stmt_execute($shippingStatement);

        mysqli_commit($connection);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($connection);
        return "Failed to update statuses: " . $e->getMessage();
    }
}

if (isset($_POST["update_status"])) {
    updateStatuses($connection, $_POST, $orderID);
}

$items = getItems($connection, $orderID);
$status = getStatuses($connection, $orderID);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Order # <?php echo $orderID ?></title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
        <link rel="stylesheet" href="./assets/css/admin-order-details-styles.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <div class="container">
                    <a href="admin-orders.php" class="back-link">&larr; Back to Orders</a>
                    <h1>Order #<?php echo $orderID; ?></h1>

                    <section class="status-update">
                        <h2>Update Statuses</h2>
                        <form method="POST" action="admin-order-details.php?id=<?php echo $orderID; ?>">
                            <label>
                                Order Status
                                <select name="order_status">
                                    <option 
                                        value="pending"
                                        <?php echo ($status["order_status"] === "pending" ? "selected" : ""); ?>
                                    >Pending</option>
                                    <option 
                                        value="shipped"
                                        <?php echo ($status["order_status"] === "shipped" ? "selected" : ""); ?>
                                    >Shipped</option>
                                    <option 
                                        value="delivered"
                                        <?php echo ($status["order_status"] === "delivered" ? "selected" : ""); ?>
                                    >Delivered</option>
                                    <option 
                                        value="cancelled"
                                        <?php echo ($status["order_status"] === "cancelled" ? "selected" : ""); ?>
                                    >Cancelled</option>
                                </select>
                            </label>
                            <label>
                                Payment Status
                                <select name="payment_status">
                                    <option 
                                        value="pending"
                                        <?php echo ($status["payment_status"] === "pending" ? "selected" : ""); ?>
                                    >Pending</option>
                                    <option 
                                        value="completed"
                                        <?php echo ($status["payment_status"] === "completed" ? "selected" : ""); ?>
                                    >Completed</option>
                                    <option 
                                        value="failed"
                                        <?php echo ($status["payment_status"] === "failed" ? "selected" : ""); ?>
                                    >Failed</option>
                                </select>
                            </label>
                            <label>
                                Shipping Status
                                <select name="shipping_status">
                                    <option 
                                        value="processing"
                                        <?php echo ($status["shipping_status"] === "processing" ? "selected" : ""); ?>
                                    >Processing</option>
                                    <option 
                                        value="shipped"
                                        <?php echo ($status["shipping_status"] === "shipped" ? "selected" : ""); ?>
                                    >Shipped</option>
                                    <option 
                                        value="delivered"
                                        <?php echo ($status["shipping_status"] === "delivered" ? "selected" : ""); ?>
                                    >Delivered</option>
                                </select>
                            </label>
                            <button type="submit" name="update_status" class="btn update-btn">Save Changes</button>
                        </form>
                    </section>

                    <section class="order-info">
                        <h2>Order Details</h2>
                        <table class="items-table">
                            <thead>
                                <tr><th>Product</th><th>Name</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($items as $item) { ?>
                                <tr>
                                    <td><img src="<?php echo getCorrectImagePath($item["image1"]); ?>" class="item-img"></td>
                                    <td><?php echo htmlspecialchars($item["name"]); ?></td>
                                    <td><?php echo $item["quantity"]; ?></td>
                                    <td><?php echo number_format($item["price_to_purchase"], 2); ?> DT</td>
                                    <td><?php echo number_format($item["subtotal"], 2); ?> DT</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
