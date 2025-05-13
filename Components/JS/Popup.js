const closePopup = document.getElementById('close') ?? null;
const Popup = document.getElementById('popup-container') ?? null;
const timer = document.getElementById('timer') ?? null;

// onPopup
function initiatePopup() {
        Popup.classList.remove('slide-in-blurred-top');
        Popup.classList.remove('slide-out-blurred-top');

        Popup.classList.add('slide-in-blurred-top');
        Popup.style.display = 'flex';
        timer.classList.add('start-timer');
        setTimeout(() => {
                Popup.classList.remove('slide-in-blurred-top');
                initiatePopout();
        }, 5000)
}

function initiatePopout() {
        Popup.classList.remove('slide-in-blurred-top');
        Popup.classList.remove('slide-out-blurred-top');

        Popup.classList.add('slide-out-blurred-top');
        setTimeout(() => {
                Popup.style.display = 'none';
                Popup.classList.remove('slide-out-blurred-top');
        }, 600)
}
if (closePopup) {
        closePopup.addEventListener('click', () => {
                initiatePopout();
        })
}