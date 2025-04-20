<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:sign-in.php");
}

if (!isset($_GET["id"])) {
    header("location:index.php");
} else {
    $productID = $_GET["id"];
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

function getProduct($connection, $productID) {
    $query = "select * from Product where product_id = $productID";
    $res = mysqli_query($connection, $query);
    if (!$res) {
        return null;
    }
    $product = mysqli_fetch_assoc($res);
    $product["subCategory"] = getSubCategoryNameByID($connection, (int)$product["subcategory_id"]);
    $product["category"] = getCategoryNameBySubCategoryID($connection, (int)$product["subcategory_id"]);
    return $product;
}

$product = getProduct($connection, (int)$productID);
if ($product === null) {
    header("location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Dtails - <?php echo $productID; ?></title>
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/product-details-styles.css">
    </head>
    <body>
        <?php include_once("./includes/header.php"); ?>
        <div class="product-details-content">
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
                    <div class="line"></div>
                    <p><?php echo $product["description"]; ?></p>
                </div>
            </div>
            <div class="related-products-section"></div>
        </div>
        <?php include_once("./includes/footer.php"); ?>
        <script src="./assets/js/product-details.js"></script>
    </body>
</html>
