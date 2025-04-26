<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

function getCustomerIDByUserID($connection, $userID) {
    $query = "
    select customer_id
    from Customer
    where user_id = $userID;
    ";
    $res = mysqli_query($connection, $query);
    return (int)mysqli_fetch_assoc($res)["customer_id"];
}

function getOrders($connection, $customerID) {
    $query = "
    select  
        Orders.order_id,
        Orders.order_date,
        Orders.status as order_status,
        Orders.total_amount,
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
        customer_id = $customerID;
    ";
    $res = mysqli_query($connection, $query);

    $orders = [];
    while ($order = mysqli_fetch_assoc($res)) {
        array_push($orders, $order);
    }
    return $orders;
}

$userID = (int)$_SESSION["user_id"];
$customerID = getCustomerIDByUserID($connection, $userID);
$orders = getOrders($connection, $customerID);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Orders</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/my-orders-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="orders-page">
            <div class="container">
                <h1>My Orders</h1>

                <?php if (empty($orders)) { ?>
                <p class="empty-state">You haven't placed any orders yet. <a href="index.php">Start shopping &rarr;</a></p>
                <?php } else { ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Shipping Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order) { ?>
                        <tr>
                            <td><?php echo $order["order_id"]; ?></td>
                            <td><?php echo date("Y-m-d", strtotime($order["order_date"])); ?></td>
                            <td><?php echo number_format($order["total_amount"], 2); ?> DT</td>
                            <td><span class="status-badge badge-<?php echo $order["order_status"]; ?>"><?php echo ucfirst($order["order_status"]); ?></span></td>
                            <td><span class="status-badge badge-<?php echo $order["payment_status"]; ?>"><?php echo ucfirst($order["payment_status"]); ?></span></td>
                            <td><span class="status-badge badge-<?php echo $order["shipping_status"]; ?>"><?php echo ucfirst($order["shipping_status"]); ?></span></td>
                            <td><a href="order-details.php?order_id=<?php echo $order["order_id"]; ?>" class="btn view-btn">View Details</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
