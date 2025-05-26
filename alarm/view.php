<?php
$alarm_result = $conn->query("SELECT * FROM alarm ORDER BY alarm_time ASC");
if ($alarm_result->num_rows > 0) {
    while ($row = $alarm_result->fetch_assoc()) {
        $alarm_id = $row['id'];
        echo '<div class="alarm-item" id="alarm-'.$alarm_id.'" style="display: flex; align-items: center; background: white; padding: 10px; margin-bottom: 5px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
        echo '<div style="font-weight: bold; margin-right: 10px;">' . $row['alarm_time'] . '</div>';
        echo '<div style="flex-grow: 1;">' . htmlspecialchars($row['label']) . '</div>';
        echo '<div style="margin: 0 10px;">';
        echo '<label class="switch" style="position: relative; display: inline-block; width: 50px; height: 24px;">';
        echo '<input type="checkbox" onchange="toggleAlarm('.$alarm_id.')" checked style="opacity: 0; width: 0; height: 0;">';
        echo '<span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #2196F3; border-radius: 24px; transition: .4s;">';
        echo '<span style="position: absolute; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; border-radius: 50%; transform: translateX(26px); transition: .4s;"></span>';
        echo '</span>';
        echo '</label>';
        echo '</div>';
        echo '<button onclick="deleteAlarm('.$alarm_id.')" style="background: none; border: none; cursor: pointer; font-size: 18px;">🗑️</button>';
        echo '</div>';
    }
} else {
    echo "<p>등록된 알람이 없습니다.</p>";
}
?>
