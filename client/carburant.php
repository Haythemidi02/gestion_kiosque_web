<?php
$extra_css = ['style_carburant.css'];
$extra_js = ['script_carburant.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}

// Récupérer les produits de la catégorie 'Carburants'
$sql = "SELECT p.* 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.name = 'Carburants' AND p.status = 1 
        ORDER BY p.price ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$carburant_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="container">
                <h1>Nos Carburants de Qualité</h1>
                <p>Des carburants performants pour votre véhicule</p>
                <a href="#carburants" class="btn">Voir nos carburants</a>
            </div>
        </div>
    </section>

    <!-- Carburants Section -->
    <section class="carburants" id="carburants">
        <div class="container">
            <h2>Nos carburants</h2>
            <div class="produits-grid">
                <?php foreach ($carburant_products as $p): ?>
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

    <!-- Avantages carburants -->
    <section class="avantages-carburant">
        <div class="container">
            <h2>Les avantages EnergyFuel</h2>
            
            <div class="avantages-list">
                <div class="avantage-item">
                    <div class="avantage-number">1</div>
                    <div class="avantage-content">
                        <h3>Additifs haute performance</h3>
                        <p>Nos carburants contiennent des additifs spéciaux qui nettoient le moteur, réduisent la consommation et améliorent les performances.</p>
                    </div>
                </div>
                
                <div class="avantage-item">
                    <div class="avantage-number">2</div>
                    <div class="avantage-content">
                        <h3>Programme de fidélité</h3>
                        <p>Avec notre carte fidélité, cumulez des points à chaque plein et bénéficiez de réductions et avantages exclusifs.</p>
                    </div>
                </div>
                
                <div class="avantage-item">
                    <div class="avantage-number">3</div>
                    <div class="avantage-content">
                        <h3>Qualité certifiée</h3>
                        <p>Tous nos carburants répondent aux normes les plus strictes et sont régulièrement contrôlés pour garantir leur qualité.</p>
                    </div>
                </div>
                
                <div class="avantage-item">
                    <div class="avantage-number">4</div>
                    <div class="avantage-content">
                        <h3>Service rapide</h3>
                        <p>Nos stations sont conçues pour un service efficace, avec des pistes larges et un personnel disponible pour vous aider.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ -->
    <section class="faq">
        <div class="container">
            <h2>Questions fréquentes</h2>
            
            <div class="faq-item">
                <div class="faq-question">Quelle est la différence entre l'essence 95 et 98 ?</div>
                <div class="faq-answer">
                    <p>L'essence 98 a un indice d'octane plus élevé que le 95, ce qui la rend plus résistante à l'auto-allumage. Elle est recommandée pour les moteurs hautes performances ou turbocompressés. Notre essence 98 contient également des additifs nettoyants plus concentrés pour une meilleure protection du moteur.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Puis-je utiliser votre diesel pour mon véhicule ancien ?</div>
                <div class="faq-answer">
                    <p>Oui, notre diesel haute performance est compatible avec tous les véhicules diesel, y compris les modèles anciens. Il contient des additifs qui protègent le système d'injection et nettoient les dépôts, ce qui est particulièrement bénéfique pour les moteurs plus âgés.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Comment fonctionne la recharge électrique ?</div>
                <div class="faq-answer">
                    <p>Nos bornes de recharge rapide permettent de recharger la plupart des véhicules électriques à 80% en 30 minutes environ. Il vous suffit de brancher votre véhicule, de scanner votre carte EnergyFuel ou de payer par carte bancaire, et la recharge démarre automatiquement.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Comment obtenir la carte fidélité EnergyFuel ?</div>
                <div class="faq-answer">
                    <p>Vous pouvez demander votre carte fidélité gratuitement dans n'importe quelle station EnergyFuel en présentant une pièce d'identité. Vous pouvez également vous inscrire en ligne et recevoir votre carte par courrier sous 7 jours ou l'ajouter directement à votre application mobile.</p>
                </div>
            </div>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
