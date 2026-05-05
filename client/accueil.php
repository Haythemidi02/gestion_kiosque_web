<?php 
$extra_css = ['style_acceuil.css'];
include '../includes/header.php'; 
?>
<!-- acceuil -->
<!--entete -->
    <section class="hero-section">
        <div class="overlay"></div>
        <div class="content">
            <h1>Bienvenue chez EnergyFuel</h1>
            <p>Connectez-vous pour accéder à nos services</p>
        </div>
    </section>
    <div id="authSection" class="container">
        <section id="service">
            <h2>Explorer nos Services pour vous</h2>
            <div class="services">
                <div class="service-item">
                    <h3>lavage professionel pour les vehicules</h3>
                    <p>produits de qualité pour une vehicule propre</p>
                </div>
                <div class="service-item">
                    <h3>produits et accessoires</h3>
                    <p>produits de qualité avec des prix raisonnable</p>
                </div>
                <div class="service-item">
                    <h3>carburant de qualité</h3>
                    <p>carburant de qualité qui offre à votre vehicule le meilleur rendement</p>
                </div>
            </div>
        </section>
        <section>
            <h2>Acceuil vocal</h2>
            <audio controls>
                <source src="../assets/images/27 févr., 16.36_.m4a" type="audio/mpeg">
                Votre navigateur ne supporte pas l'élément audio.
            </audio>
        </section>
<!-- we are the best in gas-->
        <div class="best-features">
            <div class="image-container">
                <img src="../assets/images/gas-station-8626683_1920.jpg" alt="Station-service">
            </div>
            <div class="features">
                <div class="feature">
                    <h2>Service Rapide</h2>
                    <p>Faites le plein en quelques minutes avec notre service optimisé.</p>
                </div>
                <div class="feature">
                    <h2>Carburants de Qualité</h2>
                    <p>Nous offrons des carburants premium pour améliorer la performance de votre véhicule.</p>
                </div>
                <div class="feature">
                    <h2>Ouvert 24/7</h2>
                    <p>Profitez d'un accès à nos stations à toute heure du jour et de la nuit.</p>
                </div>
            </div>
        </div>
<!-- we are the best in lavage-->
        <div class="best-features">
            <div class="features">
                <div class="feature">
                    <h2>Nettoyage Professionnel</h2>
                    <p>Confiez le lavage de votre véhicule à nos experts pour un résultat impeccable.</p>
                </div>
                <div class="feature">
                    <h2>Produits de Qualité</h2>
                    <p>Nous utilisons des produits de nettoyage de qualité pour protéger votre véhicule.</p>
                </div>
                <div class="feature">
                    <h2>Service Personnalisé</h2>
                    <p>Nos équipes sont à votre écoute pour répondre à vos besoins spécifiques.</p>
                </div>
            </div>
            <div class="image-container">
                <img src="../assets/images/car-wash-1619823_1920.jpg" alt="Lavage-auto">
            </div>
        </div>
<!-- plus d'infos -->
        <section id="more-info">
            <h2>Rejoignez-nous pour des avantages exclusifs</h2>
        </section>
    </div>
<!--our team  -->
<section class="testimonials">
    <h1>voici notre équipe</h1>
    <p>cette équipe fait tous pour vous offrir les meilleurs services 24/7</p>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <img src="../assets/images/1000167349.jpg" alt="Author 1" class="author-image">
                <h2>Amine Harrabi</h2>
                <p>Gérant de la Station</p>
                <p><strong>Passionné </strong>par le secteur de l’énergie, Amine supervise les opérations quotidiennes de la station. Avec plus de 10 ans d'expérience, il s'assure que chaque service — du ravitaillement au lavage auto — fonctionne efficacement et offre une expérience client irréprochable.</p>
            </div>
            <div class="testimonial-card">
                <img src="../assets/images/1000167348.jpg" alt="Author 2" class="author-image">
                <h2>Ilyess Saddi</h2>
                <p>Responsable des Services Clients</p>
                <p><strong>Expert </strong> en relation client, Ilyess est le visage accueillant de la station. il gère les réservations, les paiements et le suivi des clients fidèles. Son objectif ? Offrir un service personnalisé et rapide à chaque visite.</p>
            </div>
            <div class="testimonial-card">
                <img src="../assets/images/1000167346.jpg" alt="Author 3" class="author-image">
                <h2>Haythem Idi</h2>
                <p>Chef des Opérations Techniques</p>
                <p><strong>Spécialiste </strong> des infrastructures énergétiques, Haythem s'assure que tous les équipements — pompes à carburant, bornes électriques, et installations de lavage — fonctionnent de manière optimale. Il joue un rôle clé dans la modernisation de la station.</p>
            </div>
        </div>
    </section>
<!--contact-->
<section class="contact-us">
    <h3>contacter nous aujourd'hui!</h3>
    <h1>Contacter nous</h1>
    <p>Vous avez des questions ou des commentaires ? N'hésitez
 pas à nous contacter pour obtenir plus d'informations sur nos services ou pour partager vos suggestions.</p>
    <div class="contact-details">
      <div class="contact-card">
        <i class="icon">📧</i>
        <h2>Email</h2>
        <a href="mailto:haythem.idi@ensi-uma.tn">haythem.idi@ensi-uma.tn</a>
      </div>
  
      <div class="contact-card">
        <i class="icon">📞</i>
        <h2>Phone</h2>
        <p>(+216) 27 312 507</p>
      </div>
  
      <div class="contact-card">
        <i class="icon">📍</i>
        <h2>Office</h2>
        <p>5051 moknine , monastir</p>
      </div>
    </div>
  
    <div class="newsletter">
    <h3>Abonnez-vous à notre newsletter pour les dernières mises à jour sur les nouvelles fonctionnalités et les sorties de produits.</h3>
      <form action="../core/email_handler.php?action=newsletter" method="POST" class="newsletter-form">
        <input type="email" name="email" placeholder="Enter your email" required />
        <button type="submit">Subscribe</button>
      </form>
    <p>En vous abonnant, vous acceptez notre politique de confidentialité et donnez votre consentement pour recevoir des mises à jour de notre entreprise.</p>
    </div>
  </section>
<?php include '../includes/footer.php'; ?>
