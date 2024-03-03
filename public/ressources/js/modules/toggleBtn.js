export function toggleBtn(e,menu) {
    console.log('toggleBtn');
    const btn = e.currentTarget;
    if (btn.classList.contains('active')) {
        btn.classList.remove('active');
        menu.classList.remove('display');
        btn.setAttribute('aria-label', 'show the menu');
        btn.setAttribute('aria-expanded', 'false');
    } else {
        btn.classList.add('active');
        menu.classList.add('display');
        btn.setAttribute('aria-label', 'hide the menu');
        btn.setAttribute('aria-expanded', 'true');
    }
}