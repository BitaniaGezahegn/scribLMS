const addAuthorContainer = document.querySelector('.add-author-container');
const editAuthorContainer = document.querySelector('.edit-author-container');
const quitAddAutor = document.getElementById('quitAddAutor');
const quitEditAutor = document.getElementById('quitEditAutor');
const addAuthor = document.getElementById('addAuthor');

function redirectToEdit(element) {
    window.location.href = 'Authors.php?edit=' + element.dataset.id;
}

quitAddAutor.addEventListener('click', () => {
    addAuthorContainer.style.display = 'none';
})

quitEditAutor.addEventListener('click', () => {
    editAuthorContainer.style.display = 'none';
})

addAuthor.addEventListener('click', () => {
    addAuthorContainer.style.display = 'flex';
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
