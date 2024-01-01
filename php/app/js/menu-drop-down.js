let menuToggle = (event) => {
    let menuDropDown = document.querySelector('.menu .drop-down');

    if(menuDropDown) {
        menuDropDown.addEventListener('click', () => {
            let subMenu = document.querySelector('.menu .sub-menu');
            if(subMenu) subMenu.classList.toggle('active');
        })
    }
}

window.addEventListener('load', menuToggle );

