<?php
// panier.php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=kiosque", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;

if ($cart) {
    $ids = implode(',', array_keys($cart));
    $stmt = $pdo->query("SELECT id, name, price FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        $total += $product['price'] * $cart[$product['id']];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
    foreach ($cart as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $price = $stmt->fetchColumn();
        $total_price = $price * $quantity;
        $stmt = $pdo->prepare("INSERT INTO purchases (user_email, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['email'], $product_id, $quantity, $total_price]);
    }
    unset($_SESSION['cart']);
    $message = "Achat confirmé ! Merci.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    header("Location: panier.php");
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
</head>
<body>
    <header>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="service.php">Services</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li><a href="profil.php">Mon Compte</a></li>
                <li><a href="sign_in.php?logout=1">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Votre Panier</h2>
        <?php if (isset($message)): ?>
            <p style="color: green; text-align: center;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if (empty($cart)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <form method="POST">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?> TND</td>
                            <td><input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $cart[$product['id']]; ?>" min="0"></td>
                            <td><?php echo $product['price'] * $cart[$product['id']]; ?> TND</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p><strong>Total :</strong> <?php echo $total; ?> TND</p>
                <button type="submit" name="update_cart" class="btn btn-block">Mettre à jour</button>
                <button type="submit" name="confirm_purchase" class="btn btn-block">Confirmer l'achat</button>
            </form>
        <?php endif; ?>
    </div>
    <footer class="minimised">
        <p>© 2025 EnergyFuel. Tous droits réservés.</p>
        <p>Adresse : 5051 Moknine, Monastir</p>
        <p>Téléphone : (+216) 27 312 507 | Email : haythem.idi@ensi-uma.tn</p>
    </footer>
</body>
</html>
