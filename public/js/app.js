document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebarMenu');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('show');
    });
});