(function () {
    'use strict';
    document.querySelectorAll('.tm-approved-section select.tm-select').forEach(control => {
        const arrow = document.createElement('span');
        arrow.className = 'tm-select-chevron';
        arrow.setAttribute('aria-hidden', 'true');
        control.parentElement.append(arrow);
    });
})();
