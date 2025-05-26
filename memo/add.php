<?php
include '../db.php';

$content = $_POST['content'];
$stmt = $conn->prepare("INSERT INTO memo (content) VALUES (?)");
$stmt->bind_param("s", $content);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['id'] = $conn->insert_id;
    $response['content'] = htmlspecialchars($content);
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

$stmt->close();
header('Content-Type: application/json');
echo json_encode($response);
?>