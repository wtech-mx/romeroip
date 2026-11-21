(function () {
    'use strict';
    const form = document.getElementById('owner-form');
    if (!form) return;
    const grid = form.querySelector('[data-owner-type]');
    function syncType() {
        const individual = form.querySelector('[name="owner_type"]:checked').value === 'Individual';
        grid.dataset.ownerType = individual ? 'Individual' : 'Company';
        form.dataset.ownerType = grid.dataset.ownerType;
        const country = form.querySelector('.owner-country');
        const tax = form.querySelector('.owner-tax');
        if (individual) { grid.insertBefore(tax, form.querySelector('#owner-sex').closest('[data-individual-field]')); grid.append(country); }
        else grid.append(country, tax);
        form.querySelector('[data-owner-tax-label]').textContent = individual ? 'RFC' : 'Tax No.';
        form.querySelector('[name="rfc"]').placeholder = individual ? 'RFC' : 'Tax number';
        const contactSection = form.querySelector('#owner-contact-title').closest('section');
        const addressSection = form.querySelector('#owner-address-title').closest('section');
        if (individual) form.insertBefore(addressSection, contactSection); else form.insertBefore(contactSection, addressSection);
        form.querySelector('[data-owner-name-label]').textContent = individual ? 'Full Name' : 'Company Name';
        form.querySelector('[name="company_name"]').placeholder = individual ? 'Full name (name and surnames)' : 'Company name';
        form.querySelectorAll('[data-individual-field]').forEach(field => {
            field.hidden = !individual;
            field.querySelectorAll('input, select, button, textarea').forEach(control => { control.disabled = !individual; });
        });
        form.querySelectorAll('[data-company-field]').forEach(field => {
            field.hidden = individual;
            field.querySelectorAll('input, select, button, textarea').forEach(control => { control.disabled = individual; });
        });
    }
    form.querySelectorAll('[name="owner_type"]').forEach(input => input.addEventListener('change', syncType));
    function initialize() {
        syncType();
        if (window.jQuery?.fn.select2) window.jQuery(form.querySelector('.js-owner-country')).select2({ width: '100%' });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initialize); else initialize();
    const addresses = form.querySelector('[data-owner-addresses]');
    let nextAddressIndex = addresses.querySelectorAll('[data-owner-address-row]').length;
    form.querySelector('[data-owner-add-address]').addEventListener('click', () => {
        const template = form.querySelector('[data-owner-address-template]');
        const index = nextAddressIndex++;
        const fragment = template.content.cloneNode(true);
        fragment.querySelectorAll('[id]').forEach(node => { node.id = node.id.replace('__INDEX__', index); });
        fragment.querySelectorAll('[for]').forEach(node => { node.htmlFor = node.htmlFor.replace('__INDEX__', index); });
        const first = fragment.querySelector('textarea');
        addresses.append(fragment); first.focus();
    });
    addresses.addEventListener('click', event => {
        const remove = event.target.closest('[data-owner-remove-address]');
        if (!remove) return;
        const row = remove.closest('[data-additional-address]');
        if (!row) return;
        const id = row.dataset.addressId;
        if (id && !window.confirm('Remove this additional address? Existing trademark records will retain their address history.')) return;
        if (id) {
            const input = document.createElement('input'); input.type = 'hidden'; input.name = 'removed_address_ids[]'; input.value = id; form.append(input);
        }
        row.remove();
        form.querySelector('[data-owner-add-address]').focus();
    });
})();
