<?php
$allowedFiles = [
    "main.php",
    "board.php",
    "board_write.php",
    "board_view.php",
    "library.php",
    "library_view.php",
    "data_search.php",
    "login.php",
    "mfa.php",
    "layout.php",
    "db.php",
    "login.php",
    "mfa.php"
];

$file = $_GET["file"] ?? "";

if (!in_array($file, $allowedFiles, true)) {
    http_response_code(403);
    echo "허용되지 않은 파일입니다.";
    exit;
}

$path = __DIR__ . "/" . $file;

if (!file_exists($path)) {
    http_response_code(404);
    echo "파일을 찾을 수 없습니다.";
    exit;
}

header("Content-Type: text/plain; charset=UTF-8");
echo file_get_contents($path);