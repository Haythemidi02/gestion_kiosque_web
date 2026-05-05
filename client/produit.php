<?php
$extra_css = ['style_produit.css'];
$extra_js = ['script_produit.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}

// Récupérer les produits des catégories autres que 'Lavage auto' et 'Carburants'
$sql = "SELECT p.* 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.name NOT IN ('Lavage auto', 'Carburants') AND p.status = 1 
        ORDER BY p.price ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="container">
                <h1>Nos Produits d'Entretien</h1>
                <p>Découvrez notre gamme de produits pour votre véhicule</p>
                <a href="#produits-phares" class="btn">Voir les produits</a>
            </div>
        </div>
    </section>

    <!-- Produits Phares Section -->
    <section class="produits-phares" id="produits-phares">
        <div class="container">
            <h2>Nos produits phares</h2>
            <div class="produits-grid">
                <?php foreach ($top_products as $p): ?>
                    <div class="produit-card">
                        <?php if ($p['discount'] > 0): ?>
                            <div class="produit-badge">Promo</div>
                        <?php endif; ?>
                        <img src="../assets/images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                        <div class="produit-info">
                            <h3><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="produit-desc"><?= htmlspecialchars($p['description']) ?></p>
                            <div class="produit-footer">
                                <?php if ($p['discount'] > 0): ?>
                                    <?php $prixPromo = $p['price'] * (1 - $p['discount'] / 100); ?>
                                    <span class="prix-promo"><?= number_format($prixPromo, 2, ',', ' ') ?> €</span>
                                    <span class="prix-ancien"><?= number_format($p['price'], 2, ',', ' ') ?> €</span>
                                <?php else: ?>
                                    <span class="prix"><?= number_format($p['price'], 2, ',', ' ') ?> €</span>
                                <?php endif; ?>
                                <a href="#" class="btn-ajouter add-to-cart"
                                   data-product-id="<?= $p['id'] ?>"
                                   data-product-name="<?= htmlspecialchars($p['name']) ?>"
                                   data-product-price="<?= number_format($p['discount'] > 0 ? $prixPromo : $p['price'], 2) ?>">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <h2>Questions fréquentes sur nos produits</h2>
            
            <div class="faq-item">
                <div class="faq-question">Comment choisir la bonne huile moteur pour mon véhicule ?</div>
                <div class="faq-answer">
                    <p>Consultez toujours le manuel du propriétaire de votre véhicule pour connaître la viscosité et les spécifications recommandées par le constructeur. Notre équipe peut également vous conseiller en fonction de l'âge, du kilométrage et des conditions d'utilisation de votre véhicule.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Vos produits sont-ils compatibles avec tous les véhicules ?</div>
                <div class="faq-answer">
                    <p>La plupart de nos produits sont conçus pour une large gamme de véhicules. Pour les produits spécifiques (comme les huiles pour voitures de collection ou les nettoyants pour surfaces spéciales), nous indiquons clairement les compatibilités sur l'emballage.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Proposez-vous des produits écologiques ?</div>
                <div class="faq-answer">
                    <p>Oui, nous avons une gamme de produits biodégradables et respectueux de l'environnement, identifiés par notre logo "Eco-Friendly". Ces produits offrent des performances similaires tout en réduisant l'impact environnemental.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Quelle est votre politique de retour pour les produits ?</div>
                <div class="faq-answer">
                    <p>Nous acceptons les retours de produits non ouverts dans les 30 jours suivant l'achat, avec preuve d'achat. Les produits d'hygiène et les produits chimiques ouverts ne peuvent être repris pour des raisons de sécurité.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Avantages Section -->
    <section class="avantages">
        <div class="container">
            <h2>Pourquoi choisir nos produits ?</h2>
            
            <div class="avantages-grid">
                <div class="avantage-item">
                    <i class="fas fa-check-circle"></i>
                    <h3>Qualité certifiée</h3>
                    <p>Tous nos produits répondent aux normes les plus strictes des fabricants automobiles.</p>
                </div>
                
                <div class="avantage-item">
                    <i class="fas fa-truck"></i>
                    <h3>Livraison rapide</h3>
                    <p>Commandez avant 14h et recevez vos produits le lendemain en point relais.</p>
                </div>
                
                <div class="avantage-item">
                    <i class="fas fa-leaf"></i>
                    <h3>Respect de l'environnement</h3>
                    <p>Nous privilégions les produits écologiques et biodégradables.</p>
                </div>
                
                <div class="avantage-item">
                    <i class="fas fa-headset"></i>
                    <h3>Conseils experts</h3>
                    <p>Notre équipe est à votre disposition pour vous guider dans vos choix.</p>
                </div>
            </div>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
