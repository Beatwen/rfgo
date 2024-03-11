import {toggleBtn} from '/rfgo/public/ressources/js/modules/toggleBtn.js';

//Gestion du menu hamburger permettant d'afficher ou non le menu
const btn = document.querySelector('.btnMenu');
const toggleBtnFunc = (e) => {
    const menu = document.querySelector('#menu');
    toggleBtn(e,menu);
}

btn.addEventListener('click', toggleBtnFunc);

// Gestion du carousel
import {Carousel} from '/rfgo/public/ressources/js/modules/carousel.js';

const carouselCallback = (event) => {
    Carousel(event);
}

//Ajout des fonctions sur les flèches du Carousel
const btnCarousel = document.querySelectorAll('.carousel-btn-direction');
btnCarousel.forEach((item) => { 
    item.addEventListener('click', carouselCallback);
});


