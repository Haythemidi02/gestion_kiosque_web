<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../core/admin_functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - EnergyFuel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/script_time.js" defer></script>
</head>
<body>
    <header>
        <div class="logo">Fuel<span>Admin</span></div>
        <nav>
            <ul>
                <li><a href="dashboard.php" class="<?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">Tableau de bord</a></li>
                <li><a href="../client/accueil.php" target="_blank">Site Public</a></li>
            </ul>
        </nav>
        <div class="user-dropdown">
            <div class="user-icon">👤 <?php echo htmlspecialchars($_SESSION['admin_username']); ?></div>
            <div class="dropdown-content">
                <a href="profile.php">Mon Profil</a>
                <a href="settings.php">Paramètres</a>
                <a href="../core/logout.php">Déconnexion</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="admin-header">
            <h1>Tableau de bord d'administration</h1>
            <p>Gérez votre kiosque et suivez les performances en temps réel</p>
        </div>

        <div class="admin-tabs">
            <div class="tab-header">
                <a href="dashboard.php"><button class="tab-btn <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">Tableau de Bord</button></a>
                <a href="products.php"><button class="tab-btn <?php echo $current_page === 'products' ? 'active' : ''; ?>">Produits</button></a>
                <a href="orders.php"><button class="tab-btn <?php echo $current_page === 'orders' ? 'active' : ''; ?>">Commandes</button></a>
                <a href="stats.php"><button class="tab-btn <?php echo $current_page === 'stats' ? 'active' : ''; ?>">Statistiques</button></a>
                <a href="messages.php"><button class="tab-btn <?php echo $current_page === 'messages' ? 'active' : ''; ?>">Messages</button></a>
                <a href="newsletter.php"><button class="tab-btn <?php echo $current_page === 'newsletter' ? 'active' : ''; ?>">Newsletter</button></a>
                <a href="settings.php"><button class="tab-btn <?php echo $current_page === 'settings' ? 'active' : ''; ?>">Paramètres</button></a>
            </div>
            <div class="tab-content">
                <div class="tab-pane active">
