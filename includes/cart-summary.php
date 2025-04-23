<?php
$cartItemCount = 0;
$cartTotal = 0.0;

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

foreach ($_SESSION['cart'] as $qty) {
  $cartItemCount += $qty;
}

if ($cartItemCount > 0) {
  foreach ($_SESSION['cart'] as $productId => $qty) {
    $row = mysqli_fetch_assoc(
      mysqli_query($connection, "SELECT price FROM Product WHERE product_id = $productId")
    );
    if ($row) {
      $cartTotal += $row['price'] * $qty;
    }
  }
}
