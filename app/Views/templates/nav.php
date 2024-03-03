<?php
function creer_navItem(string $segmentUrl, string $nomPage): string
{
    $estPageActuelle = $_SERVER['REQUEST_URI'] === $segmentUrl;
    $classCss = $estPageActuelle ? 'active' : '';
    ob_start();?>
    <li><a class="<?=$classCss?>" href="<?=$segmentUrl?>"><?=$nomPage?></a></li>
    <?php return ob_get_clean();
}

function creer_navItems(): string
{
    return  creer_navItem(BASE_URL . '/', 'Accueil') .
            creer_navItem(BASE_URL . '/signin', 'Sign in') .
            creer_navItem(BASE_URL . '/contact', 'Contact');
}
?>