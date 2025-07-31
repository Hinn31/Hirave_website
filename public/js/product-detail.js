
const tabs = document.querySelectorAll(".tab");
const panes = document.querySelectorAll(".tab-pane");

tabs.forEach((tab, index) => {
    tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        panes.forEach(p => p.classList.remove("active"));
        tab.classList.add("active");
        panes[index].classList.add("active");
    });
});

document.querySelectorAll('.btn-view-detail').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.closest('.product-card').dataset.id;

        fetch(`/product/${productId}`)
            .then(res => res.json())
            .then(product => {
                document.querySelector('.product-detail__image img').src = product.ImageUrl;
                document.querySelector('.product-title').textContent = product.ProductName;
                document.querySelector('.product-price__current').textContent = `$${product.Price}`;
                document.querySelector('.product-description').textContent = product.Description;
                document.querySelector('.product-stock__value').textContent = `${product.Stock} in stock`;

                document.querySelector('.product-detail').style.display = 'block';
            })
            .catch(error => console.error('Error:', error));
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const minusBtn = document.querySelector('.qty-btn__minus');
    const plusBtn = document.querySelector('.qty-btn__plus');
    const qtyInput = document.querySelector('.qty-input');
    const maxStock = parseInt(qtyInput.dataset.stock);
    const totalPriceEl = document.getElementById('totalPrice');

    // Lấy giá 1 sản phẩm từ giao diện
    const unitPrice = parseFloat(document.querySelector('.product-price__current').textContent.replace('$', ''));

    function updateTotalPrice() {
        const qty = parseInt(qtyInput.value) || 1;
        const total = (unitPrice * qty).toFixed(2);
        totalPriceEl.textContent = `$${total}`;
    }

    plusBtn.addEventListener('click', () => {
        const currentQty = parseInt(qtyInput.value);
        if (currentQty < maxStock) {
            qtyInput.value = currentQty + 1;
            updateTotalPrice();
        } else {
            alert(`Only ${maxStock} items in stock`);
        }
    });

    minusBtn.addEventListener('click', () => {
        const currentQty = parseInt(qtyInput.value);
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
            updateTotalPrice();
        }
    });

    qtyInput.addEventListener('change', () => {
        let value = parseInt(qtyInput.value);
        if (isNaN(value) || value < 1) {
            qtyInput.value = 1;
        } else if (value > maxStock) {
            qtyInput.value = maxStock;
            alert(`Cannot exceed stock of ${maxStock}`);
        }
        updateTotalPrice();
    });

    // Gọi ngay khi load
    updateTotalPrice();
});

// Related products - click to go to detail page
document.querySelectorAll('.related-item').forEach(item => {
    item.addEventListener('click', function () {
        const productId = this.dataset.id;
        window.location.href = `/product/${productId}`;
    });
});
