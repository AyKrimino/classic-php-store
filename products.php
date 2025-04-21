<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

function getCorrectImagePath($originalPath) {
    if ($originalPath === "") return "";
    return "http://" . HOSTNAME . substr($originalPath, strpos($originalPath, "/classic"));
}

function getSubCategoryNameByID($connection, $subCategoryID) {
    $query = "select name from Subcategory where subcategory_id = $subCategoryID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return "";
    }
    return mysqli_fetch_assoc($res)["name"];
}

function getCategoryNameBySubCategoryID($connection, $subCategoryID) {
    $query = "select Category.name from Category, Subcategory where Subcategory.category_id = Category.category_id and subcategory_id = $subCategoryID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return "";
    }
    return mysqli_fetch_assoc($res)["name"];
}

function getProducts($connection) {
    $query = "select * from Product limit 10";
    $res = mysqli_query($connection, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row["subCategory"] = getSubCategoryNameByID($connection, (int)$row["subcategory_id"]);
        $row["category"] = getCategoryNameBySubCategoryID($connection, (int)$row["subcategory_id"]);
        array_push($rows, $row);
    }
    return $rows;
}

$products = getProducts($connection);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/products-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <div class="products-container">
            <div class="products-section">
                <?php foreach ($products as $product) { ?>
                <div class="product-section">
                    <div class="images-section">
                        <div class="main-image">
                            <img src="<?php echo getCorrectImagePath($product["image1"]); ?>" alt="image1">
                        </div>
                        <div class="slider-section">
                            <img src="<?php echo getCorrectImagePath($product["image1"]); ?>" alt="image1">
                            <img src="<?php echo getCorrectImagePath($product["image2"]); ?>" alt="image2">
                            <img src="<?php echo getCorrectImagePath($product["image3"]); ?>" alt="image3">
                        </div>
                    </div>
                    <div class="info-section">
                        <div class="">
                            <h1><?php echo $product["name"]; ?></h1>
                            <h3 class="company"><?php echo $product["company"]; ?></h3>
                            <h5><?php echo $product["category"]; ?> | <?php echo $product["subCategory"]; ?></h5>
                        </div>
                        <div class="price-stock">
                            <h3 class="stock"><?php echo ($product["stock"] > 0) ? "In Stock" : "Out Of Stock"; ?></h3>
                            <h1 class="price"><?php echo $product["price"]; ?> DT</h1>
                        </div>

                        <?php if($product["stock"] > 0) { ?>
                        <div class="action-buttons">
                            <button class="btn add-to-cart">
                                Add to Cart
                            </button>
                        </div>
                        <?php } ?>

                        <div class="line"></div>
                        <p><?php echo $product["description"]; ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <script src="./assets/js/productsList.js"></script>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
