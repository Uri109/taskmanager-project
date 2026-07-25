import './bootstrap';

document.querySelectorAll('[data-dismiss]').forEach(button => button.addEventListener('click', () => button.closest('[data-toast]').remove()));
const toast = document.querySelector('[data-toast]');
if (toast) setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateY(10px)'; setTimeout(() => toast.remove(), 300); }, 5200);
document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => { if (!window.confirm(form.dataset.confirm)) event.preventDefault(); }));
document.querySelectorAll('form').forEach(form => form.addEventListener('submit', () => { const button = form.querySelector('button[type="submit"], button:not([type])'); if (button && !form.dataset.confirm) { button.disabled = true; button.style.opacity = '.7'; button.textContent = 'Working…'; } }));
