<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

function getCorrectImagePath($originalPath) {
    if ($originalPath === "") return "";
    return "http://" . HOSTNAME . substr($originalPath, strpos($originalPath, "/classic"));
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

function handleAddToCart() {
    if (isset($_POST["add_to_cart"])) {
        $productID = $_POST["product_id"];
        if (isset($_SESSION["cart"][$productID])) {
            $_SESSION["cart"][$productID]++;
        } else {
            $_SESSION["cart"][$productID] = 1;
        }
    }
}

function incrementCartItem($connection, &$products, &$cart, $productID) {
    $product = getProductByID($connection, $productID);
    if ($product === null) return;

    foreach ($products as $product) {
        if ($product["product_id"] == $productID) {
            if ($product["stock"] >= $product["qty"] + 1) {
                $product["qty"]++;
                $cart[$productID] = $product["qty"];
            }
            header("location:my-cart.php");exit;
        }
    }
}

function decrementCartItem($connection, &$products, &$cart, $productID) {
    $product = getProductByID($connection, $productID);
    if ($product === null) return;

    foreach ($products as $product) {
        if ($product["product_id"] == $productID) {
            if ($product["qty"] - 1 >= 0) {
                $product["qty"]--;
                $cart[$productID] = $product["qty"];
            }
            header("location:my-cart.php");exit;
        }
    }
}

function removeCartItem(&$cart, $productID) {
    unset($cart[$productID]);
    header("location:my-cart.php"); exit;
}

handleAddToCart();
$products = getAddedToCartProducts($connection, $_SESSION["cart"]);
$total = getTotal($products);

if (isset($_POST["increment"])) {
    incrementCartItem($connection, $products, $_SESSION["cart"], (int)$_POST["product_id"]);
}

if (isset($_POST["decrement"])) {
    decrementCartItem($connection, $products, $_SESSION["cart"], (int)$_POST["product_id"]);
}

if (isset($_POST["remove_item"])) {
    removeCartItem($_SESSION["cart"], (int)$_POST["product_id"]);
}
require_once("./includes/cart-summary.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Cart</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/my-cart-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <main class="cart-page">
            <div class="container">
                <h1>My Cart</h1>

                <?php if (count($_SESSION["cart"]) === 0) { ?>
                <h3 class="empty-cart">Your Cart Is Empty.</h3>
                <?php } else { ?>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                        <tr class="cart-item">
                            <td class="product-img">
                                <img src="<?php echo getCorrectImagePath($product["image1"]); ?>" alt="<?php echo $product["name"]; ?>">
                            </td>
                            <td class="product-name">
                                <?php echo htmlspecialchars($product["name"]); ?>
                            </td>
                            <td class="product-qty">
                                <div class="qty-control">
                                    <form action="./my-cart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>" />
                                        <button class="qty-btn minus" name="decrement">−</button>
                                    </form>
                                    <input type="text" value="<?php echo $product["qty"]; ?>">
                                    <form action="./my-cart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>" />
                                        <button class="qty-btn plus" name="increment">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="product-price"><?php echo number_format($product["price"], 2); ?> DT</td>
                            <td class="product-subtotal"><?php echo number_format($product["subtotal"], 2); ?> DT</td>
                            <td class="product-remove">
                                <form action="./my-cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>" />
                                    <button class="remove-btn" name="remove_item">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="cart-total-row">
                            <td colspan="4" class="total-label">Total:</td>
                            <td class="total-amount"><?php echo number_format($total, 2); ?> DT</td>
                            <td class="checkout-cell">
                                <a href="./checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php } ?>
            </div>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
