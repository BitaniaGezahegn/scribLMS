const ths = document.querySelectorAll('th');
const icons = document.querySelectorAll('span.material-symbols-outlined');

icons.forEach(icon => {
    if (icon.innerHTML == 'status-indicator') {
        icon.classList.add('status-indicator');
        icon.innerHTML = '';
    }
});

first_th = ths[0];
last_th = ths[ths.length - 1];

first_th.style.borderTopLeftRadius = '10px';
