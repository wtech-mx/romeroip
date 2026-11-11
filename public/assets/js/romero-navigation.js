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
        else {
            leaving = true;
            if (link.hasAttribute('data-edit-current-section')) {
                const id = decodeURIComponent(destination.hash.slice(1));
                const sourceId = ({ holder: 'owner', sessions: 'client' })[id] || id;
                const section = document.getElementById(sourceId);
                try { sessionStorage.setItem('tm-edit-position', JSON.stringify({ path: destination.pathname, section: id, top: section?.getBoundingClientRect().top, y: window.scrollY })); } catch (error) { /* Navigation still works when storage is disabled. */ }
                destination.hash = '';
                event.preventDefault();
                location.assign(destination.href);
            }
        }
    }, true);
    document.addEventListener('submit', event => {
        if (event.defaultPrevented) return;
        if (event.target === editForm) {
            if (editForm.checkValidity()) leaving = true;
        } else if (!event.target.matches('[data-quick-search], [data-global-search], #trademark-search-form')) {
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
            // The last section may be too short to reach the reading line.
            const last = sections[sections.length - 1];
            const atEnd = window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 3;
            if (last && atEnd) active = last;
            if (active) activate(active.id);
        }
        function scheduleUpdate() {
            if (!scheduled) {
                scheduled = true;
                requestAnimationFrame(updateActive);
            }
        }
        window.addEventListener('scroll', scheduleUpdate, { passive: true });
        ['wheel', 'touchmove', 'pointerdown', 'keydown'].forEach(type => window.addEventListener(type, () => {
            chosenSection = null;
            scheduleUpdate();
        }, { passive: true }));
        updateActive();
        function restoreFilePosition() {
        let restored = false;
        try {
            const saved = JSON.parse(sessionStorage.getItem('tm-edit-position') || 'null');
            sessionStorage.removeItem('tm-edit-position');
            if (saved && saved.path === location.pathname) {
                const section = document.getElementById(saved.section);
                const y = section && typeof saved.top === 'number' ? window.scrollY + section.getBoundingClientRect().top - saved.top : saved.y;
                window.scrollTo({ top: y, behavior: 'instant' });
                activate(saved.section); restored = true;
            }
        } catch (error) { /* Fall back to the requested section. */ }
        const initialSection = decodeURIComponent(location.hash.slice(1));
        if (!restored && sections.some(section => section.id === initialSection)) {
            const section = document.getElementById(initialSection);
            chosenSection = initialSection; activate(initialSection);
            window.scrollTo({ top: window.scrollY + section.getBoundingClientRect().top - sectionOffset, behavior: 'instant' });
        }
        }
        const restoreWhenReady = () => {
            Promise.resolve(document.fonts?.ready).then(() => requestAnimationFrame(() => {
                restoreFilePosition();
                document.documentElement.style.visibility = '';
                document.documentElement.style.overflowAnchor = '';
            }));
        };
        if (document.readyState === 'complete') restoreWhenReady();
        else window.addEventListener('load', restoreWhenReady, { once: true });
    }
    const ourRef = document.getElementById('our_ref');
    ourRef?.addEventListener('input', () => document.querySelectorAll('[data-breadcrumb-reference]').forEach(part => { part.textContent = 'File ' + (ourRef.value || '—'); }));

    document.querySelectorAll('select.tm-country-select').forEach(select => {
        const updateTitle = () => { select.title = select.selectedOptions[0]?.textContent.trim() || ''; };
        select.addEventListener('change', updateTitle); updateTitle();
    });

    const search = document.querySelector('[data-global-search]');
    const dialog = document.querySelector('.legal-search-results');
    if (!search || !dialog) return;
    const input = search.querySelector('input');
    const status = search.querySelector('[role="status"]');
    const placeholder = input.placeholder;
    let request;
    function message(text) {
        status.textContent = text; status.hidden = !text;
        search.classList.toggle('has-message', !!text);
    }
    window.RomeroGlobalStatus = message;
    search.querySelector('[data-global-clear]').addEventListener('click', () => {
        request?.abort(); input.value = ''; input.placeholder = placeholder; message('');
        window.RomeroSearch?.clearQuery(); input.focus();
    });
    input.addEventListener('input', () => { request?.abort(); window.RomeroSearch?.cancel(); message(''); });
    dialog.querySelector('[data-close-search]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
    search.addEventListener('submit', async event => {
        event.preventDefault();
        const number = input.value.trim();
        if (!number) {
            if (window.RomeroSearch) window.RomeroSearch.showLive();
            else navigate(search.dataset.liveResults);
            return;
        }
        if (window.RomeroSearch) { window.RomeroSearch.search(number); return; }
        request?.abort();
        request = new AbortController();
        const current = request;
        message('Searching…');
        try {
            const url = new URL(search.action);
            url.searchParams.set('q', number);
            const response = await fetch(url, { signal: current.signal, headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('Search failed');
            const data = await response.json();
            if (current !== request || current.signal.aborted) return;
            message('');
            if (!data.matches.length) { input.value = ''; message('No matching records found.'); return; }
            if (data.matches.length === 1) { if (navigate(data.matches[0].url)) input.value = ''; return; }
            dialog.querySelector('[data-result-count]').textContent = data.matches.length + ' matches for “' + number + '”';
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
            input.value = '';
        } catch (error) { if (error.name !== 'AbortError') message('Unable to search. Please try again.'); }
    });
})();
