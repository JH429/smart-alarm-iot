function createNewMemo() {
    const memoContainer = document.querySelector('.memo-container');
    const newMemoElement = document.createElement('div');
    newMemoElement.className = 'memo-item';
    newMemoElement.id = 'new-memo-temp';

    newMemoElement.innerHTML = `
        <input type="checkbox" class="memo-check" disabled>
        <div class="memo-content" id="new-memo-content" contenteditable="true" placeholder="메모를 입력하세요..."></div>
        <div class="memo-actions">
            <button class="memo-delete-btn" onclick="cancelNewMemo()">❌</button>
        </div>
    `;

    const newMemoButton = document.querySelector('.new-memo');
    memoContainer.insertBefore(newMemoElement, newMemoButton.nextSibling);

    const editableDiv = document.getElementById('new-memo-content');
    editableDiv.focus();

    // 자동 저장 onblur
    editableDiv.addEventListener('blur', () => {
        const content = editableDiv.innerText.trim();
        if (content === '') {
            cancelNewMemo();
            return;
        }

        ajaxRequest('memo/add.php', 'POST', `content=${encodeURIComponent(content)}`, (data) => {
            if (data.success) {
                newMemoElement.remove();

                const finalMemo = document.createElement('div');
                finalMemo.className = 'memo-item';
                finalMemo.id = 'memo-' + data.id;

                finalMemo.innerHTML = `
                    <input type="checkbox" class="memo-check" onchange="toggleMemoComplete(${data.id})">
                    <div class="memo-content" id="content-${data.id}" contenteditable="true" onblur="saveMemoInline(${data.id})">${nl2br(data.content)}</div>
                    <div class="memo-actions">
                        <button class="memo-delete-btn" onclick="deleteMemo(${data.id})">🗑️</button>
                    </div>
                `;

                memoContainer.insertBefore(finalMemo, newMemoButton.nextSibling);
            } else {
                alert('메모 저장 실패');
            }
        });
    });
}

function cancelNewMemo() {
    const temp = document.getElementById('new-memo-temp');
    if (temp) temp.remove();
}
function deleteMemo(id) {
    if (confirm('이 메모를 삭제하시겠습니까?')) {
        ajaxRequest('memo/delete.php', 'POST', `id=${id}`, (data) => {
            if (data.success) {
                document.getElementById('memo-' + id).remove();
            } else {
                alert('메모 삭제에 실패했습니다.');
            }
        });
    }
}

