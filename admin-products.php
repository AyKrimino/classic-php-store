<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin - Products</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css" />
        <link rel="stylesheet" href="./assets/css/admin-products.css" />
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <div class="create-section">
                    <h1>Products</h1>
                    <form method="POST" action="admin-products.php" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Product Name" required />
                        <textarea name="description" placeholder="Product Description"></textarea>
                        <input type="text" name="company" placeholder="Company" />
                        <input type="file" name="image1" accept="image/*" />
                        <input type="file" name="image2" accept="image/*" />
                        <input type="file" name="image3" accept="image/*" />
                        <input type="number" step="0.01" name="price" placeholder="Price" required />
                        <select name="subcategory" id="subcategory">
                            <option selected>Subcategory</option>
                            <option value="">Mac book</option>
                            <option value="">Dell</option>
                        </select>
                        <input type="number" name="stock" placeholder="Stock" required />
                        <button type="submit" name="create">Create Product</button>
                        <button type="submit" name="update" hidden>Update Product</button>
                    </form>
                </div>

                <div class="products-section">
                    <div class="product-card">
                        <div class="slider">
                            <div class="slides">
                                <img class="product-img" hidden src="./assets/images/book1.jpg" alt="Product Image 1" />
                                <img class="product-img" hidden src="./assets/images/toys1.jpg" alt="Product Image 2" />
                                <img class="product-img" src="./assets/images/kitchen1.jpg" alt="Product Image 3" />
                            </div>
                        </div>

                        <div class="product-info">
                            <h3>Sample Product</h3>
                            <h5>Subcategory | company</h5>
                            <p>This is a sample product description. It gives an overview of the product features.</p>
                            <p>
                                <span class="price">$99.99</span> | 
                                <span class="stock">Stock: 15</span>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>

        <script src="./assets/js/products.js"></script>
    </body>
</html>
