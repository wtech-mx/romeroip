(function () {
    'use strict';
    const header = document.querySelector('[data-trademark-header]');
    const form = header?.closest('form');
    if (!form) return;
    const read = id => String(document.getElementById(id)?.value || '').trim();
    const selectedName = id => {
        const select = document.getElementById(id);
        return select?.value ? select.selectedOptions[0]?.textContent.trim() || '' : '';
    };
    const text = (part, value) => { header.querySelector('[data-header="' + part + '"]').textContent = value; };
    function sync() {
        const raw = read('status').toLowerCase();
        const status = ({registered:'Registered', registrado:'Registered', registrada:'Registered', pending:'Pending', pendiente:'Pending', abandoned:'Abandoned', abandonada:'Abandoned', abandonado:'Abandoned'})[raw] || (raw ? raw[0].toUpperCase() + raw.slice(1) : '');
        const badge = header.querySelector('[data-header="status"]');
        badge.hidden = !status;
        badge.textContent = status;
        badge.classList.remove('is-registered', 'is-pending', 'is-abandoned');
        if (['Registered', 'Pending', 'Abandoned'].includes(status)) badge.classList.add('is-' + status.toLowerCase());
        text('title', read('trademark') || 'Trademark');
        const isRegistered = status === 'Registered' && read('registration_no');
        const number = isRegistered ? 'Registration No. ' + read('registration_no') : 'Application No.' + (read('application_no') ? ' ' + read('application_no') : '');
        text('number', number + ' – Class' + (read('class') ? ' ' + read('class') : ''));
        text('owner', read('holder_search') || selectedName('id_holder') || 'Owner');
        text('client', read('client_search') || selectedName('id_client') || 'Client');
        const rawDepartment = read('origin');
        const department = ({nacional:'National', national:'National', extranjero:'International', foreign:'International', international:'International', internacional:'International', '-':''})[rawDepartment.toLowerCase()] ?? rawDepartment;
        text('refs', 'O/Ref.' + (read('our_ref') ? ' ' + read('our_ref') : '') + ' – C/Ref.' + (read('client_ref') ? ' ' + read('client_ref') : '') + (department ? ' | ' + department : ''));
    }
    ['input', 'change', 'trademark:selection'].forEach(event => form.addEventListener(event, sync));
    if (window.jQuery) window.jQuery(form).find('select').on('change', sync);
    sync();
})();
