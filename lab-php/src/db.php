<?php
function get_db() {
    $host = getenv("DB_HOST") ?: "lab-php-db";
    $dbName = getenv("DB_NAME") ?: "php_lab";
    $user = getenv("DB_USER") ?: "php_lab_user";
    $pass = getenv("DB_PASSWORD") ?: "php_lab_pass";

    $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    return $pdo;
}