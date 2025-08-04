document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateProfileForm');
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const usernameEl = document.getElementById('username');
    const fullnameEl = document.getElementById('fullname');
    const emailEl = document.getElementById('email');
    const displayNameEl = document.getElementById('displayName');

    // Bấm icon ✎ để mở file input
    document.querySelector('.edit-icon')?.addEventListener('click', () => {
        avatarInput.value = '';
        avatarInput.click();
    });
    // Hiển thị ảnh vừa chọn
    avatarInput?.addEventListener('change', () => {
        const file = avatarInput.files[0];
        if (file) {
            avatarPreview.src = URL.createObjectURL(file);
        }
    });

    // Gửi form
    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userId = form.dataset.userId;
        const formData = new FormData();

        formData.append('username', usernameEl.value.trim());
        formData.append('fullname', fullnameEl.value.trim());
        formData.append('email', emailEl.value.trim());

        if (avatarInput.files[0]) {
            formData.append('avatar', avatarInput.files[0]);
        }

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
            console.log('Response:', response);
            console.log('Result:', result);

            if (response.ok) {
                const { user, avatar_url } = result;
                usernameEl.value = user.username;
                fullnameEl.value = user.fullname;
                emailEl.value = user.email;
                displayNameEl.innerHTML = `${user.fullname} <span>(${user.username})</span>`;
                if (avatar_url) avatarPreview.src = avatar_url;

                alert('Update successfully!');
            } else {
                const errorMsg = result.errors ?? result.message ?? 'Unknown error';
                console.error(errorMsg);
                alert('Error: ' + JSON.stringify(errorMsg));
            }
        } catch (err) {
            console.error('Error:', err);
            alert('Something went wrong!');
        }
    });
});
