<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");
require_once("./includes/cart-summary.php");

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

function getProducts($connection, $startAt, $perPage, $categoryName) {
    $query = "select * from Product limit $startAt, $perPage";
    if ($categoryName !== "") {
        $query = "
        select * 
        from Product, Subcategory, Category
        where Product.subcategory_id = Subcategory.subcategory_id
        and Subcategory.category_id = Category.category_id
        and Category.name = '$categoryName'
        limit $startAt, $perPage;
        ";
    }
    $res = mysqli_query($connection, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row["subCategory"] = getSubCategoryNameByID($connection, (int)$row["subcategory_id"]);
        $row["category"] = getCategoryNameBySubCategoryID($connection, (int)$row["subcategory_id"]);
        array_push($rows, $row);
    }
    return $rows;
}

function getPagesNumber($connection, $perPage, $categoryName) {
    $query = "select count(*) as total from Product";
    if ($categoryName !== "") {
        $query = "
        select count(*) as total
        from Product, Subcategory, Category
        where Product.subcategory_id = Subcategory.subcategory_id
        and Subcategory.category_id = Category.category_id
        and Category.name = '$categoryName'
        ";
    }
    $res = mysqli_fetch_assoc(mysqli_query($connection, $query));
    $totalPages = (int)ceil($res["total"] / $perPage);
    return $totalPages;
}

$category = (isset($_GET["category"])) ? $_GET["category"] : "";

$perPage = 12;
$page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
if ($page < 1) {
    header("location:products.php?page=1");
}
$startAt = $perPage * ($page - 1);
$pages = getPagesNumber($connection, $perPage, $category);
if ($page > $pages) {
    header("location:products.php?page=$pages");
}

$products = getProducts($connection, $startAt, $perPage, $category);
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
                <div class="product-card">
                    <div class="slider">
                        <div class="slides">
                            <img class="product-img" src="<?php echo getCorrectImagePath($product["image1"]); ?>" alt="Product Image 1" />
                            <img class="product-img" hidden src="<?php echo getCorrectImagePath($product["image2"]); ?>" alt="Product Image 2" />
                            <img class="product-img" hidden src="<?php echo getCorrectImagePath($product["image3"]); ?>" alt="Product Image 3" />
                        </div>
                    </div>

                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
                        <h5><?php echo htmlspecialchars($product["subCategory"]); ?> | <?php echo htmlspecialchars($product["company"]); ?></h5>
                        <p><?php echo htmlspecialchars($product["description"]); ?></p>
                        <p>
                            <span class="price"><?php echo number_format($product["price"],2); ?> DT</span> |
                            <span class="stock"><?php echo $product["stock"] > 0 ? "<span style='color: green;'>In Stock</span>" : "<span style='color: #e74c3c;'>Out of Stock</span>"; ?></span>
                        </p>
                    </div>

                    <div class="product-actions">
                        <?php if($product["stock"] > 0) { ?>
                        <form action="./my-cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>" />
                            <button class="btn add-to-cart" name="add_to_cart">
                                Add to Cart
                            </button>
                        </form>
                        <?php } else { ?>
                        <span class="out-of-stock">Out of Stock</span>
                        <?php } ?>
                        <a class="btn view-details" href="./product-details.php?id=<?php echo $product["product_id"]; ?>">
                            View Details
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="pagination">
            <a 
                href="products.php?<?php echo ($category !== "") ? "category=$category&" : ""; ?>page=<?php echo ($page > 1) ? $page - 1 : 1; ?>" 
                class="prev <?php echo ($page <= 1) ? "disabled" : ""; ?>"
            >
                PREV
            </a>
            <a 
                href="products.php?<?php echo ($category !== "") ? "category=$category&" : ""; ?>page=<?php echo $page; ?>" 
                class="curr"
            >
                <?php echo $page; ?>
            </a>
            <a 
                href="products.php?<?php echo ($category !== "") ? "category=$category&" : ""; ?>page=<?php echo ($page < $pages) ? $page + 1 : $pages; ?>" 
                class="next <?php echo ($page >= $pages) ? "disabled" : ""; ?>"
            >
                NEXT
            </a>
        </div>
        <script src="./assets/js/productsList.js"></script>
        <?php include_once("./includes/footer.php"); ?>
    </body>
</html>
