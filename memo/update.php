<?php
include '../db.php';

$id = $_POST['id'];
$content = $_POST['content'];
$stmt = $conn->prepare("UPDATE memo SET content = ? WHERE id = ?");
$stmt->bind_param("si", $content, $id);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['content_html'] = nl2br(htmlspecialchars($content));
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

$stmt->close();
header('Content-Type: application/json');
echo json_encode($response);
?>