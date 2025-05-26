function ajaxRequest(url, method, data, callback) {
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(callback)
    .catch(error => {
        console.error('AJAX Error:', error);
        alert('서버 요청 중 오류가 발생했습니다.');
    });
}

function nl2br(str) {
    return str.replace(/\n/g, '<br>');
}
