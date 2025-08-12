document.addEventListener('DOMContentLoaded', function () {

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

    //
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

    if (!reviewForm) return;

    reviewForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const token = localStorage.getItem('token');
        const productId = document.getElementById('product_id')?.value;
        const comment = document.getElementById('comment')?.value;
        const name = document.getElementById('name')?.value;
        const email = document.getElementById('email')?.value;

        if (!token) {
            alert('You are not logged in. Please log in to add a comment.');
            window.location.href = '/login'; 
            return;
        }

        if (!productId || !comment) {
            alert('Please enter both the product ID and your comment.');
            return;
        }

        try {
            const res = await fetch(`${window.location.origin}/api/reviews`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rating: 5,productID: productId, comment, name, email }),
            });

            const text = await res.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Response is not valid JSON::', text);
                throw new Error('Invalid response format');
            }

            if (res.ok) {
                reviewMessage.textContent = data.message || 'Comment added successfully!';
                reviewMessage.style.color = 'green';
                reviewForm.reset(); // Clear all form fields

                 // Chèn HTML từ backend trả về
                reviewList.insertAdjacentHTML('afterbegin', data.html);

            } else if (data.error) {
                reviewMessage.textContent = 'Error: ' + data.error;
                reviewMessage.style.color = 'red';
            } else {
                reviewMessage.textContent = 'Failed to add comment.';
                reviewMessage.style.color = 'red';
            }
        } catch (error) {
            reviewMessage.textContent = 'An error occurred while adding the comment.';
            reviewMessage.style.color = 'red';
            console.error(error);
        }
    });
});



