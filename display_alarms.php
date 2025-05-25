<?php
// This file assumes $conn (database connection) is already established
// and available from the file that includes this script (e.g., index.php).

$alarm_result = $conn->query("SELECT * FROM alarm ORDER BY alarm_time ASC");
if ($alarm_result->num_rows > 0) {
    while ($row = $alarm_result->fetch_assoc()) {
        $alarm_id = $row['id'];
        $alarm_time_formatted = date("Y-m-d H:i", strtotime($row['alarm_time'])); // Format for better readability
        $label = htmlspecialchars($row['label']);
        $is_active = isset($row['is_active']) ? (bool)$row['is_active'] : true; // Assuming a column 'is_active', default to true if not present

        echo '<div class="alarm-item" id="alarm-'.$alarm_id.'" style="display: flex; align-items: center; background: white; padding: 10px; margin-bottom: 5px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
        echo '<div style="font-weight: bold; margin-right: 10px;">' . $alarm_time_formatted . '</div>';
        echo '<div style="flex-grow: 1;">' . $label . '</div>';
        
        // Toggle switch
        echo '<div style="margin: 0 10px;">';
        echo '<label class="switch" style="position: relative; display: inline-block; width: 50px; height: 24px; margin: 0 10px;">';
        $checked_attr = $is_active ? 'checked' : '';
        echo '<input type="checkbox" onchange="toggleAlarm('.$alarm_id.', this)" '.$checked_attr.' style="opacity: 0; width: 0; height: 0;">';
        
        $slider_bg_color = $is_active ? '#2196F3' : '#ccc';
        $slider_transform = $is_active ? 'translateX(26px)' : 'translateX(0px)';
        
        echo '<span class="slider-background" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: '.$slider_bg_color.'; transition: .4s; border-radius: 24px;"></span>';
        echo '<span class="slider-circle" style="position: absolute; content: \'\'; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; transform: '.$slider_transform.';"></span>';
        echo '</label>';
        echo '</div>';
        
        // Delete button
        echo '<button onclick="deleteAlarm('.$alarm_id.')" style="background: none; border: none; cursor: pointer; font-size: 18px; color: #e74c3c;" title="Delete Alarm">🗑️</button>';
        echo '</div>';
    }
} else {
    echo "<p>등록된 알람이 없습니다.</p>";
}
?>