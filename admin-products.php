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

function getImages($files) {
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
    return $images;
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
    $query = "select * from Product";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $row["subcategory_name"] = getSubCategoryNameByID($subCategories, $row["subcategory_id"]);
        array_push($rows, $row);
    }

    return $rows;
}

function createProduct($connection, $data, $files) {
    $images = getImages($files);

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

function deleteProduct($connection, $data) {
    $productID = (int)$data["product_id"];

    $query = "DELETE FROM Product WHERE product_id = $productID";
    $res = mysqli_query($connection, $query);
    
    if ($res) {
        return "Category with id " . $productID . " deleted successfully.";
    }
    return "Error on delete category with id " . $productID;
}

function updateProduct($connection, $data, $files) {
    $images = getImages($files);

    $productID = $data["product_id"];
    $name = $data["name"];
    $description = $data["description"];
    $company = $data["company"];
    $price = (float)$data["price"];
    $subCategoryID = (int)$data["subcategory"];
    $stock = (int)$data["stock"];
    $current_date = date("Y-m-d H:i:s");

    $query = "
        UPDATE Product 
        SET name = ?, 
            description = ?, 
            company = ?, ";

    $bindTypes   = "sss";  
    $bindParams  = [$name, $description, $company];

    foreach (["image1", "image2", "image3"] as $key) {
        if ($images[$key] != "") {
            $query .= "$key = ?, ";
            $bindTypes .= "s";
            $bindParams[] = $images[$key];
        }
    }

    $query .= "price = ?, subcategory_id = ?, stock = ?, updated_at = ? WHERE product_id = ?";

    $bindTypes .= "diisi";
    $bindParams[] = $price;
    $bindParams[] = $subCategoryID;
    $bindParams[] = $stock;
    $bindParams[] = $current_date;
    $bindParams[] = $productID;

    $statement = mysqli_prepare($connection, $query);
    if (!$statement) {
        return "Error preparing query: " . mysqli_error($connection);
    }

    $bindNames = [];
    $bindNames[] = $bindTypes;
    foreach ($bindParams as $key => $value) {
        $bindNames[] = &$bindParams[$key];
    }

    call_user_func_array(array($statement, 'bind_param'), $bindNames);

    if (mysqli_stmt_execute($statement)) {
        return "Product updated successfully!";
    } else {
        return "Error executing statement: " . mysqli_error($connection);
    }
}

if (isset($_POST["create"])) {
    createProduct($connection, $_POST, $_FILES);
}

if (isset($_POST["update"])) {
    updateProduct($connection, $_POST, $_FILES);
}

if (isset($_POST["delete"])) {
    deleteProduct($connection, $_POST);
}

$subCategories = loadSubCategories($connection);
$products = loadProducts($connection, $subCategories);
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
                        <input id="name" type="text" name="name" placeholder="Product Name" required />
                        <textarea id="description" name="description" placeholder="Product Description"></textarea>
                        <input id="company" type="text" name="company" placeholder="Company" />
                        <input id="image1" type="file" name="image1" accept="image/*" />
                        <input id="image2" type="file" name="image2" accept="image/*" />
                        <input id="image3" type="file" name="image3" accept="image/*" />
                        <input id="price" type="number" step="0.01" name="price" placeholder="Price" required />
                        <select name="subcategory" id="subcategory">
                            <option selected value="">Subcategory</option>
                            <?php foreach($subCategories as $subCategory) { ?>
                                <option value="<?php echo $subCategory["subcategory_id"]; ?>"><?php echo $subCategory["name"]; ?></option>
                            <?php } ?>
                        </select>
                        <input id="stock" type="number" name="stock" placeholder="Stock" required />
                        <input type="hidden" name="product_id" id="product_id">
                        <button id="create" type="submit" name="create">Create Product</button>
                        <button id="update" type="submit" name="update" hidden>Update Product</button>
                    </form>
                </div>

                <div class="products-section">
                    <?php foreach($products as $product) { ?>
                    <div class="product-card">
                        <div class="slider">
                            <div class="slides">
                                <img class="product-img" hidden src="<?php echo getRelativePath(($product["image1"]) ? $product["image1"] : ""); ?>" alt="Product Image 1" />
                                <img class="product-img" hidden src="<?php echo getRelativePath(($product["image2"]) ? $product["image2"] : ""); ?>" alt="Product Image 2" />
                                <img class="product-img" hidden src="<?php echo getRelativePath(($product["image3"] !== null) ? $product["image3"] : ""); ?>" alt="Product Image 3" />
                            </div>
                        </div>

                        <div class="product-info">
                            <h3><?php echo $product["name"]; ?></h3>
                            <h5><?php echo $product["subcategory_name"]; ?> | <?php echo $product["company"]; ?></h5>
                            <p><?php echo $product["description"]; ?></p>
                            <p>
                                <span class="price"><?php echo $product["price"]; ?></span> | 
                                <span class="stock"><?php echo $product["stock"]; ?></span>
                            </p>


                            <svg 
                                class="lucide lucide-pencil-line-icon lucide-pencil-line edit"
                                data-product-id="<?php echo $product["product_id"]; ?>"
                                data-name="<?php echo htmlspecialchars($product["name"], ENT_QUOTES); ?>"
                                data-company="<?php echo htmlspecialchars($product["company"], ENT_QUOTES); ?>"
                                data-description="<?php echo htmlspecialchars($product["description"], ENT_QUOTES); ?>"
                                data-price="<?php echo $product["price"]; ?>"
                                data-subcategory-name="<?php echo htmlspecialchars($product["subcategory_name"], ENT_QUOTES); ?>"
                                data-subcategory-id="<?php echo $product["subcategory_id"]; ?>"
                                data-stock="<?php echo $product["stock"]; ?>"
                                xmlns="http://www.w3.org/2000/svg" 
                                width="24" 
                                height="24" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                stroke-linecap="round" 
                                stroke-linejoin="round">
                                <path d="M12 20h9"/>
                                <path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/>
                                <path d="m15 5 3 3"/>
                            </svg>
                            <form action="admin-products.php" method="POST" class="delete-form" style="display:inline-block;">
                                <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>" />
                                <button type="submit" name="delete" class="delete-btn">
                                    <svg 
                                        class="lucide lucide-trash2-icon lucide-trash-2 delete"
                                        xmlns="http://www.w3.org/2000/svg" 
                                        width="24" 
                                        height="24" 
                                        viewBox="0 0 24 24" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        stroke-width="2" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>

        <script src="./assets/js/products.js"></script>
    </body>
</html>
