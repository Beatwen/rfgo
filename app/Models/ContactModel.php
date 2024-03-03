<?php
namespace App\Models;
// Importer le gestionnaire de base de données.
class ContactModel
{
    public static function obtenir_champsConfig(): array
    {
        return [
            'firstname' => [
                'requis' => true,
                'minLength' => 2,
                'maxLength' => 255
            ],
            'lastname' => [
                'requis' => true,
                'minLength' => 2,
                'maxLength' => 255
            ],
            'email' => [
                'requis' => true,
                'type' => 'email'
            ],
            "message" => [
                "requis" => true,
                "minLength" => 2,
                "maxLength" => 255
            ]
        ];
    }
}
