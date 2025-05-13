if (document.getElementById("page_data") != null) {
    const page_data = document.getElementById("page_data");
    const curruntPage = parseInt(page_data.innerText.split(" ")[1]);
    const totalPages = parseInt(page_data.innerText.split(" ")[3]);
    
    const pagination_forms = document.querySelectorAll(".pagination-form");
    pagination_forms.forEach(form => {
        form.addEventListener("submit", (e) => {
            if(form.classList.contains("pagination_prev") && curruntPage == 1){
                e.preventDefault();
            }
            if (form.classList.contains("pagination_next") && curruntPage == totalPages) {
                e.preventDefault();
            }
        }
    )}
    );
}


function redirectToEdit(element) {
    window.location.href = 'Edit_book.php?ISBN=' + element.dataset.isbn;
}

function redirectToDelete(element) {
    window.location.href = 'Includes/Processes/Book/deleteBook.inc.php?ISBN=' + element.dataset.isbn;
}

function redirectToView(element) {
    window.location.href = 'Book_Details.php?ISBN=' + element.dataset.isbn;
}



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