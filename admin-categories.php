<?php 
include_once("./config/config.php");
include_once("./config/db_connection.php");

function loadCategories($connection) {
    $query = "SELECT * FROM Category";
    $res = mysqli_query($connection, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }

    return $rows;
}

function createCategory($connection, $data) {
    $name = $data["name"];
    $description = $data["description"];

    $query = "insert into Category (name, description) values (?, ?)";

    $statement = mysqli_prepare($connection, $query);
    if (!$statement) {
        return "Error preparing query: " . mysqli_error($connection);
    }

    mysqli_stmt_bind_param($statement, "ss", $name, $description);

    if (mysqli_stmt_execute($statement)) {
        return "Category created successfully!";
    } 
    return "Error executing statement: " . mysqli_error($connection);

}

function updateCategory() {
}

function deleteCategory() {
}

if (isset($_POST["add"])) {
    createCategory($connection, $_POST);
}

$categories = loadCategories($connection);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Categories</title>
        <link rel="stylesheet" href="./assets/css/admin_styles.css">
        <link rel="stylesheet" href="./assets/css/admin-categories-styles.css">
    </head>
    <body>
        <?php include_once("./includes/admin_header.php"); ?>
        <main class="main-section">
            <?php include_once("./includes/admin_sidebar.php"); ?>
            <section class="content-section">
                <div class="create-section">
                    <h1>Categories</h1>
                    <form method="POST" action="admin-categories.php">
                        <input type="text" name="name" id="name" placeholder="Name" required />
                        <input type="text" name="description" placeholder="Description..." id="description" />
                        <button type="submit" name="add">ADD</button>
                    </form>
                </div>
                <div class="categories-section">
                    <?php 
                    foreach($categories as $category) {
                    ?>
                    <div class="category">
                        <h3>Name: <?php echo $category["name"]; ?></h3>
                        <p>Description: <?php echo ($category["description"] !== "") ? $category["description"] : "No description" ?></p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M12 20h9"/><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/><path d="m15 5 3 3"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </section>
        </main>
        <?php include_once("./includes/admin_footer.php"); ?>
    </body>
</html>
