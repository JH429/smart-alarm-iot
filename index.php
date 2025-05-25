
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 포스트잇 메모</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        h1, h2, h3 {
            color: #2c3e50;
        }
        
        h1 {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        
        .memo-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            margin-bottom: 30px;
        }
        
        .memo-item {
            background: #fdffa3;
            padding: 15px;
            border-radius: 2px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            width: 220px;
            min-height: 150px;
            position: relative;
            transform: rotate(1deg);
            transition: all 0.2s ease;
        }
        
        .memo-item:nth-child(2n) {
            transform: rotate(-1deg);
            background: #ffeeb8;
        }
        
        .memo-item:nth-child(3n) {
            transform: rotate(2deg);
            background: #d1f7c0;
        }
        
        .memo-item:hover {
            transform: rotate(0) scale(1.02);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
            z-index: 10;
        }
        
        .memo-content {
            white-space: pre-line;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            min-height: 120px;
            overflow-wrap: break-word;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .memo-check {
            position: absolute;
            top: 10px;
            right: 10px;
            transform: scale(1.5);
            z-index: 5;
        }
        
        .memo-actions {
            position: absolute;
            bottom: 5px;
            right: 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .memo-item:hover .memo-actions {
            opacity: 1;
        }
        
        .memo-edit-btn, .memo-delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 3px;
            color: #555;
        }
        
        .memo-edit-btn:hover {
            color: #3498db;
        }
        
        .memo-delete-btn:hover {
            color: #e74c3c;
        }
        
        .editable-content {
            min-height: 120px;
            outline: none;
            width: 100%;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: transparent;
            border: none;
            resize: none;
            overflow: hidden;
        }
        
        .completed {
            text-decoration: line-through;
            opacity: 0.7;
        }
        
        .hidden {
            display: none;
        }
        
        .new-memo {
            background: #a8e6cf;
            padding: 15px;
            border-radius: 2px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            width: 220px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transform: rotate(-1deg);
            transition: all 0.2s ease;
            position: relative;
        }
        
        .new-memo:hover {
            transform: rotate(0) scale(1.02);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }
        
        .new-memo-icon {
            font-size: 36px;
            color: #2c3e50;
        }
        
        .edit-buttons {
            position: absolute;
            bottom: 5px;
            right: 5px;
            display: flex;
            gap: 5px;
        }
        
        .edit-save, .edit-cancel {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 3px 8px;
            font-size: 12px;
            cursor: pointer;
        }
        
        .edit-save:hover {
            background: #d1f7c0;
        }
        
        .edit-cancel:hover {
            background: #ffcccb;
        }
        
        .alarm-section {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <h1>📋 포스트잇 메모 + ⏰ 알람</h1>

    <div class="section">
        <h2>📌 내 메모</h2>
        <div class="memo-container">
            <!-- 새 메모 추가 버튼 -->
            <div class="new-memo" onclick="createNewMemo()">
                <span class="new-memo-icon">+</span>
            </div>
            
            <?php
            $memo_result = $conn->query("SELECT * FROM memo ORDER BY id DESC");
            if ($memo_result->num_rows > 0) {
                while ($row = $memo_result->fetch_assoc()) {
                    $id = $row['id'];
                    echo '<div class="memo-item" id="memo-'.$id.'">';
                    echo '<input type="checkbox" class="memo-check" onchange="toggleMemoComplete('.$id.')">';
                    echo '<div class="memo-content" id="content-'.$id.'" onclick="editMemo('.$id.')">' . nl2br(htmlspecialchars($row['content'])) . '</div>';
                    echo '<div class="memo-actions">';
                    echo '<button class="memo-delete-btn" onclick="deleteMemo('.$id.')">🗑️</button>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    <div class="alarm-section">
        <h2>⏰ 알람 설정</h2>
        <form method="POST" action="add_alarm.php">
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="datetime-local" id="alarm_time" name="alarm_time" required>
                <input type="text" id="label" name="label" placeholder="알람 이름" style="flex-grow: 1;">
                <button type="submit" style="width: auto;">알람 추가</button>
            </div>
        </form>

        <div id="alarm-list">
        <?php
        $alarm_result = $conn->query("SELECT * FROM alarm ORDER BY alarm_time ASC");
        if ($alarm_result->num_rows > 0) {
            while ($row = $alarm_result->fetch_assoc()) {
                $alarm_id = $row['id'];
                echo '<div class="alarm-item" id="alarm-'.$alarm_id.'" style="display: flex; align-items: center; background: white; padding: 10px; margin-bottom: 5px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">';
                echo '<div style="font-weight: bold; margin-right: 10px;">' . $row['alarm_time'] . '</div>';
                echo '<div style="flex-grow: 1;">' . htmlspecialchars($row['label']) . '</div>';
                
                // 토글 스위치 명확하게 표시
                echo '<div style="margin: 0 10px;">';
                echo '<label class="switch" style="position: relative; display: inline-block; width: 50px; height: 24px; margin: 0 10px;">';
                echo '<input type="checkbox" onchange="toggleAlarm('.$alarm_id.')" checked style="opacity: 0; width: 0; height: 0;">';
                // 슬라이더의 배경과 원을 span으로 분리하여 스타일 적용
                echo '<span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #2196F3; transition: .4s; border-radius: 24px;">'; // ON 상태 배경
                echo '<span style="position: absolute; content: \'\'; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; transform: translateX(26px);"></span>'; // ON 상태 원 위치
                echo '</span>';
                echo '</label>';
                echo '</div>';
                
                // 삭제 버튼
                echo '<button onclick="deleteAlarm('.$alarm_id.')" style="background: none; border: none; cursor: pointer; font-size: 18px;">🗑️</button>';
                echo '</div>';
            }
        } else {
            echo "<p>등록된 알람이 없습니다.</p>";
        }
        ?>
        </div>
    </div>

    <script>
        // 메모 체크박스 토글 기능
        function toggleMemoComplete(id) {
            const memo = document.getElementById('memo-' + id);
            memo.querySelector('.memo-content').classList.toggle('completed');
            event.stopPropagation(); // 이벤트 버블링 방지
        }
        
        // 새 메모 생성
        function createNewMemo() {
            const memoContainer = document.querySelector('.memo-container');
            const newMemoElement = document.createElement('div');
            newMemoElement.className = 'memo-item';
            newMemoElement.id = 'new-memo-temp';
            
            // 임시 ID로 새 메모 생성
            newMemoElement.innerHTML = `
                <textarea class="editable-content" id="new-memo-content" placeholder="메모를 입력하세요..." autofocus></textarea>
                <div class="edit-buttons">
                    <button class="edit-save" onclick="saveNewMemo()">저장</button>
                    <button class="edit-cancel" onclick="cancelNewMemo()">취소</button>
                </div>
            `;
            
            // 새 메모 버튼 다음에 삽입
            const newMemoButton = document.querySelector('.new-memo');
            memoContainer.insertBefore(newMemoElement, newMemoButton.nextSibling);
            
            // 자동 포커스
            document.getElementById('new-memo-content').focus();
        }
        
        // 새 메모 저장
        function saveNewMemo() {
            const content = document.getElementById('new-memo-content').value.trim();
            
            if(content === '') {
                alert('메모 내용을 입력하세요.');
                return;
            }
            
            fetch('add_memo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `content=${encodeURIComponent(content)}&memo_date=${encodeURIComponent(getCurrentDate())}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // 임시 메모 제거
                    document.getElementById('new-memo-temp').remove();
                    
                    // 새로운 메모 추가
                    const memoContainer = document.querySelector('.memo-container');
                    const newMemoButton = document.querySelector('.new-memo');
                    
                    const newMemoElement = document.createElement('div');
                    newMemoElement.className = 'memo-item';
                    newMemoElement.id = 'memo-' + data.id;
                    
                    newMemoElement.innerHTML = `
                        <input type="checkbox" class="memo-check" onchange="toggleMemoComplete(${data.id})">
                        <div class="memo-content" id="content-${data.id}" onclick="editMemo(${data.id})">${nl2br(data.content)}</div>
                        <div class="memo-actions">
                            <button class="memo-delete-btn" onclick="deleteMemo(${data.id})">🗑️</button>
                        </div>
                    `;
                    
                    memoContainer.insertBefore(newMemoElement, newMemoButton.nextSibling);
                } else {
                    alert('메모 저장에 실패했습니다.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // 새 메모 생성 취소
        function cancelNewMemo() {
            document.getElementById('new-memo-temp').remove();
        }
        
        // 현재 날짜 가져오기
        function getCurrentDate() {
            const now = new Date();
            return now.getFullYear() + '-' + 
                   String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                   String(now.getDate()).padStart(2, '0');
        }
        
        // 메모 수정 기능
        function editMemo(id) {
            const contentDiv = document.getElementById('content-' + id);
            const currentContent = contentDiv.innerText;
            
            // 수정 가능한 텍스트 영역으로 변환
            contentDiv.innerHTML = `
                <textarea class="editable-content" id="edit-${id}">${currentContent}</textarea>
                <div class="edit-buttons">
                    <button class="edit-save" onclick="saveMemo(${id})">저장</button>
                    <button class="edit-cancel" onclick="cancelEdit(${id}, '${encodeURIComponent(currentContent)}')">취소</button>
                </div>
            `;
            
            const textarea = document.getElementById('edit-' + id);
            textarea.focus();
            
            // 이벤트 전파 방지
            event.stopPropagation();
        }
        
        // 메모 수정 저장
        function saveMemo(id) {
            const textarea = document.getElementById('edit-' + id);
            const newContent = textarea.value.trim();
            
            if(newContent === '') {
                if(confirm('메모 내용이 비어있습니다. 이 메모를 삭제할까요?')) {
                    deleteMemo(id);
                    return;
                } else {
                    return;
                }
            }
            
            // AJAX로 서버에 수정된 내용 저장
            fetch('update_memo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&content=${encodeURIComponent(newContent)}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // 성공 시 UI 업데이트
                    const contentDiv = document.getElementById('content-' + id);
                    contentDiv.innerHTML = data.content_html;
                } else {
                    alert('메모 수정에 실패했습니다.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // 오류 시 일단 화면에는 반영
                const contentDiv = document.getElementById('content-' + id);
                contentDiv.innerHTML = nl2br(newContent);
            });
            
            // 이벤트 전파 방지
            event.stopPropagation();
        }
        
        // 줄바꿈 처리 함수
        function nl2br(str) {
            return str.replace(/\n/g, '<br>');
        }
        
        // 수정 취소
        function cancelEdit(id, originalContent) {
            const contentDiv = document.getElementById('content-' + id);
            contentDiv.innerHTML = decodeURIComponent(originalContent);
            
            // 이벤트 전파 방지
            event.stopPropagation();
        }
        
        // 메모 삭제 기능
        function deleteMemo(id) {
            if(confirm('이 메모를 삭제하시겠습니까?')) {
                fetch('delete_memo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // 성공 시 UI에서 메모 제거
                        document.getElementById('memo-' + id).remove();
                    } else {
                        alert('메모 삭제에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            
            // 이벤트 전파 방지
            event.stopPropagation();
        }
        
        // 알람 토글 기능
        function toggleAlarm(id) {
            const toggleInput = event.target;
            const slider = toggleInput.nextElementSibling; // The first span (background)
            const sliderCircle = slider.querySelector('span'); // The inner span (circle)
            const isActive = toggleInput.checked;

            if (isActive) {
                slider.style.backgroundColor = '#2196F3'; // ON color
                sliderCircle.style.transform = 'translateX(26px)';
            } else {
                slider.style.backgroundColor = '#ccc'; // OFF color
                sliderCircle.style.transform = 'translateX(0px)';
            }
            
            console.log('알람 #' + id + ' 상태: ' + (isActive ? '활성화' : '비활성화'));
            
            // AJAX로 상태 저장 코드를 추가할 수 있습니다
            // fetch('toggle_alarm.php', { 
            //     method: 'POST', 
            //     headers: {'Content-Type': 'application/json'},
            //     body: JSON.stringify({ id: id, active: isActive }) 
            // });
        }
        
        // 알람 삭제 기능 - 수정
        function deleteAlarm(id) {
            if(confirm('이 알람을 삭제하시겠습니까?')) {
                fetch('delete_alarm.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // 삭제 성공 시 해당 알람 요소 즉시 제거
                        const alarmElement = document.getElementById('alarm-'+id);
                        if(alarmElement) {
                            alarmElement.remove();
                        }
                    } else {
                        alert('알람 삭제에 실패했습니다: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('알람 삭제 중 오류가 발생했습니다.');
                });
            }
        }
    </script>
</body>
</html>