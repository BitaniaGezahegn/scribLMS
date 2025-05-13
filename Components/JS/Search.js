const search = document.getElementById('search');
const search_input = document.getElementById('search_input');

if (search) {
    search.style.width = "30%";
 
    search_input.addEventListener('focus', () => {
        curruntWidth = parseInt(search.style.width.split('').slice(0, -1).join(''));
        updatedWidth = curruntWidth + 20;
        search.style.width = updatedWidth.toString() + '%';
    })
    
    search_input.addEventListener('blur', () => {
        curruntWidth = parseInt(search.style.width.split('').slice(0, -1).join(''));
        updatedWidth = curruntWidth - 20;
        search.style.width = updatedWidth.toString() + '%';
    })
}