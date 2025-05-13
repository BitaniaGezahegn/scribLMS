const view_by = document.getElementById('view_by'); // View By Toggle Btn
const view_arrow = document.getElementById('view_arrow'); // View By Toggle Btn Arrow
const view_icon = document.getElementById('view_icon'); // View By Toggle Btn Icon
const view_select = document.getElementById('view_select'); // View By Toggle Btn Drop Down Container
const list_mode = document.getElementById('list_mode'); // View By Toggle Btn sub button for LIST Mode
const grid_mode = document.getElementById('grid_mode'); // View By Toggle Btn sub button for GRID Mode

const filter_by = document.getElementById('filter_by');
const filter_arrow = document.getElementById('filter_arrow'); // View By Toggle Btn Arrow
const filter_icon = document.getElementById('filter_icon'); // View By Toggle Btn Icon
const filter_select = document.getElementById('filter_select'); // View By Toggle Btn Drop Down Container
const genre_mode = document.getElementById('genre_mode'); // View By Toggle Btn sub button for LIST Mode
const author_mode = document.getElementById('author_mode'); // View By Toggle Btn sub button for GRID Mode

const list_mode_container = document.getElementById('list_mode_container');
const grid_mode_container = document.getElementById('grid_mode_container');


function reset_hover() {    
    view_by.addEventListener('mouseover', () => {
        view_by.style.border = ' 2px solid var(--link)';
    });

    view_by.addEventListener('mouseout', () => {
        view_by.style.border = '2px solid var(--light-text)';
    });

    filter_by.addEventListener('mouseover', () => {
        filter_by.style.border = ' 2px solid var(--link)';
    });

    filter_by.addEventListener('mouseout', () => {
        filter_by.style.border = '2px solid var(--light-text)';
    });
}

function collapse_view(btnFor) {
    reset_hover();
    if (btnFor === 'view_by') {
        view_by.classList.remove('expanded');
        view_by.classList.add('collapsed');


        view_by.style.border = '2px solid var(--light-text)';
        view_by.style.background = 'var(--background)';
        view_arrow.style.transform = 'Rotate(0deg)';

        view_select.style.height = '0px';
        view_select.style.display = 'none';
    } else if (btnFor === 'filter_by') {
        filter_by.classList.remove('expanded');
        filter_by.classList.add('collapsed');


        filter_by.style.border = '2px solid var(--light-text)';
        filter_by.style.background = 'var(--background)';
        filter_arrow.style.transform = 'Rotate(0deg)';

        filter_select.style.height = '0px';
        filter_select.style.display = 'none';
    }
}

function expand_view(btnFor) {
    reset_hover();
    if (btnFor === 'view_by') {
        view_by.classList.remove('collapsed');
        view_by.classList.add('expanded');
    
        view_by.style.border = '2px solid var(--link)';
        view_by.style.background = 'rgba(0, 123, 255, .3)';
        view_arrow.style.transform = 'Rotate(180deg)';
        
        view_select.style.height = 'fit-content';
        view_select.style.display = 'flex';
    } else if (btnFor === 'filter_by') {
        filter_by.classList.remove('collapsed');
        filter_by.classList.add('expanded');
    
        filter_by.style.border = '2px solid var(--link)';
        filter_by.style.background = 'rgba(0, 123, 255, .3)';
        filter_arrow.style.transform = 'Rotate(180deg)';
        
        filter_select.style.height = 'fit-content';
        filter_select.style.display = 'flex';
    }
}

function set_view_by_icon(mode) {
    if (mode == 'list') {
        view_icon.innerHTML = 'list';
    } else if (mode == 'grid') {
        view_icon.innerHTML = 'grid_view';
    }
}

function set_filter_by_icon(mode) {
    if (mode == 'genre') {
        filter_icon.innerHTML = 'filter_list';
    } else if (mode == 'author') {
        filter_icon.innerHTML = 'person_4';
    }
}

function renderList() {
    // Remove Grid Mode
    grid_mode_container.style.display = 'none';
    // Render List Mode
    list_mode_container.style.display = 'block';
}

function renderGrid() {
    // Remove List Mode
    list_mode_container.style.display = 'none';
    // Render Grid Mode
    grid_mode_container.style.display = 'grid';
}

// View by Clicked
view_by.addEventListener('click', () => {

    if (view_by.classList.contains('expanded')) {
        collapse_view('view_by');
    }
    else if (view_by.classList.contains('collapsed')) {
        expand_view('view_by');
    }
})

// filter_by Clicked
filter_by.addEventListener('click', () => {

    if (filter_by.classList.contains('expanded')) {
        collapse_view('filter_by');
    }
    else if (filter_by.classList.contains('collapsed')) {
        expand_view('filter_by');
    }
})

// List Mode
list_mode.addEventListener('click', () => {
    set_view_by_icon('list');

    view_by.classList.remove('view-grid');
    view_by.classList.add('view-list');

    renderList();
})

// Grid Mode
grid_mode.addEventListener('click', () => {
    set_view_by_icon('grid');
    view_by.classList.remove('view-list');
    view_by.classList.add('view-grid');
    
    renderGrid();
})

// Genre Mode
genre_mode.addEventListener('click', () => {
    set_filter_by_icon('genre');

    filter_by.classList.remove('filter-author');
    filter_by.classList.add('filter-genre');
    window.location.href = 'index.php?categories=';
})

// Author Mode
author_mode.addEventListener('click', () => {
    set_filter_by_icon('author');

    filter_by.classList.remove('filter-genre');
    filter_by.classList.add('filter-author');
    window.location.href = 'index.php?authors=';
})