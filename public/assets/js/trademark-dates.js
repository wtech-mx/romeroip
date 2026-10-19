(function (root) {
    'use strict';
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const pad = value => String(value).padStart(2, '0');

    function parse(value) {
        const text = String(value || '').trim();
        if (!text) return '';
        let day, month, year;
        let match = text.match(/^(\d{4})-(\d{2})-(\d{2})$/);
        if (match) {
            [, year, month, day] = match;
        } else {
            match = text.match(/^([A-Za-z]+|\d{1,2})[\s/.-]+(\d{1,2})[\s/.-]+(\d{2}|\d{4})$/);
            if (!match) {
                match = text.match(/^(\d{2})(\d{2})(\d{2}|\d{4})$/);
            }
            if (!match) return null;
            [, month, day, year] = match;
            if (/^[A-Za-z]+$/.test(month)) {
                const index = months.findIndex(name => name.toLowerCase() === month.slice(0, 3).toLowerCase());
                if (index < 0) return null;
                month = index + 1;
            }
            if (year.length === 2) year = 2000 + Number(year);
        }
        day = Number(day); month = Number(month); year = Number(year);
        if (year < 1000 || year > 9999 || month < 1 || month > 12 || day < 1) return null;
        const date = new Date(year, month - 1, day);
        if (date.getFullYear() !== year || date.getMonth() !== month - 1 || date.getDate() !== day) return null;
        return `${year}-${pad(month)}-${pad(day)}`;
    }

    function format(value) {
        const iso = parse(value);
        if (!iso) return '';
        const [year, month, day] = iso.split('-');
        return `${months[Number(month) - 1]}/${day}/${year}`;
    }

    root.TrademarkDates = { parse, format };
    if (typeof module !== 'undefined' && module.exports) module.exports = root.TrademarkDates;
    if (typeof document === 'undefined') return;

    const controls = [];
    document.querySelectorAll('.tm-page input.date-mask[type="date"]').forEach(native => {
        const wrapper = native.parentElement;
        wrapper.classList.add('tm-date-control');
        const display = document.createElement('input');
        display.type = 'text';
        display.id = `${native.id}-display`;
        display.className = 'form-control tm-input tm-date-display';
        display.placeholder = 'mm/dd/yyyy';
        display.autocomplete = 'off';
        display.value = format(native.value);
        display.title = 'Enter month/day/year. 07/06/23 becomes Jul/06/2023. For dates before 2000, use four year digits.';
        const label = document.querySelector(`label[for="${native.id}"]`);
        if (label) label.htmlFor = display.id;
        native.className = 'tm-date-native';
        native.tabIndex = -1;
        native.setAttribute('aria-hidden', 'true');

        const picker = document.createElement('button');
        picker.type = 'button';
        picker.tabIndex = -1;
        picker.className = 'tm-date-picker';
        picker.setAttribute('aria-label', `Choose ${label?.textContent.trim() || 'date'}`);
        picker.innerHTML = '<i class="bi bi-calendar3" aria-hidden="true"></i>';
        picker.addEventListener('click', () => {
            if (typeof native.showPicker === 'function') native.showPicker();
            else { native.focus(); native.click(); }
        });
        const feedback = document.createElement('span');
        feedback.id = `${native.id}-feedback`;
        feedback.className = 'tm-date-feedback';
        feedback.hidden = true;
        display.setAttribute('aria-describedby', feedback.id);
        wrapper.prepend(display);
        wrapper.append(picker, feedback);

        function clearError() {
            display.setCustomValidity('');
            display.removeAttribute('aria-invalid');
            display.classList.remove('is-invalid');
            feedback.hidden = true;
        }
        function commit() {
            const iso = parse(display.value);
            if (iso === null) {
                const message = 'Enter a valid date, for example Jul/06/2023 or 07/06/23.';
                display.setCustomValidity(message);
                display.setAttribute('aria-invalid', 'true');
                display.classList.add('is-invalid');
                feedback.textContent = message;
                feedback.hidden = false;
                return false;
            }
            clearError();
            const changed = native.value !== iso;
            native.value = iso;
            display.value = format(iso);
            if (changed) native.dispatchEvent(new Event('change', { bubbles: true }));
            return true;
        }
        display.addEventListener('input', clearError);
        display.addEventListener('blur', commit);
        // jQuery calculations also trigger this event when derived deadlines change.
        if (root.jQuery) root.jQuery(native).on('change', () => { display.value = format(native.value); clearError(); });
        else native.addEventListener('change', () => { display.value = format(native.value); clearError(); });
        controls.push({ native, display, commit });
    });

    new Set(controls.map(control => control.native.form)).forEach(form => {
        if (!form) return;
        form.addEventListener('submit', event => {
            const invalid = controls.filter(control => control.native.form === form && !control.commit());
            if (invalid.length) {
                event.preventDefault();
                event.stopImmediatePropagation();
                invalid[0].display.focus();
            }
        }, true);
    });
})(typeof window !== 'undefined' ? window : globalThis);
