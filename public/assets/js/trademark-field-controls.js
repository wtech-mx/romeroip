(function () {
    'use strict';
    const sections = document.querySelectorAll('.tm-approved-section');
    if (!sections.length) return;
    const context = document.createElement('canvas').getContext('2d');
    function textWidth(control, text) {
        context.font = getComputedStyle(control).font;
        return Math.ceil(context.measureText(text || '').width);
    }
    function fitDate(control) {
        control.style.setProperty('--tm-date-width', (textWidth(control, control.value || control.placeholder) + 11) + 'px');
    }
    function fitSelect(control) {
        const width = textWidth(control, control.selectedOptions[0]?.textContent.trim() || 'Select');
        control.parentElement.style.setProperty('--tm-select-width', (width + 39) + 'px');
        control.parentElement.style.setProperty('--tm-select-text', width + 'px');
    }
    function refresh() {
        sections.forEach(section => {
            section.querySelectorAll('.tm-date-display').forEach(fitDate);
            section.querySelectorAll('select.tm-select').forEach(fitSelect);
        });
    }
    sections.forEach(section => {
        section.querySelectorAll('select.tm-select').forEach(control => {
            const arrow = document.createElement('span');
            arrow.className = 'tm-select-chevron';
            arrow.setAttribute('aria-hidden', 'true');
            control.parentElement.append(arrow);
            if (window.jQuery) window.jQuery(control).on('change', () => fitSelect(control));
        });
        // focusout runs after the date control's blur formatter.
        ['input', 'change', 'focusout'].forEach(event => section.addEventListener(event, refresh));
    });
    window.addEventListener('resize', refresh);
    if (document.fonts) document.fonts.ready.then(refresh);
    refresh();
})();
