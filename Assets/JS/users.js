const editUserContainer = document.querySelector('.edit-user-container');
const quitEditUser = document.getElementById('quitEditUser');


function redirectToEdit(element) {
    window.location.href = 'Users.php?edit=' + element.dataset.id;
}

quitEditUser.addEventListener('click', () => {
    editUserContainer.style.display = 'none';
})


setTimeout(() => {
    try {
        document.URL.split('?')[1].split('&').forEach(attribute => {
        var data = attribute.split('=');
        if (data[0] == 'popup') {
            initiatePopup();
        }
        });
    } catch (error) {
        console.log(error);
    }
}, 100);