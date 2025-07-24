//Tab
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
document.querySelectorAll('btn-view-detail').forEach(button=> {
    button.addEventListener('click', function(){
        const productId = this.closest('.product-card').dataset.id;

        fetch(`/product/${productId}`)
        .then(res => res.json())
        .then(product => {
            // Update image, product name, price, description
            const productImage = document.querySelector('.product-detail__image img');
            productImage.src = product.ImageUrl;

            document.querySelector('.product-title').textContent = product.ProductName;
            document.querySelector('.product-price__current').textContent = `$${product.Price}`;
            document.querySelector('.product-description').textContent = product.Description;
            document.querySelector('.product-stock__value').textContent = `${product.Stock} in stock`;

            document.querySelector('.product-detail').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
    })
})

// +/-
document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.qty-btn__minus');
    const plusBtn = document.querySelector('.qty-btn__plus');
    const qtyInput = document.querySelector('.qty-input');
    const maxStock = parseInt(qtyInput.dataset.stock);

    // +
    plusBtn.addEventListener('click', ()=> {
        const currentQty = parseInt(qtyInput.value);
        if(currentQty < maxStock) {
            qtyInput.value = currentQty + 1;
        } else {
            alert(`Only ${maxStock} items in stock`);
        }
    });
    // -
    minusBtn.addEventListener('click', ()=> {
        const currentQty = parseInt(qtyInput.value);
        if(currentQty > 1) {
            qtyInput.value = currentQty - 1;
        }
    });

    qtyInput.addEventListener('change', ()=> {
        const value = parseInt(qtyInput.value);
        if(isNaN(value) || (value < 1)) {
            qtyInput.value = 1;
        } else if(value > maxStock) {
            qtyInput.value = maxStock;
            alert(`Cannot exceed stock of ${maxStock}`)
        }

    })
})

// Related product
document.querySelectorAll('.related-item').forEach(item => {
    item.addEventListener('click', function() {
        const productId = this.dataset.id;
        window.location.href = `/product/${productId}`;
    })
})
