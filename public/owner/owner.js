/**
 * FurShield — Portal Sidebar Drawer & Mobile Responsive Interactions
 * Supports Owner, Vet, and Shelter role dashboards
 */
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('ownerMenuToggle');
    const closeBtn = document.getElementById('ownerSidebarClose');
    const overlay = document.getElementById('ownerMobileOverlay');

    function openSidebar(e) {
        if (e) e.preventDefault();
        if (sidebar) sidebar.classList.add('open');
        if (overlay) overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar(e) {
        if (e) e.preventDefault();
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', openSidebar);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Auto-close sidebar on mobile when a nav item is clicked
    if (sidebar) {
        const navLinks = sidebar.querySelectorAll('.owner-nav-item, a');
        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 1024) {
                    closeSidebar();
                }
            });
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });
});
