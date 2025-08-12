document.addEventListener('DOMContentLoaded', () => {
  const addToCartBtn = document.querySelector('.btn-add-to-card');
  const qtyInput = document.querySelector('.qty-input');
  const productDetail = document.querySelector('.product-detail');
  const addToCartUrl = 'http://127.0.0.1:8000/api/cart/add';

  if (!addToCartBtn) return; // tránh lỗi nếu không tìm thấy nút

  addToCartBtn.addEventListener('click', () => {
    const token = localStorage.getItem('token');
    if (!token) {
      alert('Bạn chưa đăng nhập, vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
      window.location.href = '/login.html';
      return;
    }

    const productId = productDetail?.dataset?.productId;
    const quantity = parseInt(qtyInput?.value) || 1;

    if (!productId) {
      alert('Không xác định được sản phẩm.');
      return;
    }
    if (quantity < 1) {
      alert('Số lượng không hợp lệ.');
      return;
    }

    fetch(addToCartUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        product_id: productId,
        quantity: quantity,
      }),
    })
    .then(async (response) => {
      const text = await response.text();
      try {
        return JSON.parse(text);
      } catch (e) {
        console.error('Phản hồi không phải JSON:', text);
        throw e;
      }
    })
    .then((data) => {
      if (data.message) {
        alert(data.message);
        // TODO: cập nhật UI số lượng giỏ hàng nếu có
      } else if (data.error) {
        alert('Error: ' + data.error);
      }
    })
    .catch((error) => {
      console.error(error);
      alert('Đã có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
    });
  });
});
