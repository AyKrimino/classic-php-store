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

function getRelatedProducts($connection, $productID) {
    $query = "
    select distinct p2.*
    from Product as p1, Product as p2, Subcategory as s1, Subcategory as s2
    where p1.product_id = $productID
    and p2.product_id != p1.product_id
    and s1.subcategory_id = p1.subcategory_id
    and s2.subcategory_id = p2.subcategory_id
    and ( p2.subcategory_id = p1.subcategory_id
    or s2.category_id = s1.category_id
    );
    ";
    $res = mysqli_query($connection, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }
    return $rows;
}

$product = getProduct($connection, (int)$productID);
if ($product === null) {
    header("location:index.php");
}

$relatedProducts = getRelatedProducts($connection, (int)$productID);
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
            <h1 class="related-products-title">Products related to this item</h1>
            <div class="related-products-section">
                <svg id="related-prev" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                <div class="related-products-wrapper">
                    <?php foreach ($relatedProducts as $product) { ?>
                    <a href="product-details.php?id=<?php echo $product["product_id"]; ?>" class="related-product-card">
                            <img src="<?php echo getCorrectImagePath($product["image1"]); ?>" alt="image1">
                            <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
                            <h3 class="company"><?php echo $product["company"]; ?></h3>
                            <h2><?php echo $product["price"]; ?> DT</h2>
                    </a>
                    <?php } ?>
                </div>
                <svg id="related-next" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
        </div>
        <?php include_once("./includes/footer.php"); ?>
        <script src="./assets/js/product-details.js"></script>
    </body>
</html>
