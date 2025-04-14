<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

function loadSubCategories($connection) {
    $query = "select * from Subcategory";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

function createProduct($connection, $data, $files) {
    $uploadDir = __DIR__ . "/assets/images/products/";

    $images = [];
    foreach (["image1", "image2", "image3"] as $key) {
        if (isset($files[$key]) && $files[$key]["error"] === UPLOAD_ERR_OK) {
            $tmpName = $files[$key]["tmp_name"];
            $fileName = basename($files[$key]["name"]);
            $targetFile = $uploadDir . uniqid() . "_" . $fileName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $images[$key] = $targetFile;
            } else {
                $images[$key] = null;
            }
        } else {
            $images[$key] = null;
        }
    }

    $name = $data["name"];
    $description = $data["description"];
    $company = $data["company"];
    $price = (float)$data["price"];
    $subCategoryID = (int)$data["subcategory"];
    $stock = (int)$data["stock"];

    $query = "
    insert into Product 
    (name, description, company, image1, image2, image3, price, subcategory_id, stock)
    values (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $statement = mysqli_prepare($connection, $query);
    if (!$statement) {
        return "Error preparing query: " . mysqli_error($connection);
    }

    mysqli_stmt_bind_param(
        $statement, 
        "ssssssdii", 
        $name, 
        $description, 
        $company, 
        $images["image1"], 
        $images["image2"], 
        $images["image3"], 
        $price, 
        $subCategoryID, 
        $stock
    );

    if (mysqli_stmt_execute($statement)) {
        return "Product created successfully!";
    } else {
        return "Error executing statement: " . mysqli_error($connection);
    }
}

if (isset($_POST["create"])) {
    createProduct($connection, $_POST, $_FILES);
}

$subCategories = loadSubCategories($connection);
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
                            <option selected value="">Subcategory</option>
                            <?php foreach($subCategories as $subCategory) { ?>
                                <option value="<?php echo $subCategory["subcategory_id"]; ?>"><?php echo $subCategory["name"]; ?></option>
                            <?php } ?>
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
