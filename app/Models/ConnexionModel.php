<?php
namespace App\Models;
class ConnexionModel
{
    public static function isCompleted($field)
    {
        return isset($field) && !empty($field);
    }
    public static function generateActivationCode()
    {
        $activationCode = "";
        for ($i=0; $i < 5; $i++) { 
            $activationCode .= rand(0,9);
        }
        return $activationCode;
    }
    public static function callDataBase()
    {

                $nomDuServeur = 'localhost';
                $nomUtilisateur = 'root';
                $motDePasse = '';
                $nomBDD = "rf_gousers";


                try
                {
                    $pdo = new \PDO("mysql:host=$nomDuServeur;dbname=$nomBDD", $nomUtilisateur, $motDePasse);
                    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    return $pdo;
                }
                catch(\PDOException $e)
                {
                    echo 'Erreur : ' . $e->getMessage();
                }
    }
    public static function addValuesToDataBase($pdo, $pseudo,$email,$hashedPassword,$codeActivation){

        $requete = "INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email,uti_motdepasse,uti_role,uti_compte_active,uti_code_activation) 
                    VALUES (:pseudo, :email,:hashedPassword,1,1,:codeActivation)";

        // Préparer la requête SQL :
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':codeActivation', $codeActivation);

        // Exécuter la requête et vérifier et agir en fonction de sa réponse (true ou false) :
        if ($stmt->execute())
        {
            return "Enregistrement créé avec succès.";
        }
        else
        {
            return "Erreur lors de la création de l'enregistrement.";
        }
    }
    public static function addCookieToDatabase($pseudo,$uti_cookie_token, $pdo){

        $requete = "UPDATE t_utilisateur_uti
                    SET uti_cookie_token = :uti_cookie_token
                    WHERE uti_pseudo = :pseudo";


        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':uti_cookie_token', $uti_cookie_token);
        $stmt->bindParam(':pseudo', $pseudo);


        if ($stmt->execute())
        {
            return "Enregistrement créé avec succès.";
        }
        else
        {
            return "Erreur lors de la création de l'enregistrement.";
        }
    }
    public static function checkEmailExistsInDB($pdo, $email){
        $requete = "SELECT uti_email FROM t_utilisateur_uti WHERE uti_email = :email";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $fetchMail = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $fetchMail;
    }
    public static function checkUserExists($pdo,$pseudo)
    {
        $requete = "SELECT uti_pseudo FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $utilisateur = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $utilisateur;
    }
    public static function GetFromUsers($pdo,$pseudo)
    {
        $requete = "SELECT * FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }
    public static function checkUserPassword($pdo, $pseudo,$password)
    {
        $requete = "SELECT uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $pw = $stmt->fetch(\PDO::FETCH_ASSOC);
        return password_verify($password,$pw['uti_motdepasse'] );
    }
    public static function findCookietoken($pdo,$pseudo)
    {
        $requete = "SELECT uti_cookie_token FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $cookieToken = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $cookieToken;
    }
    public static function findUserByCookie($pdo,$cookieToken)
    {
        $requete = "SELECT uti_pseudo FROM t_utilisateur_uti WHERE uti_cookie_token = :cookieToken";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':cookieToken', $cookieToken);
        $stmt->execute();
        $pseudo = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $pseudo["uti_pseudo"];
    }
    public static function deleteCookieToken($pdo,$pseudo)
    {
        $requete = "UPDATE t_utilisateur_uti
                    SET uti_cookie_token = NULL
                    WHERE uti_pseudo = :pseudo";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
    }
    public static function rememberme($pseudo, $cookieToken, $pdo)
    {
        $cookieToken = bin2hex(random_bytes(32));
        self::addCookieToDatabase($pseudo, $cookieToken, $pdo);
        setcookie("PersistantCookieSession",$cookieToken, time() + 86400 * 30, '/',false,true);
    }
    public static function donotrememberme($pseudo, $pdo, $cookieToken)
    {
        setcookie("NonPersistantCookieSession",$cookieToken, 0,'/',false,true);
    }
    public static function cookieChecker()
    {
        if (isset($_COOKIE['PersistantCookieSession']))
        {
            $pdo = self::callDataBase();
            $cookieToken = $_COOKIE['PersistantCookieSession'];
            $pseudo = self::findUserByCookie($pdo,$cookieToken);

            $_SESSION['userName'] = $pseudo;
            $_SESSION['email'] = self::GetFromUsers($pdo, $pseudo)['uti_email'];
            

        }
    }
}
