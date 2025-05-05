<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos de Nous - Station-Service</title>
    <link rel="stylesheet" href="style_about_us.css">
</head>
<body>
    <header>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
            <ul>
                <li><a href="index_acceuil.php" id="navHome">Accueil</a></li>
                <li><a href="index_service.php" id="navServices">Services</a></li>
                <li><a href="index_classement.php" id="navLeaderboard">Classement</a></li>
                <li><a href="index_about_us.php" id="navAccount">about us</a></li>
                <li>
                    <div class="user-dropdown">
                        <div class="user-icon">
                            <i class="fas fa-user"></i>
                            <?php if (isset($_SESSION['email'])): ?>
                                <?php echo htmlspecialchars($_SESSION['email']); ?>
                            <?php else: ?>
                                😊😊
                            <?php endif; ?>
                        </div>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['email'])): ?>
                                <a href="logout.php">Se déconnecter</a>
                            <?php else: ?>
                                <a href="index_sign_in.php">Connecter</a>
                                <a href="index_sign_up.php">Inscrivez-vous</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <section class="about"></section>
        <div class="container">
            <h2>Notre Histoire</h2>
            <p>Depuis plus de 20 ans, notre station-service fournit du carburant de qualité et des services exceptionnels aux automobilistes en Tunisie.</p>
            <h2>Présentation</h2>
            <p>La Société Nationale de Distribution des Pétroles  EnergyFuel S.A. est une entreprise publique ayant pour mission la commercialisation des produits pétroliers et de leurs dérivés sous le label EnergyFuel. Elle fait partie des grandes entreprises publiques tunisiennes qui, par leur dynamisme et la diversité de leurs activités, soutiennent l'économie nationale et lui assurent une croissance continue. Avec un chiffre d'affaires HT de 1 845 millions de dinars en 2020, EnergyFuel S.A. joue un rôle d'avant-garde sur la voie du progrès et de l'excellence dans laquelle s'est engagée la Tunisie de l'ère nouvelle.</p>
            <p>En développant ses activités, EnergyFuel S.A. a fini par occuper la première place parmi les entreprises du secteur, tant par le volume de ses ventes que par l'importance de son chiffre d'affaires et le savoir-faire de ses ressources humaines et s'emploie constamment à consolider cette position en offrant à ses clients la meilleure qualité de produit et de service.</p>
            <p>EnergyFuel S.A. est présente partout à travers ses 216 stations-service réparties sur tout le territoire tunisien, ses 54 stations portuaires et ses 6 dépôts aéroportuaires.</p>
            <h2>Dates Clés</h2>
            <ul>
                <li>1960 : Création de la société internationale AGIP S.A. Tunisie par le groupe italien ENI.</li>
                <li>1963 : Acquisition de 50 % du capital de la société AGIP S.A. Tunisie par l'État tunisien.</li>
                <li>1975 : Achat du reste du capital de la société AGIP S.A. par l'État tunisien.</li>
                <li>1977 : Changement du nom et du statut d'AGIP S.A. pour devenir « la Société Nationale de Distribution des Pétroles ».</li>
                <li>2000 : La Société Nationale de Distribution des Pétroles devient une société anonyme.</li>
            </ul>
            <h2>Chiffres Clés au 31/12/2020</h2>
            <ul>
                <li>Chiffre d'affaires : 1 845 Millions DT HT</li>
                <li>Effectif : 1 125</li>
                <li>Nombre de stations-service : 210</li>
                <li>Nombre de stations portuaires : 54</li>
            </ul>
            <h2>Notre Kiosque</h2>
            <video  controls autoplay loop class="kiosk-video">
                <source src="3727446-hd_1920_1080_30fps.mp4" type="video/mp4">
            </video>
        </div>
    </section>
    <section class="services">
        <div class="container">
            <h2>Nos Services</h2>
            <ul>
                <li>Carburant de haute qualité (Essence, Diesel, Bioéthanol)</li>
                <li>Recharge pour véhicules électriques</li>
                <li>Entretien rapide (pression des pneus, huile, etc.)</li>
                <li>Magasin et restauration rapide</li>
            </ul>
        </div>
    </section>
    <section class="sustainability">
        <div class="container">
            <h2>Engagement Écologique</h2>
            <p>Nous investissons dans des carburants plus propres et des technologies respectueuses de l'environnement.</p>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 EnergyFuel. Tous droits réservés.</p>
        <p>Adresse : 5051 Moknine, Monastir</p>
        <p>Téléphone : (+216) 27 312 507 | Email : haythem.idi@ensi-uma.tn</p>
    </footer>
</body>
</html>
