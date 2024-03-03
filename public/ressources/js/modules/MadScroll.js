// animation au scroll, on récupère les éléments du formulaire et on les fait bouger en fonction du scroll
// on a une rotation et un deplacement

function gestionDefilement(element, scrollValue, vitesse, index) {
    const direction = index % 2 === 0 ? 1 : -1;
    const rotate = scrollValue * direction * 0.1; 
    const scale = 1 + index * 0.05 * (scrollValue % 100) / 1000; 
    const translateY = scrollValue * vitesse;
    const translateX = scrollValue * direction * vitesse;

    element.style.transform = `translateY(${translateY}px) translateX(${translateX}px) rotate(${rotate}deg) scale(${scale})`;
}

const envoi = () => {
    const tableau = document.querySelectorAll("form > input, form > label, form > button")
        const scrollValue = window.scrollY;
    tableau.forEach((elem, index) => {
        const vitesse = 0.5; 
        gestionDefilement(elem, scrollValue, vitesse, index);
    });
};

window.addEventListener('scroll', envoi);