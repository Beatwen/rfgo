<?php
namespace App\Controllers;
use Core\GestionVue;
class Erreur404Controller
{
    private static $pageInfos = [
            'vue' => 'erreur404',
            'titre' => "Page d'Erreur 404",
            'description' => "Description de la page d'erreur 404..."
        ];
    public static function index(): void
    {
        header("HTTP/1.0 404 Not Found");
        GestionVue::afficher_vue(self::$pageInfos, 'index');
        exit();
    }
}