//Ici on vient faire une API pour le formulaire de contact, on va donc faire une requête POST 
//pour envoyer les données du formulaire au serveur, 
//et il nous répond avec les éventuelles erreurs et les messages de validation.

async function request(url, requConfig)
{
    const reponse = await fetch(url, requConfig);
    if (reponse.ok)
    {
        return await reponse.text();
    }
    else
    {
        throw new Error(`La requête HTTP a échoué : ${reponse.status} ${reponse.statusText}`);
    }
}

async function submit(requeteUrl, form)
{
    const donnees = new FormData(form);
    const requeteConfig =
    {
        method: "POST",
        headers:
        {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: donnees
    };

    try
    {
        const r = await request(requeteUrl, requeteConfig);
        const data = JSON.parse(r);
        for (const field in data.accessibilite) {
                const input = form.querySelector(`input[name="${field}"]`);
                if (input) {
                    const ariaInvalid = data.accessibilite[field].includes('aria-invalid="true"');
                    input.setAttribute('aria-invalid', ariaInvalid);
                    if (ariaInvalid) {
                        input.classList.add('invalid');
                        input.classList.remove('valid')
                    } else {
                        input.classList.remove('invalid');
                        input.classList.add('valid');
                    }
                }
            }
        if (data.erreurs.count > 0) {
        }
        else {
            data.message = data.messageValidation;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        const messageElement = document.createElement('p');
        messageElement.innerHTML = data.message;
    
        // insertion du message d'erreur près de son champ
        submitButton.parentNode.insertBefore(messageElement, submitButton);
    }
    catch(e)
    { 
        console.error(`Erreur lors de l'ajout d'article : ${e.message}`);
    }
}

const url = window.location.href;
const form = document.querySelector('form#contactForm');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit(url, form);
});