<?php
include 'db.php';

$alarm_time = $_POST['alarm_time'];
$label = $_POST['label'];

$stmt = $conn->prepare("INSERT INTO alarm (alarm_time, label) VALUES (?, ?)");
$stmt->bind_param("ss", $alarm_time, $label);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit;
