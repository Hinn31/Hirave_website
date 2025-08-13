document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateProfileForm');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const usernameEl = document.getElementById('username');
    const fullnameEl = document.getElementById('fullname');
    const emailEl = document.getElementById('email');
    const displayNameEl = document.getElementById('displayName');
    const btnLogout = document.getElementById('btnLogout');

    // Preview avatar khi chọn ảnh mới
    avatarInput.addEventListener('change', () => {
        if (avatarInput.files.length === 0) return;
        avatarPreview.src = URL.createObjectURL(avatarInput.files[0]);
        avatarInput.value = ''; // reset để có thể chọn lại file cũ
    });

    // Submit cập nhật profile
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userId = form.dataset.userId;
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
                const { user, avatar_url } = result;

                usernameEl.value = user.username;
                fullnameEl.value = user.fullname;
                emailEl.value = user.email;
                displayNameEl.innerHTML = `${user.fullname} <span>(${user.username})</span>`;

                if (avatar_url) {
                    avatarPreview.src = avatar_url;
                }

                alert('Cập nhật thành công!');
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
