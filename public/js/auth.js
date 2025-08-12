// auth.js
function login() {
    fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            localStorage.setItem('auth_token', data.token);
            alert('Đăng nhập thành công');
        } else {
            alert(data.message || 'Đăng nhập thất bại');
        }
    })
    .catch(err => console.error(err));
}
