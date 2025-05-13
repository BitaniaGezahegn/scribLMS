const signup_container = document.getElementById('sign-up-container');
const signin_container = document.getElementById('sign-in-container');
const enableSignup = document.getElementById('enableSignup') ?? null;
const enableSignin = document.getElementById('enableSignin') ?? null;
const isAdmin = document.getElementById('isAdmin') ?? null;
const adminInput = document.getElementById('adminInput') ?? null;

if (signup_container && signin_container) {
    signup_container.style.display = 'none';
    signin_container.style.display = 'flex';
}

if (enableSignup) {
    enableSignup.addEventListener('click', () => {
        signup_container.style.display = 'flex';
        signin_container.style.display = 'none';
    });
}

if (enableSignin) {
    enableSignin.addEventListener('click', () => {
        signup_container.style.display = 'none';
        signin_container.style.display = 'flex';
    });
}

if (isAdmin) {
    isAdmin.addEventListener('click', () => {
        adminInput.checked = !adminInput.checked;
    });
}