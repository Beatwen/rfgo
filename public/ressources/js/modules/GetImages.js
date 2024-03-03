// Préparation d'un fetch pour afficher des images, quelque soit les erreurs, les images disponibles seront affichées
function ImageLoader(URL) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = URL;
        img.onload = () => resolve(img);
        const errorMessage = 'Fail to load: ' + URL;
        img.onerror = () => reject(new Error(errorMessage));
    });
}

const imageUrls = [
    "https://iainit.cvmdev.be/assets/images/iainit-midjourney-design-robot-leonardo-da-vinci-912w.jpg",
    "https://iainit.cvmdev.be/assets/images/iainit-midjourney-recherche-de-chemin-minimaliste-912w.jpg",
    "https://iainit.cvmdev.be/assets/images/iainit-midjourney-theorie-des-jeux-912w.jpg",
    "https://iainit.cvmdev.be/assets/images/iainit-midjourney-perlimpinpin-912w.jpg",
    "https://iainit.cvmdev.be/assets/images/iainit-midjourney-etoiles-connectees-reseau-neurones-912w.jpg"
];

const imagePromises = imageUrls.map(url => ImageLoader(url));

Promise.allSettled(imagePromises)
    .then((responses) => {
        for (const response of responses) {
            if (response.status === "fulfilled") {
                document.getElementById("images").appendChild(response.value);
            } else {
                console.error(response.reason);
            }
        }
    });
