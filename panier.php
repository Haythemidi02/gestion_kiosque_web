<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index_sign_in.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - EnergyFuel</title>
    <link rel="stylesheet" href="style_sign.css">
    <script src="script_panier.js" defer></script>
</head>
<body>
    <header>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
        <ul>
            <li><a href="index_acceuil.php">Accueil</a></li>
            <li><a href="index_service.php">Services</a></li>
            <li><a href="index_classement.php">Classement</a></li>
            <li><a href="index_about_us.php">À propos</a></li>
            <li>
                <div class="user-dropdown">
                <div class="user-icon <?php echo isset($_SESSION['email']) ? 'connected' : 'disconnected'; ?>">
                    <i class="fas fa-user"></i>
                </div>
                <div class="dropdown-content">
                        <?php if (isset($_SESSION['email'])): ?>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
                        <?php else: ?>
                            <a href="index_sign_in.php"><i class="fas fa-sign-in-alt"></i> Connecter</a>
                            <a href="index_sign_up.php"><i class="fas fa-user-plus"></i> Inscrivez-vous</a>
                        <?php endif; ?>
                </div>
                /div>
            </li>
            <li>
                <a href="panier.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-badge">0</span>
                </a>
            </li>
        </ul>
        </nav>
    </header>
    <div id="authSection" class="container">
        <h2>Votre Panier</h2>
        <p id="emptyMessage" style="display: none;">Votre panier est vide.</p>
        <div id="cartSection" style="display: none;">
            <table id="cartTable" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <!-- Rows will be dynamically generated -->
            </table>
            <p><strong>Total :</strong> <span id="total">0.00 €</span></p>
            <button id="clearCart">Vider le panier</button>
            <a href="index_paiement.php" id="payButton" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Payer</a>
        </div>
    </div>
    <footer class="minimised">
        <p>© 2025 EnergyFuel. Tous droits réservés.</p>
        <p>Adresse : 5051 Moknine, Monastir</p>
        <p>Téléphone : (+216) 27 312 507 | Email : haythem.idi@ensi-uma.tn</p>
    </footer>
</body>
</html>