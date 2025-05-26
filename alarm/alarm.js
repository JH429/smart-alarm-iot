function deleteAlarm(id) {
    if (confirm('이 알람을 삭제하시겠습니까?')) {
        ajaxRequest('alarm/delete.php', 'POST', `id=${id}`, (data) => {
            if (data.success) {
                document.getElementById('alarm-' + id).remove();
            } else {
                alert('알람 삭제에 실패했습니다.');
            }
        });
    }
}

function toggleAlarm(id) {
    const toggleInput = event.target;
    const slider = toggleInput.nextElementSibling;
    const sliderCircle = slider.querySelector('span');
    const isActive = toggleInput.checked;

    slider.style.backgroundColor = isActive ? '#2196F3' : '#ccc';
    sliderCircle.style.transform = isActive ? 'translateX(26px)' : 'translateX(0px)';

    console.log('알람 #' + id + ' 상태: ' + (isActive ? '활성화' : '비활성화'));
}
