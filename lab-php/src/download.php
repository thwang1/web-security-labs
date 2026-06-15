<?php
$fileName = $_GET["fileName"] ?? "";

$filePath = __DIR__ . "/files/" . $fileName;

if (!file_exists($filePath)) {
    http_response_code(404);
    echo "파일을 찾을 수 없습니다.";
    exit;
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($fileName) . "\"");
header("Content-Length: " . filesize($filePath));

readfile($filePath);
exit;