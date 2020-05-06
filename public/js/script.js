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

$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    $(".entete").css({
        backgroundSize: (100 + scroll/5)  + "%",
        backgroundPositionY: (-100 + scroll/2)
    });
});
$(document).ready(function(){
    $(".owl-one").owlCarousel({
        items:3,
        loop:true,
        center: true,
        margin:0,
        autoplay:true,
        autoplayTimeout:3000,
        nav:true,
        navText:[
            '<img class="sliderControllers" src="img/prev.png">',
            '<img class="sliderControllers" src="img/next.png">'
        ],
        autoplayHoverPause:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            520:{
                items:2
            },
            980:{
                items:3
            }
        }
    });
});

initSlider();

function initSlider() {

    var html = '';
    for (var i = 0; i < 6; i++) {

        html += '<div class="sliderItem" style=\'background-image: url("img/carous' + (i+1) + '.jpg")\'></div>';
    }

    document.querySelector('.owl-one').innerHTML = html;
}


