<?php 
if (php_sapi_name() !== "cli") {
    exit("This script must be run from the command line.\n");
}

$options = getopt("n:e:p:", ["name", "email", "password"]);

$adminName = $options["n"] ?? $options["name"] ?? null;
$adminEmail = $options["e"] ?? $options["email"] ?? null;
$adminPassword = $options["p"] ?? $options["password"] ?? null;

if (!$adminName || !$adminEmail || !$adminPassword) {
    exit("Usage: php createsuperuser.php -n \"admin\" -e \"admin@admin.com\" -p \"Admin123\"\n");
}

include_once("./config/db_connection.php");

$hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

$query = "insert into User (name, email, password, role) values (?, ?, ?, 'admin')";

$statement = mysqli_prepare($connection, $query);
if (!$statement) {
    exit("Error preparing statement: " . mysqli_error($connection) . "\n");
}

mysqli_stmt_bind_param($statement, "sss", $adminName, $adminEmail, $hashedPassword);

if (mysqli_stmt_execute($statement)) {
    echo "Admin user '{$adminName}' created successfully!\n";
    $userID = mysqli_insert_id($connection);

    mysqli_stmt_close($statement);

    $adminQuery = "INSERT INTO Admin (user_id) VALUES (?)";
    $adminStatement = mysqli_prepare($connection, $adminQuery);
    if (!$adminStatement) {
        exit("Error preparing admin statement: " . mysqli_error($connection) . "\n");
    }
    mysqli_stmt_bind_param($adminStatement, "i", $userID);
    if (mysqli_stmt_execute($adminStatement)) {
        echo "Admin record inserted successfully in Admin table!\n";
    } else {
        echo "Error inserting into Admin table: " . mysqli_error($connection) . "\n";
    }
    mysqli_stmt_close($adminStatement);
} else {
    echo "Error: " . mysqli_error($connection) . "\n";
}

mysqli_close($connection);
?>
