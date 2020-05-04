const menuBtn = document.querySelector('.menu-btn');
let menuOpen = false;
const modal = document.querySelector('.modal');
menuBtn.addEventListener('click', () => {
    if(!menuOpen) {
        menuBtn.classList.add('open');
        modal.classList.add('open-modal');
        menuOpen = true;
    } else {
        menuBtn.classList.remove('open');
        modal.classList.remove('open-modal');
        menuOpen = false;
    }
});


