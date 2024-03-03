<?php
namespace App\Controllers;
use Core\{
    CSRFToken,
    GestionVue,
};
use App\Models\{
    ConnexionModel
};

//Cette classe va gérer la connexion des utilisateurs et l'affichage de leur profil grâce à son modele : ConnexionModel
class ConnexionController
{
    private static $pageInfos = [
            'vue' => 'connexion',
            'titre' => "Page de connexion",
            'description' => "Connexion",
            'baseUrl' => BASE_URL . '/' . 'connexion' . '/'
        ];

    public static function index($pseudo = '', $pseudoError = '', $password = '', $passwordError = ''): void
    {
        $data = [
            'pseudo' => $pseudo,
            'pseudoError' => $pseudoError,
            'password' => $password,
            'passwordError' => $passwordError
        ];
        GestionVue::afficher_vue(self::$pageInfos, 'connexion', $data);
        exit();
    }
    // Vérification des champs du formulaire de connexion d'une requete POST
    public static function postRequest(): void
    {
        $pseudo = $password = '';
        $pseudoError = $passwordError = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            foreach ($_POST as $field => $value)
            {   
                if (!ConnexionModel::isCompleted($value))
                {
                    ${$field . 'Error'} = 'This field is required';
                }
                else 
                {
                    ${$field} = $value;
                }
            }
            if ($pseudoError != 'This field is required' 
                || $passwordError != 'This field is required')
            {
                    $codeActivation = ConnexionModel::generateActivationCode(); 
                    $pdo = ConnexionModel::callDataBase(); 
                    if (ConnexionModel::checkUserExists($pdo, $pseudo) == null)
                    {
                        $pseudoError = "You're not in our database, create an account.";
                        self::index($pseudo,$pseudoError);
                    }
                    else if (!ConnexionModel::checkUserPassword($pdo, $pseudo, $password))
                    {
                        $passwordError = "Not the good password !";
                        self::index($pseudo, $pseudoError, $password, $passwordError);
                    }
                    else {
                        $_SESSION['userName'] = $pseudo;
                        $user = ConnexionModel::GetFromUsers($pdo, $pseudo);
                        $_SESSION['ID'] = $user['uti_id'];
                        $_SESSION['role'] = $user['uti_role'];
                        $_SESSION['email'] = $user['uti_email'];                   
                        $_SESSION['active'] = $user['uti_compte_active'];
                        $_SESSION['csrf_token'] = CSRFToken::generateCSRFToken();
                        $cookieToken = bin2hex(random_bytes(32));
                        $pdo = ConnexionModel::callDataBase();
                        $_POST['rememberMe'] ? ConnexionModel::rememberme($pseudo, $cookieToken, $pdo) : ConnexionModel::donotrememberme($pseudo, $pdo,$cookieToken);
                        header("Location: " . BASE_URL . '/');
                        exit();
                    }
            }
        }
    }

    //Page de profil avec les informations de l'utilisateur : email et pseudo
    public static function profil(): void
    {
        $pageInfos = self::$pageInfos;
        $pageInfos['titre'] = "Profil";
        $pageInfos['description'] = "Profil";
        $pageInfos['vue'] = 'connexion';
        GestionVue::afficher_vue($pageInfos, 'profil');
        exit();
    }
}
