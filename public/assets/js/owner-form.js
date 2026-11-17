(function () {
    'use strict';
    const form = document.getElementById('owner-form');
    if (!form) return;
    const grid = form.querySelector('[data-owner-type]');
    function syncType() {
        const individual = form.querySelector('[name="owner_type"]:checked').value === 'Individual';
        grid.dataset.ownerType = individual ? 'Individual' : 'Company';
        form.querySelector('[data-owner-name-label]').textContent = individual ? 'Full Name' : 'Company Name';
        form.querySelector('[name="company_name"]').placeholder = individual ? 'Full name (name and surnames)' : 'Company name';
        form.querySelectorAll('[data-individual-field]').forEach(field => {
            field.hidden = !individual;
            field.querySelectorAll('input, select, button, textarea').forEach(control => { control.disabled = !individual; });
        });
    }
    form.querySelectorAll('[name="owner_type"]').forEach(input => input.addEventListener('change', syncType));
    function initialize() {
        syncType();
        if (window.jQuery?.fn.select2) window.jQuery(form.querySelector('.js-owner-country')).select2({ width: '100%' });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize); else initialize();
    const addresses = form.querySelector('[data-owner-addresses]');
    form.querySelector('[data-owner-add-address]').addEventListener('click', () => {
        const template = form.querySelector('[data-owner-address-template]');
        const index = addresses.querySelectorAll('[data-owner-address-row]').length;
        const fragment = template.content.cloneNode(true);
        fragment.querySelectorAll('[id]').forEach(node => { node.id = node.id.replace('__INDEX__', index); });
        fragment.querySelectorAll('[for]').forEach(node => { node.htmlFor = node.htmlFor.replace('__INDEX__', index); });
        const first = fragment.querySelector('textarea');
        addresses.append(fragment); first.focus();
    });
})();
