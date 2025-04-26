<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

if (!isset($_GET["id"])) {
    header("location:my-orders.php");
}

function getCorrectImagePath($originalPath) {
    if ($originalPath === "") return "";
    return "http://" . HOSTNAME . substr($originalPath, strpos($originalPath, "/classic"));
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

function isOrderExistAndIsUserOrderOwner($connection, $orderID, $customerID) {
    $query = "
    select customer_id
    from Orders
    where order_id = $orderID
    and customer_id = $customerID;
    ";
    $res = mysqli_query($connection, $query);
    return (mysqli_num_rows($res)) ? true : false;
}

function getOrder($connection, $orderID) {
    $query = "
    select 
        Orders.order_date,
        Orders.status as order_status,
        Orders.total_amount,
        Payment.status as payment_status,
        Shipping.status as shipping_status,
        Shipping.shipping_address
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

$orderID = (int)$_GET["id"];
$userID = (int)$_SESSION["user_id"];
$customerID = getCustomerIDByUserID($connection, $userID);
if (!isOrderExistAndIsUserOrderOwner($connection, $orderID, $customerID)) {
    header("location:my-orders.php");
    exit;
}

$order = getOrder($connection, $orderID);
$items = getItems($connection, $orderID);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order #<?php echo $orderID; ?></title>
        <link rel="stylesheet" href="./assets/css/styles.css" />
        <link rel="stylesheet" href="./assets/css/order-details-styles.css" />
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="order-details-page">
            <div class="container">
                <a href="my-orders.php" class="back-link">&larr; Back to My Orders</a>
                <h1>Order #<?php echo $orderID; ?></h1>
                <p class="order-date">Placed on <?php echo date("Y-m-d H:i", strtotime($order["order_date"])); ?></p>

                <ul class="status-tracker">
                    <li class="step step-complete">Order Placed</li>
                    <li class="step <?php echo $order["payment_status"] === "completed" ? "step-complete" : "step-current"; ?>">Payment</li>
                    <li class="step <?php echo in_array($order["shipping_status"], ["shipped", "delivered"]) ? "step-complete":($order["shipping_status"] === "processing" ? "step-current" : ""); ?>">Shipped</li>
                    <li class="step <?php echo $order["shipping_status"] === "delivered" ? "step-complete" : ""; ?>">Delivered</li>
                </ul>

                <section class="info-grid">
                    <div><strong>Order Status:</strong> <?php echo ucfirst($order["order_status"]); ?></div>
                    <div><strong>Payment Status:</strong> <?php echo ucfirst($order["payment_status"]); ?></div>
                    <div><strong>Shipping Status:</strong> <?php echo ucfirst($order["shipping_status"]); ?></div>
                    <div><strong>Total Amount:</strong> <?php echo number_format($order["total_amount"], 2); ?> DT</div>
                    <div class="full-width"><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order["shipping_address"]); ?></div>
                </section>

                <section class="items-section">
                    <h2>Items in Your Order</h2>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th><th>Name</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) { ?>
                            <tr>
                                <td><img class="item-img" src="<?php echo getCorrectImagePath($item["image1"]); ?>" alt=""></td>
                                <td><?php echo htmlspecialchars($item["name"]); ?></td>
                                <td><?php echo $item["quantity"]; ?></td>
                                <td><?php echo number_format($item["price_to_purchase"], 2); ?> DT</td>
                                <td><?php echo number_format($item["subtotal"], 2); ?> DT</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <div class="next-actions">
                    <a href="index.php" class="btn continue">Continue Shopping</a>
                    <a href="my-account.php" class="btn account">My Account</a>
                </div>
            </div>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
