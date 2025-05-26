<?php
include '../db.php';

$alarm_time = $_POST['alarm_time'];
$label = $_POST['label'];
$stmt = $conn->prepare("INSERT INTO alarm (alarm_time, label) VALUES (?, ?)");
$stmt->bind_param("ss", $alarm_time, $label);

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