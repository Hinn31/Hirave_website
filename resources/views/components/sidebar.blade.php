<div class="sidebar">
    <a href="#" data-url="/admin/dashboard">DashBoard</a>
    <a href="#" class="active" data-url="/admin/products-management">Product Management</a>
    <a href="#" data-url="/admin/users">User Management</a>
    <a href="#" data-url="/admin/orders">Order Management</a>
</div>

<script>
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('data-url');
        if (url) {
            window.location.href = url; 
        }
        });
    });
</script>
