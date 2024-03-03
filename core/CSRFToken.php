<?php
namespace Core;
class CSRFToken
{
    public static function generateCSRFToken(): string
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    public static function isValidCSRF(): bool
    {
        return (
            isset($_POST['csrf_token']) &&
            $_POST['csrf_token'] === $_SESSION['csrf_token']
        );
    }
}