const BASE_URL = 'index.php?area=client&controller=cart';

function addToCart(productId) {
    const formData = new FormData();
    formData.append('productId', productId);

    fetch(BASE_URL + '&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hiển thị toast
            showToast(data.message, 'success');
            // Cập nhật số lượng trên Header
            const cartCountEl = document.querySelector("#cartCount");
            if (cartCountEl) {
                cartCountEl.textContent = data.cartCount;
                cartCountEl.style.display = 'inline-block';
            }
        } else {
            showToast(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        showToast("Có lỗi xảy ra!", 'danger');
    });
}

function updateCart(productId, quantity) {
    if (quantity < 0) return;

    const formData = new FormData();
    formData.append('productId', productId);
    formData.append('quantity', quantity);

    fetch(BASE_URL + '&action=update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (quantity === 0) {
                // Xóa dòng sản phẩm nếu quantity = 0
                const itemRow = document.querySelector(`#cart-item-${productId}`);
                if (itemRow) itemRow.remove();
            } else {
                // Cập nhật input số lượng và thành tiền của item
                const qtyInput = document.querySelector(`#qty-${productId}`);
                if (qtyInput) qtyInput.value = data.quantity;

                const itemTotalEl = document.querySelector(`#item-total-${productId}`);
                if (itemTotalEl) itemTotalEl.textContent = data.itemTotal + '₫';
            }

            // Cập nhật tổng tiền
            const subtotalEl = document.querySelector("#cart-subtotal");
            const totalEl = document.querySelector("#cart-total");
            if (subtotalEl) subtotalEl.textContent = data.cartTotal + '₫';
            if (totalEl) totalEl.textContent = data.cartTotal + '₫';

            // Cập nhật header cart count
            const cartCountEl = document.querySelector("#cartCount");
            if (cartCountEl) {
                cartCountEl.textContent = data.cartCount;
                if (data.cartCount == 0) {
                    cartCountEl.style.display = 'none';
                    location.reload(); // Reload trang nếu giỏ trống
                }
            }
        }
    })
    .catch(error => console.error("Lỗi:", error));
}

function removeCart(productId) {
    if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;

    const formData = new FormData();
    formData.append('productId', productId);

    fetch(BASE_URL + '&action=remove', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Xóa dòng
            const itemRow = document.querySelector(`#cart-item-${productId}`);
            if (itemRow) itemRow.remove();

            // Cập nhật tổng tiền
            const subtotalEl = document.querySelector("#cart-subtotal");
            const totalEl = document.querySelector("#cart-total");
            if (subtotalEl) subtotalEl.textContent = data.cartTotal + '₫';
            if (totalEl) totalEl.textContent = data.cartTotal + '₫';

            // Cập nhật header cart count
            const cartCountEl = document.querySelector("#cartCount");
            if (cartCountEl) {
                cartCountEl.textContent = data.cartCount;
                if (data.cartCount == 0) {
                    cartCountEl.style.display = 'none';
                    location.reload();
                }
            }
            showToast(data.message, 'success');
        }
    })
    .catch(error => console.error("Lỗi:", error));
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;

    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    const iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';

    const toastHTML = `
        <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${iconClass} me-2"></i> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastEl = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();

    toastEl.addEventListener('hidden.bs.toast', () => {
        toastEl.remove();
    });
}
