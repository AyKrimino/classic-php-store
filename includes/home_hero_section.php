<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

function loadCategories($connection) {
    $query = "
    SELECT DISTINCT Category.name
    FROM Category, Subcategory, Product
    WHERE Category.category_id = Subcategory.category_id 
    AND Subcategory.subcategory_id = Product.subcategory_id
    LIMIT 8;
    ";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

$categories = loadCategories($connection);
?>

<section class="home-hero">
    <div class="categories-box">
        <div class="categories-header">
            <i class="fas fa-bars"></i>
            <span>CATEGORIES</span>
        </div>
        <ul class="category-list">
            <?php foreach ($categories as $category) { ?>
            <a href="products.php?category=<?php echo urlencode($category["name"]); ?>">
                <li>
                    <i class="fas fa-desktop"></i>
                    <?php echo htmlspecialchars(strtoupper($category["name"])); ?> 
                    <span>›</span>
                </li>
            </a>
            <?php } ?>
        </ul>
    </div>

    <div class="slider-box">
        <img id="slider-img" src="./assets/images/book1.jpg" alt="slider image" />
        <div class="slider-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <script src="./assets/js/slider.js"></script>

</section>
