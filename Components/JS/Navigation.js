const nav_links = document.querySelectorAll('.link');
var selected_page_ = document.URL.split('?').slice(0)[0];
var selected_page = selected_page_.split('/').slice(-1)[0];

if (document.URL.split('/')[4] == "") {
    selected_page = 'index.php';
}    

function updateCurrutPage(to) {
    var selected = document.querySelector('a.selected');
    if (selected) {
        selected.classList.remove('selected');
    }
    to.classList.add('selected');
}

for (let i = 0; i < nav_links.length; i++) {
    const link = nav_links[i];
    if (link.classList.contains('selected')) {
        link.classList.remove('selected');
    }
    var pageURL = link.href.split('/').slice(-1)[0];
    
    if (pageURL == selected_page) {
        updateCurrutPage(link);
        break;
    }
}