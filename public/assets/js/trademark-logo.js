(function () {
    'use strict';
    const input = document.getElementById('design');
    const zone = document.querySelector('.tm-mark-logo');
    const preview = document.getElementById('blah');
    if (!input || !zone || !preview) return;
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
        const reader = new FileReader();
        reader.onload = () => { preview.src = reader.result; preview.hidden = false; };
        reader.readAsDataURL(file);
    }
    input.addEventListener('change', showPreview);
    ['dragover', 'drop'].forEach(type => zone.addEventListener(type, event => event.preventDefault()));
    zone.addEventListener('drop', event => {
        if (!event.dataTransfer.files.length) return;
        input.files = event.dataTransfer.files;
        showPreview();
    });
})();
