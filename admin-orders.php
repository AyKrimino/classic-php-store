<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_role"]) && $_SESSION["user_role"] !== "admin") {
    header("location:admin-sign-in.php");
}

function getOrders($connection) {
    $query = "
    select 
        Orders.order_id,
        User.name as customer_name,
        Orders.order_date,
        Orders.total_amount,
        Orders.status as order_status,
        Payment.status as payment_status,
        Shipping.status as shipping_status
    from 
        Orders,
        User,
        Customer,
        Shipping,
        Payment
    where 
        Orders.customer_id = Customer.customer_id 
    and 
        Customer.user_id = User.user_id
    and 
        Orders.order_id = Payment.order_id 
    and 
        Orders.order_id = Shipping.shipping_id;
    ";
    $res = mysqli_query($connection, $query);

    $orders = [];
    while ($order = mysqli_fetch_assoc($res)) {
        array_push($orders, $order);
    }
    return $orders;
}

$orders = getOrders($connection);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Orders</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
        <link rel="stylesheet" href="./assets/css/admin-orders-styles.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <div class="container">
                    <h1>All Orders</h1>

                    <?php if (empty($orders)) { ?>
                    <p class="empty-state">No orders have been placed yet.</p>
                    <?php } else { ?>
                    <table class="admin-orders-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Shipping Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?php echo $order["order_id"]; ?></td>
                                <td><?php echo htmlspecialchars($order["customer_name"]); ?></td>
                                <td><?php echo date("Y-m-d", strtotime($order["order_date"])); ?></td>
                                <td><?php echo number_format($order["total_amount"], 2); ?> DT</td>
                                <td><span class="status-badge badge-<?php echo $order["order_status"]; ?>"><?php echo ucfirst($order["order_status"]); ?></span></td>
                                <td><span class="status-badge badge-<?php echo $order["payment_status"]; ?>"><?php echo ucfirst($order["payment_status"]); ?></span></td>
                                <td><span class="status-badge badge-<?php echo $order["shipping_status"]; ?>"><?php echo ucfirst($order["shipping_status"]); ?></span></td>
                                <td>
                                    <a href="admin-order-details.php?id=<?php echo $order["order_id"]; ?>" class="btn view">View</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>

                    <div class="pagination">
                        <!-- pagination later -->
                    </div>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
