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
                        <tr class="cart-item">
                            <td class="product-img">
                                <img src="./assets/images/book1.jpg" alt="Product Name">
                            </td>
                            <td class="product-name">
                                Awesome Widget
                            </td>
                            <td class="product-qty">
                                <div class="qty-control">
                                    <button class="qty-btn minus">−</button>
                                    <input type="text" value="1">
                                    <button class="qty-btn plus">+</button>
                                </div>
                            </td>
                            <td class="product-price">99.99 DT</td>
                            <td class="product-subtotal">199.98 DT</td>
                            <td class="product-remove">
                                <button class="remove-btn">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="cart-total-row">
                            <td colspan="4" class="total-label">Total:</td>
                            <td class="total-amount">199.98 DT</td>
                            <td class="checkout-cell">
                                <a href="#" class="btn checkout-btn">Proceed to Checkout</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
