<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? "Gamer's Hub"; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="navbar-left">
            <div class="logo">Gamer's Hub</div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="nav-item <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="profil.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-item <?php echo ($currentPage == 'profil.php') ? 'active' : ''; ?>"><i class="fas fa-user"></i> Profil</a></li>
                    <li><a href="messages.php" class="nav-item <?php echo ($currentPage == 'messages.php') ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="notifications.php" class="nav-item <?php echo ($currentPage == 'notifications.php') ? 'active' : ''; ?>"><i class="fas fa-bell"></i> Notifications</a></li>
                </ul>
            </nav>
        </div>
        <div class="navbar-right">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher des gamers, jeux...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <a href="deconnexion.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </header>
    <main class="container">