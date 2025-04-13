<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

function getCategoryNameByCategoryID($connection, $categoryID) {
    $query = "select name from Category where category_id = $categoryID";
    $res = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($res);

    return $row["name"];
}

function loadCategories($connection) {
    $query = "SELECT * FROM Category";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

function loadSubCategories($connection) {
    $query = "select * from Subcategory";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        $row["category_name"] = getCategoryNameByCategoryID($connection, $row["category_id"]);
        array_push($rows, $row);
    }

    return $rows;
}

function createSubCategory($connection, $data) {
    $categoryID = (int)$data["category"];
    $name = $data["name"];
    $description = $data["description"];

    $query = "insert into Subcategory (category_id, name, description) values (?, ?, ?)";

    $statement = mysqli_prepare($connection, $query);
    if (!$statement) {
        return "Error preparing query: " . mysqli_error($connection);
    }

    mysqli_stmt_bind_param($statement, "iss", $categoryID, $name, $description);

    if (mysqli_stmt_execute($statement)) {
        return "Subcategory created successfully!";
    } 
    return "Error executing statement: " . mysqli_error($connection);
}

function deleteSubCategory($connection, $data) {
    $subCategoryID = (int)$data["subcategory_id2"];
    
    $query = "DELETE FROM Subcategory WHERE subcategory_id = $subCategoryID";
    $res = mysqli_query($connection, $query);
    
    if ($res) {
        return "Category with id " . $subCategoryID . " deleted successfully.";
    }
    return "Error on delete category with id " . $subCategoryID;
}

function updateSubCategory($connection, $data) {
    $subCategoryID = (int)$data["subCategory_id"];
    $categoryID = (int)$data["category"];
    $name = $data["name"];
    $description = $data["description"];

    $query = "update Subcategory set category_id = ?, name = ?, description = ? where subcategory_id = ?";

    $statement = mysqli_prepare($connection, $query);
    if (!$statement) {
        return "Error preparing query: " . mysqli_error($connection);
    }

    mysqli_stmt_bind_param($statement, "issi", $categoryID, $name, $description, $subCategoryID);

    if (mysqli_stmt_execute($statement)) {
        return "SubCategory with id " . $subCategoryID . " updated successfully.";
    }
    return "Error executing statement: " . mysqli_error($connection);
}

if (isset($_POST["add"])) {
    createSubCategory($connection, $_POST);
}

if (isset($_POST["delete"])) {
    deleteSubCategory($connection, $_POST);
}

if (isset($_POST["update"])) {
    updateSubCategory($connection, $_POST);
}

$categories = loadCategories($connection);
$subCategories = loadSubCategories($connection);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Sub Categories</title>
        <link rel="stylesheet" href="assets/css/admin_styles.css" />
        <link rel="stylesheet" href="assets/css/admin-categories-styles.css" />
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <div class="create-section">
                    <h1>Sub Categories</h1>
                    <form method="POST" action="admin-subCategories.php">
                        <input type="text" name="name" id="name" placeholder="Name" required />
                        <input type="text" name="description" placeholder="Description..." id="description" />
                        <select name="category" id="category" required>
                            <option selected value="">Select a category</option>
                            <?php 
                            foreach($categories as $category) {
                            ?>
                            <option 
                                value="<?php echo $category["category_id"]; ?>"
                            >
                                <?php echo $category["name"]; ?>
                            </option>
                            <?php } ?>
                        </select> 
                        <input type="hidden" name="subCategory_id" id="subCategory_id" />
                        <button type="submit" name="add" id="add">ADD</button>
                        <button type="submit" name="update" hidden id="update">UPDATE</button>
                    </form>
                </div>
                <div class="categories-section">
                    <?php 
                    foreach($subCategories as $subCategory) {
                    ?>
                    <div class="category <?php echo $subCategory["subcategory_id"]; ?>">
                        <h3>Name: <?php echo $subCategory["name"]; ?></h3>
                        <h5>Category: <?php echo $subCategory["category_name"]; ?></h5>
                        <p>Description: <?php echo ($subCategory["description"] !== "") ? $subCategory["description"] : "No description" ?></p>
                        <svg 
                            class="lucide lucide-pencil-line-icon lucide-pencil-line edit"
                            data-sub-category-id="<?php echo $subCategory['subcategory_id']; ?>" 
                            data-category-id="<?php echo $subCategory['category_id']; ?>"
                            data-category-name="<?php echo htmlspecialchars($subCategory['category_name'], ENT_QUOTES); ?>"
                            data-name="<?php echo htmlspecialchars($subCategory['name'], ENT_QUOTES); ?>" 
                            data-description="<?php echo htmlspecialchars($subCategory['description'], ENT_QUOTES); ?>"
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
                        <form action="admin-subCategories.php" method="POST" class="delete-form" style="display:inline-block;">
                            <input type="hidden" name="subcategory_id2" value="<?php echo $subCategory['subcategory_id']; ?>" />
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
                    <?php
                    }
                    ?>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>

        <script src="./assets/js/subCategories.js"></script>
    </body>
</html>
