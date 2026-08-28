// Custom JavaScript asset for QuickTask Dashboard UI
console.log('Custom QuickTask JavaScript asset loaded successfully!');

document.addEventListener('DOMContentLoaded', () => {
    // Custom sidebar toggle animation logic
    const toggleButtons = document.querySelectorAll('.toggle-sidebar');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-collapsed');
            console.log('Sidebar toggled!');
        });
    });
});
