document.addEventListener('DOMContentLoaded', () => {
    const keywordInput = document.getElementById('keyword');

    keywordInput.addEventListener('input', () => {
        if (keywordInput.value.trim() === '') {
            searchProduct();
        }
    });
});
function searchProduct() {
    let keyword = document.getElementById('keyword').value.trim();

    // Nếu keyword rỗng, fetch tất cả sản phẩm
    let url = '/admin/products-management/search';
    if (keyword !== '') {
        url += `?keyword=${encodeURIComponent(keyword)}`;
    }

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(products => {
      let tbody = document.querySelector('tbody');
      tbody.innerHTML = "";

      if (products.length === 0) {
        tbody.innerHTML = "<tr><td colspan='9'>Không tìm thấy sản phẩm</td></tr>";
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
              <a href="/admin/products-management/${p.id}/edit"><button class="edit">Edit</button></a>
              <form action="/admin/products-management/${p.id}" method="POST" style="display:inline">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
                <button class="delete" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
        `;
      });
    });
}
