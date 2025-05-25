
<?php
include 'db.php';

// ID와 내용 받기
$id = $_POST['id'];
$content = $_POST['content'];

// SQL 인젝션 방지를 위한 준비된 구문 사용
$stmt = $conn->prepare("UPDATE memo SET content = ? WHERE id = ?");
$stmt->bind_param("si", $content, $id);

$response = array();

if ($stmt->execute()) {
    // 성공
    $response['success'] = true;
    $response['content_html'] = nl2br(htmlspecialchars($content));
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