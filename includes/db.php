<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery_store";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラー確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
