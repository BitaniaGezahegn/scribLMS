const filters = document.querySelectorAll('.filter-btn p');
filters[0].style.color = 'var(--error)';
// var selectedFilters = [];

for (let i = 0; i < filters.length; i++) {
    const filterBtn = filters[i];
    const initialWidth = filterBtn.offsetWidth;

    filterBtn.addEventListener('click', () => {
        filterBtn.classList.toggle('selected');
        
        if (filterBtn.innerHTML.toLowerCase() == 'clear') {
            for (let i = 0; i < filters.length; i++) {
                const filterBtn = filters[i];
                filterBtn.classList.remove('selected');  
                selectedFilters = [];
            }
        }
        // if (filterBtn.classList.contains('selected')) { 
        //     selectedFilters.push(filterBtn);
        // } else {
        //     let filterToRemove = '';
        //     selectedFilters.forEach(filter => {
        //         if (!filter.classList.contains('selected')) {
        //             filterToRemove = filter;
        //         }
        //     });

        //     selectedFilters = selectedFilters.filter(item => item !== filterToRemove);
        // }
    });

    filterBtn.addEventListener('mouseover', () => {
        filterBtn.style.width = filterBtn.scrollWidth + "px";
        filterBtn.style.paddingLeft = '20px';
    });

    filterBtn.addEventListener('mouseout', () => {
        filterBtn.style.width = initialWidth + "px";
        filterBtn.style.paddingLeft = '15px';
    });
}