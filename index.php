<!-- ✅ index.php - 메모 + 알람 앱 메인 -->
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="memo/memo.css">
    <link rel="stylesheet" href="alarm/alarm.css">
</head>
<body>
    <h1>메모 + 알람 설정</h1>

    <div class="section">
        <h2>내 메모</h2>
        <div class="memo-container">
            <div class="new-memo" onclick="createNewMemo()">
                <span class="new-memo-icon">+</span>
            </div>
            <?php include 'memo/view.php'; ?>
        </div>
    </div>

    <div class="alarm-section">
        <h2>알람 설정</h2>
        <form method="POST" action="alarm/add.php">
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="datetime-local" name="alarm_time" required>
                <input type="text" name="label" placeholder="알람 이름" style="flex-grow: 1;">
                <button type="submit">알람 추가</button>
            </div>
        </form>
        <div id="alarm-list">
            <?php include 'alarm/view.php'; ?>
        </div>
    </div>

    <script src="assets/js/utils.js"></script>
    <script src="memo/memo.js"></script>
    <script src="alarm/alarm.js"></script>
</body>
</html>
