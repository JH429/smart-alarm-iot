
<?php
include 'db.php';

// ID 받기
$id = $_POST['id'];

// SQL 인젝션 방지를 위한 준비된 구문 사용
$stmt = $conn->prepare("DELETE FROM alarm WHERE id = ?");
$stmt->bind_param("i", $id);

$response = array();

if ($stmt->execute()) {
    // 성공
    $response['success'] = true;
} else {
    // 실패
    $response['success'] = false;
    $response['error'] = $conn->error;
}

$stmt->close();

// JSON 응답 반환
header('Content-Type: application/json');
echo json_encode($response);
?>