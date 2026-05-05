<?php
$extra_css = ['style_lavage.css'];
$extra_js = ['script_lavage.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}

// Récupérer les produits de la catégorie 'Lavage auto'
$sql = "SELECT p.* 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.name = 'Lavage auto' AND p.status = 1 
        ORDER BY p.price ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$lavage_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="container">
                <h1>Service de Lavage Auto Premium</h1>
                <p>Redonnez à votre véhicule son éclat d'origine avec nos formules de lavage professionnel</p>
                <a href="#formules" class="btn">Découvrir nos formules</a>
            </div>
        </div>
    </section>

    <!-- Service Details Section -->
    <section class="service-details">
        <div class="container">
            <div class="service-intro">
                <h2>Pourquoi choisir notre service de lavage auto ?</h2>
                <p>Chez EnergyFuel, nous utilisons des techniques de lavage avancées et des produits de haute qualité pour garantir un résultat impeccable. Notre équipe de professionnels prend soin de votre véhicule comme s'il s'agissait du leur, en accordant une attention particulière à chaque détail.</p>
            </div>
        </div>
    </section>

    <!-- Formules Section (dynamique) -->
    <section class="formules" id="formules">
        <div class="container">
            <h2>Nos formules de lavage</h2>
            <div class="produits-grid">
                <?php foreach ($lavage_products as $p): ?>
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
    <!-- Process Section -->
    <section class="process">
        <div class="container">
            <h2>Notre processus de lavage</h2>
            <div class="process-steps">
                <!-- Step 1 -->
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Pré-lavage</h3>
                    <p>Application d'un produit dégraissant pour éliminer les saletés tenaces et préserver la peinture lors du lavage principal.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Lavage principal</h3>
                    <p>Lavage en profondeur avec des produits de qualité et des techniques douces pour protéger la carrosserie.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Traitement spécifique</h3>
                    <p>Nettoyage des jantes, traitement des plastiques et des vitres pour un résultat impeccable.</p>
                </div>
                
                <!-- Step 4 -->
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Finition</h3>
                    <p>Séchage minutieux, polissage et application de produits de protection pour un éclat durable.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>Ce que disent nos clients</h2>
            <div class="testimonial-cards">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>Service impeccable ! Ma voiture n'a jamais été aussi propre. Je recommande la formule Premium qui offre un excellent rapport qualité-prix.</p>
                    </div>
                    <div class="client-info">
                        <img src="../assets/images/user.jpg" alt="Client">
                        <div class="client-name">
                            <h4>Sophie Martin</h4>
                            <p>Cliente fidèle</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>J'ai opté pour la formule Deluxe pour mon SUV qui avait grand besoin d'un rafraîchissement. Résultat bluffant, comme neuf !</p>
                    </div>
                    <div class="client-info">
                        <img src="../assets/images/user.jpg" alt="Client">
                        <div class="client-name">
                            <h4>Thomas Dubois</h4>
                            <p>Client régulier</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        <p>Personnel très professionnel et attentif aux détails. Le service est rapide mais sans compromis sur la qualité. Je reviendrai !</p>
                    </div>
                    <div class="client-info">
                        <img src="../assets/images/user.jpg" alt="Client">
                        <div class="client-name">
                            <h4>Émilie Rousseau</h4>
                            <p>Nouvelle cliente</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <h2>Questions fréquentes</h2>
            
            <div class="faq-item">
                <div class="faq-question">Combien de temps dure un lavage complet ?</div>
                <div class="faq-answer">
                    <p>La durée varie selon la formule choisie. Comptez environ 30 minutes pour la formule Basique, 1 heure pour la formule Premium et 1h30 à 2h pour la formule Deluxe. Nous vous conseillons de réserver à l'avance pour garantir votre créneau.</p>
                </div>
            </div> 
            
            <div class="faq-item">
                <div class="faq-question">Quels types de véhicules acceptez-vous ?</div>
                <div class="faq-answer">
                    <p>Nous traitons tous les types de véhicules : citadines, berlines, SUV, 4x4, utilitaires et même camping-cars (avec supplément pour les grands véhicules). N'hésitez pas à nous contacter pour connaître les tarifs spécifiques.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Utilisez-vous des produits écologiques ?</div>
                <div class="faq-answer">
                    <p>Oui, nous utilisons principalement des produits biodégradables et respectueux de l'environnement. Notre station de lavage est également équipée d'un système de récupération et de filtration de l'eau pour limiter notre impact environnemental.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Puis-je attendre pendant que ma voiture est lavée ?</div>
                <div class="faq-answer">
                    <p>Absolument ! Nous disposons d'un espace d'attente confortable avec WiFi gratuit, boissons chaudes et magazines. Vous pouvez également profiter de notre espace boutique pour découvrir nos produits d'entretien automobile.</p>
                </div>
            </div>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
