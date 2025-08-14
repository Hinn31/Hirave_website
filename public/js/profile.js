document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateProfileForm');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const usernameEl = document.getElementById('username');
    const fullnameEl = document.getElementById('fullname');
    const emailEl = document.getElementById('email');
    const displayNameEl = document.getElementById('displayName');

    const userId = form.dataset.userId;

    avatarInput.addEventListener('change', async () => {
        if (avatarInput.files.length > 0) {
            const file = avatarInput.files[0];
            avatarPreview.src = URL.createObjectURL(file); 
            const formData = new FormData();
            formData.append('avatar', file);

            try {
                const response = await fetch(`/users/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.avatar_url) {
                    avatarPreview.src = result.avatar_url + '?t=' + new Date().getTime();
                } else {
                    const errorMsg = result.errors ?? result.message ?? 'Unknown error';
                    alert('Lỗi khi cập nhật avatar: ' + JSON.stringify(errorMsg));
                }
            } catch (err) {
                alert('Có lỗi xảy ra khi upload avatar!');
                console.error(err);
            }
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch(`/users/${userId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                const { user } = result;
                usernameEl.value = user.username;
                fullnameEl.value = user.fullname;
                emailEl.value = user.email;
                displayNameEl.innerHTML = `${user.fullname} <span>(${user.username})</span>`;
                alert('Cập nhật thông tin thành công!');
            } else {
                const errorMsg = result.errors ?? result.message ?? 'Unknown error';
                alert('Lỗi: ' + JSON.stringify(errorMsg));
            }
        } catch (err) {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
            console.error(err);
        }
    });

    // Logout API
    async function logoutApi() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Bạn chưa đăng nhập hoặc token không tồn tại');
            return;
        }

        try {
            const response = await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();
            if (response.ok) {
                localStorage.removeItem('token');
                alert(data.message);
                window.location.href = '/login';
            } else {
                alert('Logout thất bại: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            alert('Có lỗi xảy ra khi logout!');
            console.error(error);
        }
    }

    // Gán sự kiện logout cho nút
    btnLogout.addEventListener('click', logoutApi);
});
