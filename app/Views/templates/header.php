<?php
// Importer la navigation principale.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'nav.php';
$nav = creer_navItems();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$metaDescription ?? '' ?>">
    <link rel="stylesheet" href="<?=BASE_URL?>/public/ressources/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <?php if (isset($pageInfos['action']) && $pageInfos['action'] == 'contact'): ?>
    <link rel="stylesheet" href="<?=BASE_URL?>/public/ressources/css/contact.css">
    <?php endif; ?> 
    <title><?=$pageTitre ?? ''?></title>
</head>
<body>
    <header>
        <nav>
            <div id="menuToggle">
                <button class="btnMenu" aria-label="afficher le menu" aria-expanded="true" aria-controls="menu" >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <ul id="menu">
                <?= $nav; ?>
            </ul>
            <div class="fixed-right">
                <?php if (isset($_SESSION['userName'])): ?>
                    <div id="userName">
                        <?php echo "Welcome " . $_SESSION['userName']; ?>
                    </div>
                    <div id="logout">
                        <a href="<?= BASE_URL ?>/logout">Log Out</a>
                    </div>
                    <div>
                        <a href ="<?= BASE_URL ?>/profil"><i class="fas fa-user"></i></a>
                    </div>
                <?php else: ?>
                    <div>
                        <a href="<?= BASE_URL ?>/connexion">Connexion</a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

    </header>
    <main>

