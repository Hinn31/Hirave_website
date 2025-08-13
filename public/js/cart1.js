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

    // Gắn sự kiện cho các nút +, -, xóa và input mới tạo
    addEventListeners();
  }

  // Gọi API lấy giỏ hàng
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

  // Xóa sản phẩm theo product_id
  function removeItem(productId) {
    fetch(window.apiRemoveUrl, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${window.token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ product_id: productId }) // sửa thành product_id
    })
    .then(async res => {
      if (!res.ok) {
        const errorText = await res.text();
        throw new Error(`Lỗi khi xóa sản phẩm: ${errorText}`);
      }
      return res.json();
    })
    .then(() => {
      fetchCart();
    })
    .catch(err => {
      alert(err.message);
      console.error(err);
    });
  }

  // Cập nhật số lượng sản phẩm
  function updateQuantity(productId, quantity) {
    if (quantity < 1) quantity = 1; // không cho số lượng nhỏ hơn 1
    fetch(window.apiUpdateUrl, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${window.token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ 
        product_id: productId,  // đổi thành product_id
        quantity: quantity 
      })
    })
    .then(async res => {
      if (!res.ok) {
        const errorText = await res.text();
        throw new Error(`Lỗi khi cập nhật số lượng: ${errorText}`);
      }
      return res.json();
    })
    .then(() => {
      fetchCart();
    })
    .catch(err => {
      alert(err.message);
      console.error(err);
    });
  }

  // Gắn sự kiện cho các nút +, -, xóa và input số lượng
  function addEventListeners() {
    // Xóa sản phẩm
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', e => {
        const tr = e.target.closest('tr');
        const productId = tr.dataset.productId;
        if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')) {
          removeItem(productId);
        }
      });
    });

    // Nút giảm số lượng
    document.querySelectorAll('.qty-minus').forEach(btn => {
      btn.addEventListener('click', e => {
        const tr = e.target.closest('tr');
        const productId = tr.dataset.productId;
        const input = tr.querySelector('.qty-input');
        let currentQty = parseInt(input.value);
        if (currentQty > 1) {
          updateQuantity(productId, currentQty - 1);
        }
      });
    });

    // Nút tăng số lượng
    document.querySelectorAll('.qty-plus').forEach(btn => {
      btn.addEventListener('click', e => {
        const tr = e.target.closest('tr');
        const productId = tr.dataset.productId;
        const input = tr.querySelector('.qty-input');
        let currentQty = parseInt(input.value);
        updateQuantity(productId, currentQty + 1);
      });
    });

    // Thay đổi số lượng trực tiếp nhập input
    document.querySelectorAll('.qty-input').forEach(input => {
      input.addEventListener('change', e => {
        const tr = e.target.closest('tr');
        const productId = tr.dataset.productId;
        let newQty = parseInt(e.target.value);
        if (isNaN(newQty) || newQty < 1) {
          newQty = 1;
          e.target.value = 1;
        }
        updateQuantity(productId, newQty);
      });
    });
  }

  // Bắt đầu load giỏ hàng
  fetchCart();
});
