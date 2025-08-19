document.addEventListener('DOMContentLoaded', () => {
    const keywordInput = document.getElementById('keyword');

    keywordInput.addEventListener('input', () => {
        if (keywordInput.value.trim() === '') {
            searchProduct();
            searchUser();
        }
    });
});

function searchProduct() {
    let keyword = document.getElementById('keyword').value.trim();
    let url = '/product-management/search';
    if (keyword !== '') {
        url += `?keyword=${encodeURIComponent(keyword)}`;
    }

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(products => {
        let tbody = document.getElementById('products-tbody');
        tbody.innerHTML = "";

        if (products.length === 0) {
            tbody.innerHTML = "<tr><td colspan='9'>Not found product!</td></tr>";
            return;
        }

        products.forEach(p => {
            tbody.innerHTML += `
            <tr>
                <td>${p.id}</td>
                <td>${p.productName}</td>
                <td>${new Date(p.created_at).toISOString().split('T')[0]}</td>
                <td>${p.categoryID}</td>
                <td>${p.stock}</td>
                <td>${p.price}</td>
                <td>${p.oldPrice ?? '-'}</td>
                <td>${p.imageURL ? `<img src="/${p.imageURL}" width="40" height="40">` : '-'}</td>
                <td class="actions">
                    <a href="/product-management/${p.id}/edit"><button class="edit">Edit</button></a>
                    <form action="/product-management/${p.id}" method="POST" style="display:inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>`;
        });
    });
}

function searchUser() {
    let keyword = document.getElementById('keyword').value.trim();
    let url = '/users/search';
    if (keyword !== '') {
        url += `?keyword=${encodeURIComponent(keyword)}`;
    }

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(users => {
        let tbody = document.getElementById('users-tbody');
        tbody.innerHTML = "";

        if (users.length === 0) {
            tbody.innerHTML = "<tr><td colspan='8'>Not found user</td></tr>";
            return;
        }

        users.forEach(user => {
            tbody.innerHTML += `
            <tr>
                <td>${user.id}</td>
                <td>${user.fullname}</td>
                <td>${user.username}</td>
                <td>${user.date_of_birth}</td>
                <td>${user.email}</td>
                <td>${user.phone}</td>
                <td class="actions">
                    <a href="/users/${user.id}/edit"><button class="edit">Edit</button></a>
                    <form action="/users/${user.id}" method="POST" style="display:inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>`;
        });
    });
}
