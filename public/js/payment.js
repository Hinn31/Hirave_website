    // public/js/payment.js

    function getToken() {
        return localStorage.getItem('token');
    }

    function formatCurrency(number) {
        if (number == null) return '0';
        try {
            return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(number);
        } catch (e) {
            return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }

    function disableSubmit(disabled) {
        const btn = document.getElementById('btn-submit');
        if (!btn) return;
        btn.disabled = disabled;
        btn.textContent = disabled ? 'Processing...' : 'Payment';
    }

    function renderOrderSummary(cart) {
        const wrap = document.getElementById('order-summary');
        if (!wrap) return;
        wrap.innerHTML = '';

        const title = document.createElement('h3');
        title.className = 'order__summary-title';
        title.textContent = 'YOUR ORDER';
        wrap.appendChild(title);

        // Lấy danh sách sản phẩm đã chọn
        let selectedItems = [];
        try {
            selectedItems = JSON.parse(localStorage.getItem('selectedCartItems')) || [];
        } catch (e) {
            selectedItems = [];
        }

        // Nếu có chọn thì lọc, nếu không thì lấy tất cả
        let items = cart?.items || [];
        if (cart.items && selectedItems.length > 0) {
            cart.items = cart.items.filter(item => selectedItems.includes(String(item.product.id)));
        }

        const scroll = document.createElement('div');
        scroll.className = 'order__summary-scroll solid-line';
        scroll.style.maxHeight = '300px';
        scroll.style.overflowY = 'auto';

        const table = document.createElement('table');
        table.className = 'order__summary-table';
        const tbody = document.createElement('tbody');

        let total = 0;
        if (items.length) {
            items.forEach(item => {
                const price = item?.product?.price ?? 0;
                const quantity = item?.quantity ?? 0;
                const sum = price * quantity;
                total += sum;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="order__summary-item">
                        <img src="${item?.product?.imageURL ?? ''}" alt="product image" class="order__summary-image">
                        <div class="order__summary-detail">
                            <p class="order__summary-name">${item?.product?.productName ?? 'N/A'}</p>
                            <p class="order__summary-price">${price.toLocaleString('vi-VN', { minimumFractionDigits: 3, maximumFractionDigits: 3 })} VND</p>
                        </div>
                    </td>
                    <td class="order__summary-quantity">${quantity}</td>
                    <td class="order__summary-sum">${sum.toLocaleString('vi-VN', { minimumFractionDigits: 3, maximumFractionDigits: 3 })} VND</td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td colspan="3" class="text-center">Giỏ hàng trống</td>`;
            tbody.appendChild(tr);
            disableSubmit(true);
        }

        table.appendChild(tbody);
        scroll.appendChild(table);
        wrap.appendChild(scroll);

        const sumLine = document.createElement('div');
        sumLine.className = 'order__summary-total-line';
        sumLine.innerHTML = `<strong>Sum:</strong><span>${total.toLocaleString('vi-VN', { minimumFractionDigits: 3, maximumFractionDigits: 3 })}VND</span>`;
        wrap.appendChild(sumLine);

        const totalLine = document.createElement('div');
        totalLine.className = 'order__summary-total-line solid-line';
        totalLine.innerHTML = `<strong>Total:</strong><span>${total.toLocaleString('vi-VN', { minimumFractionDigits: 3, maximumFractionDigits: 3 })}VND</span>`;
        wrap.appendChild(totalLine);
    }


    function loadPaymentPage() {
        const token = getToken();
        if (!token) {
            alert('Vui lòng đăng nhập!');
            window.location.href = '/login';
            return;
        }

        fetch('/api/payment-data', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            if (!res.ok) {
                if (res.status === 401) throw new Error('Unauthorized');
                const t = await res.text();
                throw new Error(t || 'Server error');
            }
            return res.json();
        })
        .then(data => {
            console.log("Dữ liệu API trả về:", data);
            // Fill form user info
            const user = data.user || {};
            document.getElementById('name').value    = user.fullname || '';
            document.getElementById('phone').value   = user.phone || '';
            document.getElementById('city').value    = user.city || '';
            document.getElementById('address').value = user.address || '';

            // Lấy selectedCartItems từ localStorage
            let selectedItems = [];
            try {
                selectedItems = JSON.parse(localStorage.getItem('selectedCartItems')) || [];
            } catch (e) {
                selectedItems = [];
            }

            // Lọc giỏ hàng theo selectedItems
            let cart = data.cart || {};
            if (cart.items && selectedItems.length > 0) {
                cart.items = cart.items.filter(item => selectedItems.includes(String(item.product.id)));
            }

            renderOrderSummary(cart);
            disableSubmit(false);
        })
        .catch(err => {
            console.error(err);
            alert('Không tải được trang thanh toán. Hãy đăng nhập lại!');
            window.location.href = '/login';
        });
    }

    function submitPayment() {
        const token = getToken();
        if (!token) {
            alert('Vui lòng đăng nhập!');
            window.location.href = '/login';
            return;
        }

        let selectedItems = [];
        try {
            selectedItems = JSON.parse(localStorage.getItem('selectedCartItems')) || [];
        } catch (e) {
            selectedItems = [];
        }

        const payload = {
            name: document.getElementById('name').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            city: document.getElementById('city').value.trim(),
            address: document.getElementById('address').value.trim(),
            payment_method: document.querySelector('input[name="payment_method"]:checked').value,
            selected_items: selectedItems
        };

        disableSubmit(true);

        fetch('/api/payment', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const json = await res.json().catch(() => ({}));
            if (!res.ok) {
                const msg = json?.message || json?.error || 'Thanh toán thất bại';
                throw new Error(msg);
            }
            return json;
        })
        .then(data => {
            console.log("Server trả về:", data);
            switch (data.payment_method) {
                case 'cash':
                    alert("Đặt hàng thành công (COD). Tổng: " + data.total.toLocaleString('vi-VN', { minimumFractionDigits: 3, maximumFractionDigits: 3 }) + " VND");
                    window.location.href = "/cart";
                    break;

                case 'momo':
                    if (data.payUrl) {
                        window.location.href = data.payUrl;
                    } else {
                        alert("Không nhận được payUrl từ MoMo");
                    }
                    break;

                case 'vnpay':
                    if (data.payment_url) {
                        window.location.href = data.payment_url;
                    } else {
                        alert("Không nhận được URL từ VNPay");
                    }
                    break;

                default:
                    alert("Phương thức thanh toán không hợp lệ!");
            }
        })
        .catch(err => {
            console.error(err);
            alert('Lỗi: ' + err.message);
        })
        .finally(() => {
            disableSubmit(false);
        });
    }
