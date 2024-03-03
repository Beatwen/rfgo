<?php
namespace App\Controllers;
use Core\{
    GestionVue,
    GestionMessage,
    GestionFormulaire
};
use App\Models\{
    ContactModel
};
//Cette classe va gérer le formulaire de contact via son modele : ContactModel
class ContactController
{
    private static $pageInfos = [
            'vue' => 'contact',
            'titre' => "Page de contact",
            'description' => "Contact",
            'baseUrl' => BASE_URL . '/' . 'contact' . '/',
            'action' => 'contact'
        ];
// méthode de base qui affiche la vue contact
    public static function index($message = null): void
    {
        $pageInfos = self::$pageInfos;
        if ($message) {
            $pageInfos['message'] = $message;
        }
        // Afficher la vue "vue_accueil.php".
        GestionVue::afficher_vue(self::$pageInfos, 'contact');
                exit();
    }

//Cette méthode est appelée via le formulaire en async, elle vérifie la validité des champs et envoie un email si tout est ok
    public static function checkForm(): void
    {
        // Vérifier la validité des entrées utilisateurs.
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
            && isset($_SERVER['HTTP_ORIGIN'])
            && $_SERVER['HTTP_ORIGIN'] === 'http://' . $_SERVER['HTTP_HOST']
        ) 
        {
            //html entities est fait ici dessous
            $resultat = GestionFormulaire::verifier_validiteChamps(ContactModel::obtenir_champsConfig(), $_POST);
            if (count($resultat['erreurs']) === 0) {
                $resultat['messageValidation'] = GestionMessage::obtenir_messageValidation('form', 'envoi_succes');
                ECHO $_POST['email'] . $_POST['message'] . $_POST['firstname'] . $_POST['lastname']. 'test';
                GestionMessage::sendEmail($_POST['email'], $_POST['message'], $_POST['firstname'], $_POST['lastname']);
            } else {
                $resultat['messageValidation'] = GestionMessage::obtenir_messageValidation('form', 'champs_echec', false);
            }
            
            header('Content-Type: application/json');
            echo json_encode($resultat);
            exit();
        }
    }
}
    