(function () {
    'use strict';
    const input = document.getElementById('design');
    const zone = document.querySelector('.tm-mark-logo');
    const preview = document.getElementById('blah');
    const remove = document.getElementById('removeDesignButton');
    const removeFlag = document.getElementById('remove_design');
    const container = document.getElementById('representationLogoPreview');
    if (!input || !zone || !preview || !remove || !removeFlag) return;
    let version = 0;
    function showPreview() {
        const file = input.files?.[0];
        if (!file) return;
        const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowed.includes(file.type) || file.size > 4 * 1024 * 1024) {
            input.setCustomValidity('Choose a JPG, PNG, WEBP or GIF image, up to 4 MB.');
            input.reportValidity();
            return;
        }
        input.setCustomValidity('');
        const current = ++version;
        const reader = new FileReader();
        reader.onload = () => {
            if (current !== version) return;
            preview.src = reader.result; preview.hidden = false;
            container.classList.add('has-image'); remove.hidden = false; removeFlag.value = '0';
        };
        reader.readAsDataURL(file);
    }
    remove.addEventListener('click', () => {
        version++;
        input.value = ''; input.setCustomValidity('');
        preview.hidden = true; preview.removeAttribute('src');
        container.classList.remove('has-image'); remove.hidden = true; removeFlag.value = '1';
    });
    input.addEventListener('change', showPreview);
    ['dragover', 'drop'].forEach(type => zone.addEventListener(type, event => event.preventDefault()));
    zone.addEventListener('drop', event => {
        if (!event.dataTransfer.files.length) return;
        input.files = event.dataTransfer.files; showPreview();
    });
})();
