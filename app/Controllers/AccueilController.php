<?php
namespace App\Controllers;
use Core\GestionVue;

//Contrôleur de la page d'accueil
class AccueilController
{
    private static $pageInfos = [
            'vue' => 'accueil',
            'titre' => "Page d'Accueil",
            'description' => "Description de la page d'accueil...",
            'baseUrl' => BASE_URL . '/'
        ];
    public static function index(): void
    {
        GestionVue::afficher_vue(self::$pageInfos, 'index');
    }
}
