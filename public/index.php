<?php
use Core\{
    Routeur
};
use App\Models\{
    ConnexionModel
};
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Routeur.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Models' .DIRECTORY_SEPARATOR . 'ConnexionModel.php';
session_set_cookie_params(0, '/', '', false, true);
session_start();
// Etat de l'environnement : 'dev' en mode développement ou 'prod' en mode production.
// Ceci me permet d'utiliser des conditions pour réaliser certaines actions seulement si je suis dans un mode spécifique.
// Par exemple, dans le fichier /core/gestion_bdd.php, les erreurs ne s'afficheront dans le navigateur que si la constante ENV est configurée sur "dev".
define('ENV', 'dev');
ConnexionModel::cookieChecker();
// Chemin de base de l'application (Utile si l'application est hebergée dans un sous-dossier. Dans ce cas, n'oubliez pas d'adapter le fichier .htaccess).
// Par exemple si votre url racine est le suviant : localhost/monprojet/,
// Alors vous devrez configurer BASE_URL à '/monprojet' et dans le fichier .htacces : RewriteCond %{REQUEST_URI} !^/monprojet/public/
define('BASE_URL', '/rfgo');

// Routes :
$patterns = ['id' => '\d+'];
$routes = [
    Routeur::configurer_route('GET', '/', 'AccueilController', 'index'),
    Routeur::configurer_route('GET', '/connexion', 'ConnexionController', 'index'),
    Routeur::configurer_route('POST', '/connexion', 'ConnexionController', 'postRequest'),
    Routeur::configurer_route('GET', '/contact', 'ContactController', 'index'),
    Routeur::configurer_route('POST', '/contact', 'ContactController', 'checkForm'),
    Routeur::configurer_route('GET', '/signin', 'SigninController', 'index'),
    Routeur::configurer_route('POST', '/signin', 'SigninController', 'signinPost'),
    Routeur::configurer_route('GET', '/profil', 'ConnexionController', 'profil'),
    Routeur::configurer_route('GET', '/logout', 'SigninController', 'logout'),
    Routeur::configurer_route('GET', '/admin-gestion-utilisateur', 'AdminGestionUtilisateurController', 'index'),
    Routeur::configurer_route('DELETE', '/admin-gestion-utilisateur', 'AdminGestionUtilisateurController', 'detruire'),
    Routeur::configurer_route('GET', '/admin-gestion-utilisateur/creer', 'AdminGestionUtilisateurController', 'creer'),
    Routeur::configurer_route('POST', '/admin-gestion-utilisateur/creer', 'AdminGestionUtilisateurController', 'stocker'),
    Routeur::configurer_route('GET', '/admin-gestion-utilisateur/{id}', 'AdminGestionUtilisateurController', 'montrer'),
    Routeur::configurer_route('GET', '/admin-gestion-utilisateur/{id}/editer', 'AdminGestionUtilisateurController', 'editer'),
    Routeur::configurer_route('PUT', '/admin-gestion-utilisateur/{id}/editer', 'AdminGestionUtilisateurController', 'actualiser')
];

Routeur::demarrer_routeur($patterns);