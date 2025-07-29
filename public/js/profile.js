document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('updateProfileForm');
    if(!form) {
        console.error('Form not found');
        return;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const userId = this.getAttribute('data-user-id');
        const data = {
            avatar: document.getElementById('avatar')?.value?? '',
            username: document.getElementById('username').value,
            fullname: document.getElementById('fullname').value,
            email: document.getElementById('email').value,

        }

        try {
            const response = await fetch(`/api/users/${userId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body:   JSON.stringify(data)
            });
            const result = await response.json();

            if(response.ok) {
                document.getElementById('displayName').innerHTML = `${result.user.fullname} <span>(${result.user.username})</span>`;
                alert('Cập nhật thành công!');
            } else {
                console.error(result.errors);
                alert('Lỗi: ' + JSON.stringify(result.errors));
            }
        } catch (error) {
                console.error('Error:', error);
            }
    })
});
