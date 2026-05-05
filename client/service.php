<?php
$extra_css = ['style_service.css'];
$extra_js = ['script_service.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}
?>

    <!-- Page Title -->
    <div class="page-title">
        <div class="container">
            <h1>Nos Services</h1>
            <p>Sélectionnez le service dont vous avez besoin</p>
        </div>
    </div>
    <!-- Service Details -->
    <section class="service-details container">
        <h2 class="section-title">Détails des services</h2>
        
        <!-- Lavage Auto Detail -->
        <div id="lavage-details" class="detail-card">
            <div class="detail-image" style="background-image: url(../assets/images/Cleaning.jpg)"></div>
            <div class="detail-content">
                <h3>Lavage Auto</h3>
                <p>Notre service de lavage auto propose plusieurs formules adaptées à vos besoins. Notre équipe professionnelle utilise des produits de haute qualité pour garantir un résultat impeccable.</p>
                <ul class="features-list">
                    <li>Lavage extérieur complet</li>
                    <li>Nettoyage intérieur approfondi</li>
                    <li>Traitement des jantes et pneus</li>
                    <li>Polissage et cirage</li>
                    <li>Désodorisation de l'habitacle</li>
                </ul>
                <p class="price-tag">À partir de 25€</p>
                <a href="lavage.php" class="btn">Prendre rendez-vous</a>
            </div>
        </div>
        
        <!-- Produits Detail -->
        <div id="produits-details" class="detail-card">
            <div class="detail-image" style="background-image: url(../assets/images/magasin.jpg)"></div>
            <div class="detail-content">
                <h3>Produits</h3>
                <p>Nous proposons une large gamme de produits de qualité pour l'entretien et l'amélioration des performances de votre véhicule.</p>
                <ul class="features-list">
                    <li>Huiles et lubrifiants</li>
                    <li>Produits de nettoyage</li>
                    <li>Accessoires et pièces détachées</li>
                    <li>Produits d'entretien spécialisés</li>
                    <li>Additifs pour carburant</li>
                </ul>
                <p class="price-tag">Prix variés</p>
                <a href="produit.php" class="btn">Voir notre catalogue</a>
            </div>
        </div>
        
        <!-- Carburant Detail -->
        <div id="carburant-details" class="detail-card">
            <div class="detail-image" style="background-image: url(../assets/images/carbur.jpg)"></div>
            <div class="detail-content">
                <h3>Carburant</h3>
                <p>Nos carburants de qualité supérieure sont conçus pour optimiser les performances de votre moteur tout en réduisant la consommation.</p>
                <ul class="features-list">
                    <li>Essence sans plomb 95 et 98</li>
                    <li>Diesel haute performance</li>
                    <li>Carburants additifs spéciaux</li>
                    <li>Stations de recharge électrique</li>
                    <li>Système de fidélité avec points cumulables</li>
                </ul>
                <p class="price-tag">Prix du marché</p>
                <a href="carburant.php" class="btn">Remplir le reservoir</a>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="faq-section container">
        <h2 class="section-title">Questions fréquentes</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question">Comment prendre rendez-vous pour un lavage auto ?</div>
                <div class="faq-answer">
                    <p>Vous pouvez prendre rendez-vous pour un lavage auto en ligne via notre site web, par téléphone au +216 27 312 507 ou directement à notre station.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Quels moyens de paiement acceptez-vous ?</div>
                <div class="faq-answer">
                    <p>Nous acceptons les paiements par carte bancaire, espèces et via notre application mobile. Les clients réguliers peuvent également bénéficier d'un système de facturation mensuelle.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Vos stations sont-elles ouvertes 24h/24 ?</div>
                <div class="faq-answer">
                    <p>Oui, nos stations-service sont ouvertes 24h/24 et 7j/7. Cependant, certains services comme le lavage auto et la maintenance ont des horaires spécifiques que vous pouvez consulter sur chaque station.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">Comment fonctionne votre programme de fidélité ?</div>
                <div class="faq-answer">
                    <p>Notre programme de fidélité vous permet de cumuler des points à chaque achat. Ces points peuvent ensuite être échangés contre des réductions, des lavages gratuits ou des produits de notre catalogue.</p>
                </div>
            </div>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
