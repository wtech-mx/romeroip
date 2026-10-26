(function () {
    'use strict';
    if (!window.jQuery?.fn.select2) return;
    const $ = window.jQuery;
    const contact = document.getElementById('id_contact');
    const email = document.getElementById('client_contact_email');
    function syncEmail() {
        if (!contact || !email) return;
        const options = [...contact.options].map(option => {
            const entry = new Option(option.value ? (option.dataset.email || '—') : 'Select', option.value);
            entry.selected = option.value === contact.value;
            return entry;
        });
        email.replaceChildren(...options);
        $(email).trigger('change.select2');
    }
    if (contact && email) {
        new MutationObserver(syncEmail).observe(contact, { childList: true, subtree: true });
        $(contact).on('change.romeroContact', syncEmail);
        $(email).on('change.romeroContact', () => {
            if (contact.value === email.value) return;
            $(contact).val(email.value).trigger('change');
        });
        syncEmail();
    }
    ['address_holder', 'industrial_address', 'id_contact', 'client_contact_email', 'id_address'].forEach(id => {
        const element = document.getElementById(id);
        if (!element) return;
        if ($(element).hasClass('select2-hidden-accessible')) $(element).select2('destroy');
        $(element).select2({ width: '100%', minimumResultsForSearch: Infinity,
            dropdownCssClass: 'tm-contact-options',
            templateResult: option => option.text,
            templateSelection: option => option.text
        });
        const label = document.querySelector('label[for="' + id + '"]');
        if (label) {
            label.id = label.id || id + '-label';
            $(element).next('.select2').find('[role="combobox"]').attr('aria-labelledby', label.id);
        }
    });
    // Load the current party's full choices on Edit while retaining legacy values.
    async function hydrate(id, baseUrl, partyId, textKey, valueKey, withEmail = false) {
        const select = document.getElementById(id);
        if (!select || !baseUrl || !partyId) return;
        const value = select.value;
        const saved = select.selectedOptions[0]?.cloneNode(true);
        try {
            const response = await fetch(baseUrl + '/' + encodeURIComponent(partyId), { headers: { Accept: 'application/json' } });
            if (!response.ok) return;
            const records = await response.json();
            if (!Array.isArray(records)) return;
            // A different party may have been selected while the request was running.
            const currentParty = document.getElementById(id === 'address_holder' || id === 'industrial_address' ? 'id_holder' : 'id_client');
            if (currentParty?.value !== partyId || select.value !== value) return;
            const options = [new Option('Select', '')];
            records.forEach(record => {
                if (record[valueKey] == null) return;
                const option = new Option(record[textKey] ?? '', record[valueKey]);
                if (withEmail) option.dataset.email = record.email ?? '';
                options.push(option);
            });
            if (value && !options.some(option => option.value === value) && saved) options.push(saved);
            select.replaceChildren(...options);
            $(select).val(value).trigger('change');
        } catch (_) { /* Keep the saved options available if loading fails. */ }
    }
    const owner = document.getElementById('holder');
    const client = document.getElementById('sessions');
    const ownerId = document.getElementById('id_holder')?.value;
    const clientId = document.getElementById('id_client')?.value;
    hydrate('address_holder', owner?.dataset.addressUrl, ownerId, 'address', 'id');
    hydrate('industrial_address', owner?.dataset.estabUrl, ownerId, 'commercial_address', 'commercial_address');
    hydrate('id_contact', client?.dataset.contactUrl, clientId, 'name', 'id', true);
    hydrate('id_address', client?.dataset.addressUrl, clientId, 'address', 'id');
})();
