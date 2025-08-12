
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

//Product-detail
document.querySelectorAll('.btn-view-detail').forEach(button=> {
    button.addEventListener('click', function(){
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

    // Related products - click to go to detail page
    document.querySelectorAll('.product-card-mini').forEach(item => {
        item.addEventListener('click', function () {
            const productId = this.dataset.id;
            window.location.href = `/product/${productId}`;
        });
    });


    // Comment submission
    const reviewForm = document.getElementById('reviewForm');
    const reviewList = document.querySelector('.review-list');
    const reviewMessage = document.getElementById('reviewMessage');

    if (reviewForm) {
        reviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const token = localStorage.getItem('auth_token');
            const productId = document.getElementById('product_id').value;
            const comment = document.getElementById('comment').value;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            if (!token) {
                reviewMessage.textContent = 'Please log in to comment.';
                reviewMessage.style.color = 'red';
                return;
            }

            try {
                const res = await fetch('/api/reviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ product_id: productId, comment, name, email })
                });

                const data = await res.json();

                if (res.ok) {
                    reviewMessage.textContent = 'Comment added successfully!';
                    reviewMessage.style.color = 'green';
                    reviewForm.reset(); // Clear all form fields

                    // Add new comment to review list dynamically
                    const newReview = document.createElement('div');
                    newReview.classList.add('review-item');
                    newReview.innerHTML = `
                        <p><strong>${name || 'Anonymous'}</strong>: ${comment}</p>
                        <small>Just now</small>
                    `;
                    reviewList.prepend(newReview);
                } else {
                    reviewMessage.textContent = data.message || 'Failed to add comment.';
                    reviewMessage.style.color = 'red';
                }
            } catch (error) {
                reviewMessage.textContent = 'An error occurred. Please try again.';
                reviewMessage.style.color = 'red';
                console.error('Error:', error);
            }
        });
    }
});



