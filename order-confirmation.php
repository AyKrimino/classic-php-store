<?php
require_once("./config/config.php");
require_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
    exit;
}

if (!isset($_GET["order_id"])) {
    header("location:index.php");
    exit;
}
$orderID = (int)$_GET["order_id"];

function getCorrectImagePath($originalPath) {
    if ($originalPath === "") return "";
    return "http://" . HOSTNAME . substr($originalPath, strpos($originalPath, "/classic"));
}

function getOrderByOrderID($connection, $orderID) {
    $query = "
    select 
        Orders.order_id,
        Orders.order_date,
        Orders.status as order_status,
        Orders.total_amount,
        Payment.status as payment_status,
        Payment.payment_date,
        Shipping.status as shipping_status,
        Shipping.shipping_address
    from Orders, Payment, Shipping
    where Payment.order_id = Orders.order_id
    and Shipping.order_id = Orders.order_id
    and Orders.order_id = $orderID;
    ";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res) ?: null;
}

function getItems($connection, $orderID) {
    $query = "
    select 
        OrderDetails.product_id,
        OrderDetails.quantity,
        OrderDetails.price_to_purchase,
        Product.name,
        Product.image1
    from OrderDetails, Product
    where Product.product_id = OrderDetails.product_id
    and OrderDetails.order_id = $orderID;
    ";
    $res = mysqli_query($connection, $query);

    $items = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row["subtotal"] = $row["quantity"] * $row["price_to_purchase"];
        $items[] = $row;
    }
    return $items;
}

$order = getOrderByOrderID($connection, $orderID);

if (!$order) {
    die("Order not found.");
}

$items = getItems($connection, $orderID);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Order Confirmation - #<?php echo $orderID; ?></title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/order-confirmation-styles.css">
    </head>
    <body>
        <?php include "./includes/header.php"; ?>

        <main class="confirmation-page">
            <div class="container">
                <section class="confirmation-hero">
                    <h1>Thank you for your order!</h1>
                    <p>Your order <strong>#<?php echo $orderID; ?></strong> has been placed successfully.</p>
                </section>

                <section class="order-info">
                    <h2>Order Details</h2>
                    <div class="info-grid">
                        <div><strong>Order Date:</strong> <?php echo date("Y-m-d H:i", strtotime($order["order_date"])); ?></div>
                        <div><strong>Order Status:</strong> <?php echo ucfirst($order["order_status"]); ?></div>
                        <div><strong>Payment Status:</strong> <?php echo ucfirst($order["payment_status"]); ?></div>
                        <div><strong>Shipping Status:</strong> <?php echo ucfirst($order["shipping_status"]); ?></div>
                        <div class="shipping-address" colspan="2">
                            <strong>Shipping Address:</strong>
                            <p><?php echo htmlspecialchars($order["shipping_address"]); ?></p>
                        </div>
                        <?php if ($order["payment_date"]) { ?>
                        <div><strong>Payment Date:</strong> <?php echo date("Y-m-d H:i", strtotime($order["payment_date"])); ?></div>
                        <?php } ?>
                        <div><strong>Total Amount:</strong> <?php echo number_format($order["total_amount"], 2); ?> DT</div>
                    </div>
                </section>

                <section class="items-summary">
                    <h2>Items in your Order</h2>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) { ?>
                            <tr>
                                <td class="item-img">
                                    <img src="<?php echo getCorrectImagePath($item["image1"]); ?>" alt="<?php echo htmlspecialchars($item["name"]); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($item["name"]); ?></td>
                                <td><?php echo $item["quantity"]; ?></td>
                                <td><?php echo number_format($item["price_to_purchase"], 2); ?> DT</td>
                                <td><?php echo number_format($item["subtotal"], 2); ?> DT</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <section class="next-steps">
                    <a href="index.php" class="btn continue-btn">Continue Shopping</a>
                    <a href="my-account.php" class="btn orders-btn">View My Orders</a>
                </section>
            </div>
        </main>

        <?php include "./includes/footer.php"; ?>
    </body>
</html>
