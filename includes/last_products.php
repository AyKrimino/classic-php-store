<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

function getRelativePath($absolutePath) {
    if ($absolutePath === "")
        return "";
    return substr($absolutePath, strpos($absolutePath, "assets"));
}

function getSubCategoryNameByID($subCategories, $subCategoryID) {
    foreach ($subCategories as $subCategory) {
        if ($subCategory["subcategory_id"] == $subCategoryID) {
            return $subCategory["name"];
        }
    }
    return "Not found";
}

function loadSubCategories($connection) {
    $query = "select * from Subcategory";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

function loadProducts($connection, $subCategories) {
    $query = "select * from Product order by created_at desc limit 6";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row["subcategory_name"] = getSubCategoryNameByID($subCategories, $row["subcategory_id"]);
        array_push($rows, $row);
    }

    return $rows;
}

$subCategories = loadSubCategories($connection);
$products = loadProducts($connection, $subCategories);
?>

<section class="products-section">
    <?php foreach($products as $product) { ?>
    <div class="product-card">
        <div class="slider">
            <div class="slides">
                <img class="product-img" hidden src="<?php echo getRelativePath($product["image1"] ?: ""); ?>" alt="Product Image 1" />
                <img class="product-img" hidden src="<?php echo getRelativePath($product["image2"] ?: ""); ?>" alt="Product Image 2" />
                <img class="product-img" hidden src="<?php echo getRelativePath($product["image3"] ?: ""); ?>" alt="Product Image 3" />
            </div>
        </div>

        <div class="product-info">
            <h3><?php echo htmlspecialchars($product["name"]); ?></h3>
            <h5><?php echo htmlspecialchars($product["subcategory_name"]); ?> | <?php echo htmlspecialchars($product["company"]); ?></h5>
            <p><?php echo htmlspecialchars($product["description"]); ?></p>
            <p>
                <span class="price"><?php echo number_format($product["price"],2); ?> DT</span> |
                <span class="stock"><?php echo $product["stock"] > 0 ? "<span style='color: green;'>In Stock</span>" : "<span style='color: #e74c3c;'>Out of Stock</span>"; ?></span>
            </p>
        </div>

        <div class="product-actions">
            <?php if($product["stock"] > 0) { ?>
                <button class="btn add-to-cart">
                    Add to Cart
                </button>
            <?php } else { ?>
                <span class="out-of-stock">Out of Stock</span>
            <?php } ?>
            <a class="btn view-details">
                View Details
            </a>
        </div>
    </div>
    <?php } ?>
</section>
