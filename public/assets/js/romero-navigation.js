(function () {
    'use strict';
    const editForm = document.getElementById('trademarkEditForm') || document.getElementById('trademarkForm');
    function snapshot() {
        if (!editForm) return '';
        const data = [...new FormData(editForm)].filter(([key]) => !['_token', '_method'].includes(key)).map(([key, value]) =>
            [key, value instanceof File ? [value.name, value.size, value.name ? value.lastModified : 0] : value]);
        editForm.querySelectorAll('.tm-date-display, #holder_search, #client_search').forEach(control => data.push([control.id, control.value]));
        return JSON.stringify(data);
    }
    const baseline = snapshot();
    let leaving = false;
    function dirty() {
        return !!editForm && (editForm.dataset.unsavedInput === 'true' || snapshot() !== baseline);
    }
    function confirmLeave() {
        return !dirty() || window.confirm('You have unsaved changes. Leave this file without saving?');
    }
    function navigate(url) {
        if (!confirmLeave()) return false;
        leaving = true;
        window.location.assign(url);
        return true;
    }
    window.RomeroNavigation = { dirty, navigate };
    window.addEventListener('beforeunload', event => {
        if (!leaving && dirty()) { event.preventDefault(); event.returnValue = ''; }
    });
    document.addEventListener('click', event => {
        const link = event.target.closest('a[href]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || link.target === '_blank' || link.hasAttribute('download')) return;
        const raw = link.getAttribute('href');
        if (!raw || raw.startsWith('#') || raw.startsWith('javascript:')) return;
        const destination = new URL(link.href, location.href);
        if (destination.pathname === location.pathname && destination.search === location.search && destination.origin === location.origin) return;
        if (!confirmLeave()) { event.preventDefault(); event.stopImmediatePropagation(); }
        else leaving = true;
    }, true);
    document.addEventListener('submit', event => {
        if (event.defaultPrevented) return;
        if (event.target === editForm) {
            if (editForm.checkValidity()) leaving = true;
        } else if (!event.target.matches('[data-quick-search]')) {
            if (!confirmLeave()) { event.preventDefault(); event.stopImmediatePropagation(); }
            else leaving = true;
        }
    });

    const topbar = document.querySelector('.legal-topbar');
    const panel = document.querySelector('.tm-sections-panel');
    let sectionOffset = 100;
    function measure() {
        const headerHeight = topbar?.getBoundingClientRect().height || 64;
        const compactHeight = panel && getComputedStyle(panel).float === 'none' ? panel.getBoundingClientRect().height + 8 : 0;
        sectionOffset = headerHeight + compactHeight + 24;
        document.documentElement.style.setProperty('--legal-header-height', headerHeight + 'px');
        document.documentElement.style.setProperty('--tm-section-offset', sectionOffset + 'px');
    }
    if (topbar) new ResizeObserver(measure).observe(topbar);
    if (panel) new ResizeObserver(measure).observe(panel);
    window.addEventListener('resize', measure);
    measure();
    if (panel) {
        const links = [...panel.querySelectorAll('[data-section-link]')];
        const sections = links.map(link => document.getElementById(link.dataset.sectionLink)).filter(Boolean);
        const picker = panel.querySelector('[data-section-picker]');
        let chosenSection = null;
        function activate(id) {
            const editLink = panel.querySelector('[data-edit-current-section]');
            const editSection = ({ owner: 'holder', client: 'sessions' })[id] || id;
            if (editLink) editLink.setAttribute('href', editLink.href.split('#')[0] + '#' + editSection);
            links.forEach(link => {
                const active = link.dataset.sectionLink === id;
                link.classList.toggle('is-active', active);
                if (active) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current');
            });
            if (picker) picker.value = id;
        }
        function scrollToSection(id) {
            const section = document.getElementById(id);
            if (!section) return;
            chosenSection = id;
            activate(id);
            section.scrollIntoView({ block: 'start', behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
        }
        links.forEach(link => link.addEventListener('click', event => { event.preventDefault(); scrollToSection(link.dataset.sectionLink); }));
        picker?.addEventListener('change', () => scrollToSection(picker.value));
        let scheduled = false;
        function updateActive() {
            scheduled = false;
            if (chosenSection) { activate(chosenSection); return; }
            let active = sections[0];
            // Short final sections cannot always reach the sticky header. Track
            // the upper reading area instead of jumping straight to Notes.
            const readingLine = Math.max(sectionOffset + 2, window.innerHeight * 0.35);
            sections.forEach(section => { if (section.getBoundingClientRect().top <= readingLine) active = section; });
            // Near the document end a short Notes section must not mask Dates.
            const last = sections[sections.length - 1];
            if (last && last.getBoundingClientRect().top <= sectionOffset + 2) active = last;
            if (active) activate(active.id);
        }
        window.addEventListener('scroll', () => { if (!scheduled) { scheduled = true; requestAnimationFrame(updateActive); } }, { passive: true });
        ['wheel', 'touchmove', 'pointerdown', 'keydown'].forEach(type => window.addEventListener(type, () => { chosenSection = null; }, { passive: true }));
        updateActive();
        const initialSection = decodeURIComponent(location.hash.slice(1));
        if (sections.some(section => section.id === initialSection)) {
            requestAnimationFrame(() => scrollToSection(initialSection));
        }
    }
    const ourRef = document.getElementById('our_ref');
    ourRef?.addEventListener('input', () => document.querySelectorAll('[data-breadcrumb-reference]').forEach(part => { part.textContent = 'File ' + (ourRef.value || '—'); }));

    const search = document.querySelector('[data-quick-search]');
    const dialog = document.querySelector('.legal-search-results');
    if (!search || !dialog) return;
    const input = search.querySelector('input');
    const status = search.querySelector('[role="status"]');
    let request;
    function message(text) { status.textContent = text; status.hidden = !text; }
    input.addEventListener('input', () => { request?.abort(); message(''); });
    dialog.querySelector('[data-close-search]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
    search.addEventListener('submit', async event => {
        event.preventDefault();
        const number = input.value.trim();
        if (!/^[0-9]+$/.test(number)) { message('Enter a number using digits only.'); return; }
        request?.abort();
        request = new AbortController();
        const current = request;
        message('Searching…');
        try {
            const url = new URL(search.action);
            url.searchParams.set('number', number);
            const response = await fetch(url, { signal: current.signal, headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('Search failed');
            const data = await response.json();
            if (current !== request || current.signal.aborted) return;
            message('');
            if (!data.matches.length) { message('No matching records found'); return; }
            if (data.matches.length === 1) { navigate(data.matches[0].url); return; }
            dialog.querySelector('[data-result-count]').textContent = data.matches.length + ' exact matches for “' + number + '”';
            const list = dialog.querySelector('[data-result-list]');
            list.replaceChildren();
            data.matches.forEach(record => {
                const card = document.createElement('article');
                card.className = 'legal-search-result';
                const title = document.createElement('h3'); title.textContent = record.trademark;
                const tags = document.createElement('p'); tags.className = 'legal-search-match'; tags.textContent = record.matched_fields.join(' · ');
                const detail = document.createElement('p'); detail.textContent = 'O/Ref. ' + (record.our_ref || '—') + ' · Application No. ' + (record.application_no || '—') + ' · Registration No. ' + (record.registration_no || '—');
                const open = document.createElement('a'); open.href = record.url; open.className = 'tm-btn tm-btn-primary'; open.textContent = 'Open Record';
                card.append(title, tags, detail, open); list.append(card);
            });
            dialog.showModal();
        } catch (error) { if (error.name !== 'AbortError') message('Unable to search. Please try again.'); }
    });
})();
