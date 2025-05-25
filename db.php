<?php
// db.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "memo_app";

// MySQL 연결
$conn = new mysqli($host, $user, $pass, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}
?>
