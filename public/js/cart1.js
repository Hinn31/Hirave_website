document.addEventListener('DOMContentLoaded', () => {
  const cartItemsContainer = document.getElementById('cart-items');
  const totalPaymentEl = document.getElementById('total-payment');

  if (!window.token) {
    alert('Bạn chưa đăng nhập, vui lòng đăng nhập để xem giỏ hàng');
    window.location.href = '/login';
    return;
  }

  let cartData = [];

  function renderCart() {
    if (cartData.length === 0) {
      cartItemsContainer.innerHTML = '<tr><td colspan="7">Giỏ hàng trống.</td></tr>';
      totalPaymentEl.textContent = '0';
      return;
    }

    let totalPayment = 0;
    const rowsHtml = cartData.map(item => {
      const itemTotal = item.price * item.quantity;
      totalPayment += itemTotal;

      return `
        <tr data-product-id="${item.id}">
          <td><input type="checkbox" class="select-item"></td>
          <td><img src="/images/products/${item.imageURL}" alt="${item.name}" class="cart-image"></td>
          <td>${item.name}</td>
          <td>${item.price.toLocaleString()} VND</td>
          <td>
            <div class="quantity-control">
              <button class="qty-minus">−</button>
              <input type="number" min="1" value="${item.quantity}" class="qty-input" />
              <button class="qty-plus">+</button>
            </div>
          </td>
          <td>${itemTotal.toLocaleString()} VND</td>
          <td><span class="btn-delete" title="Xóa sản phẩm">&times;</span></td>
        </tr>
      `;
    }).join('');

    cartItemsContainer.innerHTML = rowsHtml;
    totalPaymentEl.textContent = totalPayment.toLocaleString();
  }

  function fetchCart() {
    fetch(window.apiCartUrl, {
      headers: {
        'Authorization': `Bearer ${window.token}`,
        'Accept': 'application/json'
      }
    })
    .then(res => {
      if (!res.ok) throw new Error('Lỗi khi lấy giỏ hàng');
      return res.json();
    })
    .then(data => {
      cartData = data.cart || [];
      renderCart();
    })
    .catch(err => {
      console.error(err);
      cartItemsContainer.innerHTML = '<tr><td colspan="7">Không thể tải giỏ hàng, vui lòng thử lại.</td></tr>';
    });
  }

  fetchCart();
});
