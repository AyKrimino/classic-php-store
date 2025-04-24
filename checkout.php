<?php
require_once("./config/config.php");
require_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
    exit;
}

function getProductByID($connection, $productID) {
    $query = "select * from Product where product_id = $productID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return null;
    }
    return mysqli_fetch_assoc($res);
}

function getTotal($products) {
    $res = 0;
    foreach ($products as $product) {
        $res += $product["subtotal"];
    }
    return $res;
}

function getAddedToCartProducts($connection, $cart) {
    $products = [];
    foreach ($cart as $productID => $qty) {
        $product = getProductByID($connection, $productID);
        if ($product !== null && $product["stock"] >= $qty) {
            $product["subtotal"] = $qty * $product["price"];
            $product["qty"] = $qty;
            array_push($products, $product);
        }
    }
    return $products;
}

function getUserInfo($connection, $userID) {
    $query = "select address, phone from User, Customer where Customer.user_id = $userID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return null;
    }
    return mysqli_fetch_assoc($res);
}

function getCustomerIDByUserID($connection, $userID) {
    $query = "select customer_id from Customer where user_id = $userID";
    $res = mysqli_query($connection, $query);
    return mysqli_fetch_assoc($res)["customer_id"];
}

function createOrder($connection, $customerID, $total) {
    $query = "
    insert into Orders(customer_id, status, total_amount)
    values (?, 'pending', ?);
    ";
    $statement = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($statement, "id", $customerID, $total);
    mysqli_stmt_execute($statement);
    return mysqli_insert_id($connection);
}

function createOrderDetails($connection, $orderID, $productID, $qty, $priceToPurchase) {
    $query = "
    insert into OrderDetails(order_id, product_id, quantity, price_to_purchase)
    values (?, ?, ?, ?);
    ";
    $statement = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($statement, "iiid", $orderID, $productID, $qty, $priceToPurchase);
    mysqli_stmt_execute($statement);
}

function updateStock($connection, $qty, $productID) {
    $query = "
        update Product
        set stock = stock - ?
        where product_id = ?;
    ";
    $statement = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($statement, "ii", $qty, $productID);
    mysqli_stmt_execute($statement);
}

function createPayment($connection, $orderID, $total) {
    $query = "
    insert into Payment(order_id, amount, status)
    values ($orderID, $total, 'pending');
    ";
    mysqli_query($connection, $query);
}

function createShipping($connection, $orderID, $shippingAddress) {
    $query = "
    insert into Shipping(order_id, shipping_address, status)
    values ($orderID, '$shippingAddress', 'processing');
    ";
    mysqli_query($connection, $query);
}

$userInfo = getUserInfo($connection, (int)$_SESSION["user_id"]);
if ($userInfo === null) {
    header("location:my-cart.php");
    exit;
}

$products = getAddedToCartProducts($connection, $_SESSION["cart"] ?? []);
$total = getTotal($products);

if (isset($_POST["place_order"])) {
    $shippingAddr = trim($_POST["shipping_address"]);
    $userID = $_SESSION["user_id"];
    $customerID = getCustomerIDByUserID($connection, $userID);

    mysqli_begin_transaction($connection);

    try {
        $orderID = createOrder($connection, $customerID, $total);

        foreach ($products as $product) {
            createOrderDetails($connection, $orderID, $product["product_id"], $product["qty"], $product["price"]);
            updateStock($connection, $product["qty"], $product["product_id"]);
        }

        createPayment($connection, $orderID, $total);

        $sa = mysqli_real_escape_string($connection, $shippingAddr);
        createShipping($connection, $orderID, $sa);

        mysqli_commit($connection);
        unset($_SESSION['cart']);

        header("location:order-confirmation.php?order_id=$orderID");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($connection);
        die("Order failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Checkout</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/checkout-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>

        <main class="checkout-page">
            <div class="container">
                <h1>Checkout</h1>
                <?php if (empty($products)) { ?>
                <p class="empty-cart">Your cart is empty. <a href="index.php">Continue Shopping</a></p>
                <?php } else { ?>
                <form method="POST" action="checkout.php">
                    <section class="order-summary">
                        <h2>Order Summary</h2>
                        <table>
                            <thead>
                                <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $product) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product["name"]); ?></td>
                                    <td><?php echo $product["qty"]; ?></td>
                                    <td><?php echo number_format($product["price"], 2); ?> DT</td>
                                    <td><?php echo number_format($product["subtotal"], 2); ?> DT</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="total-label">Total:</td>
                                    <td class="total-amount"><?php echo number_format($total, 2); ?> DT</td>
                                </tr>
                            </tfoot>
                        </table>
                    </section>

                    <section class="shipping-info">
                        <h2>Shipping Information</h2>
                        <label>
                            Address
                            <textarea name="shipping_address" required><?php
                                echo htmlspecialchars($userInfo["address"]);
                                ?></textarea>
                        </label>
                        <label>
                            Phone
                            <input type="text" name="shipping_phone"
                                value="<?php echo htmlspecialchars($userInfo["phone"]); ?>">
                        </label>
                    </section>

                    <section class="payment-info">
                        <h2>Payment Method</h2>
                        <label><input type="radio" name="payment_method" value="cod" checked> Cash on Delivery</label>
                    </section>

                    <div class="place-order">
                        <button type="submit" name="place_order" class="btn place-order-btn">
                            Place Order
                        </button>
                    </div>
                </form>
                <?php } ?>
            </div>
        </main>

        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
