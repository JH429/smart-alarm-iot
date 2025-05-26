<?php
include '../db.php';

$id = $_POST['id'];
$stmt = $conn->prepare("DELETE FROM memo WHERE id = ?");
$stmt->bind_param("i", $id);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

$stmt->close();
header('Content-Type: application/json');
echo json_encode($response);
?>