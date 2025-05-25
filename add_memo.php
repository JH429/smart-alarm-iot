<?php
include 'db.php';

$memo_date = $_POST['memo_date'];
$content = $_POST['content'];

$stmt = $conn->prepare("INSERT INTO memo (memo_date, content) VALUES (?, ?)");
$stmt->bind_param("ss", $memo_date, $content);

$response = array();

if ($stmt->execute()) {
    // 성공 시 새로 생성된 메모 ID 가져오기
    $new_id = $conn->insert_id;
    $response['success'] = true;
    $response['id'] = $new_id;
    $response['content'] = htmlspecialchars($content);
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