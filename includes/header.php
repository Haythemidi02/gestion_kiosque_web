<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
require_once __DIR__ . '/../core/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) . " - EnergyFuel" : "EnergyFuel - Station Service"; 
        ?>
    </title>
    <script src="../assets/js/script_time.js" defer></script>
    <?php if (isset($extra_css)): foreach ($extra_css as $css): ?>
        <link rel="stylesheet" href="../assets/css/<?php echo $css; ?>">
    <?php endforeach; endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-top">
            <div class="current-time" id="currentTime"></div>
        </div>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
            <ul>
                <li><a href="accueil.php" id="navHome">Accueil</a></li>
                <li><a href="service.php" id="navServices">Services</a></li>
                <li><a href="about_us.php" id="navAccount">About Us</a></li>
                <li>
                    <div class="user-dropdown">
                        <div class="user-icon <?php echo isset($_SESSION['email']) ? 'connected' : 'disconnected'; ?>">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['email'])): ?>
                                <a href="profile.php"><i class="fas fa-id-card"></i> Mon Profil</a>
                                <a href="../core/logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
<?php else: ?>
                                <a href="sign_in.php"><i class="fas fa-sign-in-alt"></i> Connecter</a>
                                <a href="sign_up.php"><i class="fas fa-user-plus"></i> Inscrivez-vous</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
