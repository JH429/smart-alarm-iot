<?php
$memo_result = $conn->query("SELECT * FROM memo ORDER BY id DESC");
while ($row = $memo_result->fetch_assoc()) {
    $id = $row['id'];
    echo '<div class="memo-item" id="memo-' . $id . '">';
    echo '<input type="checkbox" class="memo-check" onchange="toggleMemoComplete(' . $id . ')">';
    echo '<div class="memo-content" id="content-' . $id . '" contenteditable="true" onblur="saveMemoInline(' . $id . ')">' . nl2br(htmlspecialchars($row['content'])) . '</div>';
    echo '<div class="memo-actions">';
    echo '<button class="memo-delete-btn" onclick="deleteMemo(' . $id . ')">🗑️</button>';
    echo '</div>';
    echo '</div>';
}
?>
