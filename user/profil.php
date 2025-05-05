<?php
// index_profile.php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index_sign_in.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=kiosque", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT nom, email, type_vehicule, immatriculation FROM users WHERE email = ?");
    $stmt->execute([$_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnergyFuel - Mon Compte</title>
    <link rel="stylesheet" href="style_sign.css">
</head>
<body>
    <header>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
            <ul>
                <li><a href="index_acceuil.php">Accueil</a></li>
                <li><a href="index_service.php">Services</a></li>
                <li><a href="index_cart.php">Panier</a></li>
                <li><a href="index_profile.php">Mon Compte</a></li>
                <li><a href="index_sign_in.php?logout=1">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Mon Compte</h2>
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Type de véhicule :</strong> <?php echo htmlspecialchars($user['type_vehicule']); ?></p>
        <p><strong>Immatriculation :</strong> <?php echo htmlspecialchars($user['immatriculation']); ?></p>
    </div>
    <footer class="minimised">
        <p>© 2025 EnergyFuel. Tous droits réservés.</p>
        <p>Adresse : 5051 Moknine, Monastir</p>
        <p>Téléphone : (+216) 27 312 507 | Email : haythem.idi@ensi-uma.tn</p>
    </footer>
</body>
</html>