(function () {
    const controls = document.querySelector('[data-photo-position]');
    if (!controls) return;
    const image = controls.querySelector('[data-photo-preview]');
    const x = controls.querySelector('[name="profile_photo_x"]'), y = controls.querySelector('[name="profile_photo_y"]'), zoom = controls.querySelector('[name="profile_photo_zoom"]');
    function preview() { image.style.objectPosition = `${x.value}% ${y.value}%`; image.style.transformOrigin = `${x.value}% ${y.value}%`; image.style.transform = `scale(${zoom.value})`; }
    controls.addEventListener('input', preview);
    controls.querySelector('[data-photo-center]').addEventListener('click', () => { x.value = y.value = 50; zoom.value = 1; preview(); });
    preview();
})();
