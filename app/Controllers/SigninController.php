<?php
namespace App\Controllers;
use Core\GestionVue;
use App\Models\ConnexionModel;
class SigninController
{
    private static $pageInfos = [
            'vue' => 'connexion',
            'titre' => "Sign in",
            'description' => "Sign In",
            'baseUrl' => BASE_URL . '/' . 'signin' . '/'
        ];

    // index : Afficher la liste des utilisateurs (il s'agit de la partie chargée par défaut) :
    public static function index(?array $args = null): void
    {
        $pseudo = $email = $password = $confirmPassword = $message = '';
        $pseudoError = $emailError = $passwordError = $confirmPasswordError = '';
        //Les datas à envoyer à la vue
        $data = [
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'pseudoError' => $pseudoError,
            'emailError' => $emailError,
            'passwordError' => $passwordError,
            'confirmPasswordError' => $confirmPasswordError,
            'message' => $message
        ];
        echo $data['pseudoError'];
        GestionVue::afficher_vue(self::$pageInfos, 'signin', $data);
        exit();
    }

    //Si un GET est fait sur /logout, on déconnecte l'utilisateur et on détruit la session et les cookies;
    public static function logout(): void
    {
        echo 'deconnexion';
        setcookie("PersistantCookieSession", '', time() - 3600, '/');
        setcookie("NonPersistantCookieSession", '', time() - 3600, '/');
        session_destroy();
        header("Location: " . BASE_URL . '/');
        GestionVue::afficher_vue(self::$pageInfos, 'signin');
        exit();
    }
    // Si une méthode post est appelé, on vérifie les champs et wi ils sont bons, on les envoie à la base de données
    // Sinon on renvoie les erreurs trouvées.
    public static function signinPost():void
    {
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $pseudo = $email = $password = $confirmPassword = $message = '';
        $pseudoError = $emailError = $passwordError = $confirmPasswordError = '';

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            // On vérifie que les champs sont bien remplis pour chaque champ, sinon on ajoute un message d'erreur
            foreach ($_POST as $field => $value) {
                //On évite les attaque XSS
                $onlyHTMLValue = htmlentities($value, ENT_QUOTES, 'UTF-8');
                if (!ConnexionModel::isCompleted($onlyHTMLValue)) {
                    echo 'field vaut : ' . htmlentities($field, ENT_QUOTES, 'UTF-8');
                    ${$field . 'Error'} = 'This field is required';
                }
                else {
                    ${$field} = $value;
                }
            } 
            if (!preg_match($emailPattern,$email))
            {
                $emailError = "Veuillez vérifier votre adresse mail.";
            }
            else if ($password != $confirmPassword)
            {
                $confirmPasswordError = "Les mots de passe ne correspondent pas.";
            }
            else if ($pseudoError != 'This field is required' 
                && $emailError != 'This field is required' 
                && $password != 'This field is required'
                && $confirmPasswordError != 'This field is required')
            {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $codeActivation = ConnexionModel::generateActivationCode();
                    $pbo = ConnexionModel::callDataBase();
                    // Check if pseudo doesn't exist in database, same with email address
                    if (ConnexionModel::checkUserExists($pbo,$pseudo) == null 
                        && ConnexionModel::checkEmailExistsInDB($pbo,$email) == null)
                    {
                            $message = ConnexionModel::addValuesToDataBase($pbo,$pseudo,$email,$hashedPassword,$codeActivation);

                    }            
                    else if (ConnexionModel::checkUserExists($pbo,$pseudo) != null){
                        $pseudoError = 'This pseudo already exists in our database !';
                    }
                    else if (ConnexionModel::checkEmailExistsInDB($pbo,$email) != null)
                    {
                        $emailError = 'This email already exists in our database !';
                    }
            }
        }

        //Les datas à envoyer à la vue
        $data = [
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $confirmPassword,
            'pseudoError' => $pseudoError,
            'emailError' => $emailError,
            'passwordError' => $passwordError,
            'confirmPasswordError' => $confirmPasswordError,
            'message' => $message
        ];
        GestionVue::afficher_vue(self::$pageInfos, 'signin', $data);
        exit();
    }
}

