<?php
if (php_sapi_name() === "cli") {
    $env = parse_ini_file(__DIR__ . "/../.env");
} else {
    $env = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/classic-php-store/.env");
}

define("HOSTNAME", $env["DB_HOST"]);
define("USERNAME", $env["DB_USER"]);
define("PASSWORD", $env["DB_PASS"]);
define("DATABASE", $env["DB_NAME"]);

$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$connection) {
    die("Database connection failed");
} 
?>
