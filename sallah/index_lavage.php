<?php
require_once 'config.php';

// Requête SQL pour récupérer les produits de la catégorie "Lavage"
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE c.name = 'Lavage auto' AND p.status = 1
        ORDER BY p.name ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$lavage_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnergyFuel - Service de Lavage Auto</title>
    <link rel="stylesheet" href="style_lavage.css">
    <script src="script_lavage.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <a href="index.php"><span>Energy</span><span>Fuel</span></a>
            </div>
            <nav>
                <ul>
                    <li><a href="index_acceuil.php">Accueil</a></li>
                    <li><a href="index_service.php">Services</a></li>
                    <li><a href="index_classement.php">Classement</a></li>
                    <li><a href="index_about_us.php">À propos</a></li>
                    <li>
                        <a href="panier.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cart-badge">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="container">
                <h1>Service de Lavage Auto Premium</h1>
                <p>Redonnez à votre véhicule son éclat d'origine avec nos formules de lavage professionnel</p>
                <a href="#lavage-products" class="btn">Voir nos formules</a>
            </div>
        </div>
    </section>

    <!-- Produits de Lavage -->
    <section class="produits-lavage" id="lavage-products">
        <div class="container">
            <h2>Nos formules de lavage</h2>
            <div class="produits-grid">
                <?php foreach ($lavage_products as $product): ?>
                    <div class="produit-card">
                        <?php if ($product['discount'] > 0): ?>
                            <div class="produit-badge">Promo</div>
                        <?php endif; ?>
                        
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="produit-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="produit-desc"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="produit-footer">
                                <?php if ($product['discount'] > 0): ?>
                                    <?php
                                    $prixPromo = $product['price'] * (1 - $product['discount'] / 100);
                                    ?>
                                    <span class="prix-promo"><?= number_format($prixPromo, 2, ',', ' ') ?> €</span>
                                    <span class="prix-ancien"><?= number_format($product['price'], 2, ',', ' ') ?> €</span>
                                <?php else: ?>
                                    <span class="prix"><?= number_format($product['price'], 2, ',', ' ') ?> €</span>
                                <?php endif; ?>
                                <a href="#" class="btn-ajouter add-to-cart"
                                   data-product-id="<?= $product['id'] ?>"
                                   data-product-name="<?= htmlspecialchars($product['name']) ?>"
                                   data-product-price="<?= number_format($product['price'], 2) ?>">
                                    <i class="fas fa-cart-plus"></i> Réserver
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 EnergyFuel. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>