<?php include 'db.php'; ?>

<h2>⏰ 알람 설정</h2>
<form method="POST" action="add_alarm.php">
    알람 시간: <input type="datetime-local" name="alarm_time" required><br><br>
    알람 이름: <input type="text" name="label"><br><br>
    <button type="submit">알람 저장</button>
</form>

<hr>
<a href="view_alarms.php">📋 알람 목록 보기</a>
