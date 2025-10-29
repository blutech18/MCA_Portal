// Global function to toggle submenu for instructor pages
function toggleSubmenu(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const target = event.target.closest('.has-submenu');
    if (!target) return;
    
    const submenu = target.querySelector('.sub-menu');
    if (!submenu) return;
    
    // Toggle display
    if (submenu.style.display === 'block' || submenu.style.display === '') {
        submenu.style.display = 'none';
        target.classList.remove('active');
    } else {
        submenu.style.display = 'block';
        target.classList.add('active');
    }
}

// Auto-expand submenu if a sub-item is active
document.addEventListener('DOMContentLoaded', function() {
    const activeSubItem = document.querySelector('.sub-item.active');
    if (activeSubItem) {
        const parentLi = activeSubItem.closest('.has-submenu');
        if (parentLi) {
            parentLi.classList.add('active');
            const submenu = parentLi.querySelector('.sub-menu');
            if (submenu) {
                submenu.style.display = 'block';
            }
        }
    }
});
