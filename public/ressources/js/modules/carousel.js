class Carousel {
    static initializeCarousel(e) {
        if (e.currentTarget.id == "next1" || e.currentTarget.id == "prev1") {
            const carousel = Array.from(document.querySelectorAll('#carousel-conteneur-left > .carousel-item'));
            const currentActive = document.querySelector('#carousel-conteneur-left > .carousel-item.active');
            Carousel.carouselMotion(e, carousel, currentActive);
        } else {
            const carousel = Array.from(document.querySelectorAll('#carousel-conteneur-right > .carousel-item'));
            const currentActive = document.querySelector('#carousel-conteneur-right > .carousel-item.active');
            Carousel.carouselMotion(e, carousel, currentActive);
        }
    }

    static carouselMotion(e, carousel, currentActive) {
        if (e.currentTarget.id == "next") {
            currentActive.classList.remove('active');
            currentActive.nextElementSibling === null ? carousel[0].classList.add('active') : currentActive.nextElementSibling.classList.add('active');
        } else {
            currentActive.classList.remove('active');
            currentActive.previousElementSibling === null ? carousel[carousel.length - 1].classList.add('active') : currentActive.previousElementSibling.classList.add('active');
        }
    }
}

export { Carousel };