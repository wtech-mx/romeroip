(function () {
    'use strict';
    const sidebar = document.getElementById('sidenav-main');
    if (!sidebar) return;
    const desktop = window.matchMedia('(min-width: 1200px)');
    let collapsed = false;
    try { collapsed = localStorage.getItem('romero-sidebar-collapsed') === 'true'; } catch (_) {}
    function render() {
        document.body.classList.toggle('legal-sidebar-collapsed', desktop.matches && collapsed);
        const expanded = desktop.matches ? !collapsed : document.body.classList.contains('legal-sidebar-open');
        document.querySelectorAll('[data-sidebar-toggle]').forEach(button => {
            button.setAttribute('aria-expanded', String(expanded));
            button.setAttribute('aria-label', expanded ? 'Collapse sidebar' : 'Expand sidebar');
        });
        sidebar.querySelectorAll('.legal-submenu a, .legal-submenu-items a').forEach(link => {
            if (desktop.matches && collapsed) link.setAttribute('tabindex', '-1');
            else link.removeAttribute('tabindex');
        });
    }
    document.addEventListener('click', event => {
        if (event.target.closest('[data-sidebar-toggle]')) {
            event.preventDefault();
            event.stopImmediatePropagation();
            if (desktop.matches) {
                collapsed = !collapsed;
                try { localStorage.setItem('romero-sidebar-collapsed', String(collapsed)); } catch (_) {}
            } else document.body.classList.toggle('legal-sidebar-open');
            render();
        } else if (desktop.matches && collapsed && event.target.closest('#sidenav-main [data-bs-toggle="collapse"]')) {
            collapsed = false;
            try { localStorage.setItem('romero-sidebar-collapsed', 'false'); } catch (_) {}
            render();
        } else if (!desktop.matches && (!event.target.closest('#sidenav-main') || event.target.closest('#sidenav-main a:not([data-bs-toggle])'))) {
            document.body.classList.remove('legal-sidebar-open'); render();
        }
    }, true);
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') { document.body.classList.remove('legal-sidebar-open'); render(); }
    });
    desktop.addEventListener('change', render);
    render();
})();
