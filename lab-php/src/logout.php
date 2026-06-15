<?php
session_start();

$_SESSION = [];
session_destroy();

header("Location: /labs/php/login.php");
exit;