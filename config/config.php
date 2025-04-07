<?php 
define('DEBUG', true);  // should be false in production

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('BASE_URL', '/classic-php-store/');
?>
