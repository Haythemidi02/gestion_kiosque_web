<?php
$extra_css = ['style_about_us.css'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}
?>
    <section class="about-hero" style="background-image: url(../assets/images/gas-station-8626683_1920.jpg); background-size: cover; background-position: center; height: 300px; position: relative;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; color: white; text-align: center;">
            <h1>À Propos de Nous</h1>
        </div>
    </section>

    <section class="about-content">
        <div class="container">
            <h2>Notre Histoire</h2>
            <p>Depuis plus de 20 ans, notre station-service fournit du carburant de qualité et des services exceptionnels aux automobilistes en Tunisie.</p>
            
            <h2>Présentation</h2>
            <p>La Société Nationale de Distribution des Pétroles <strong>EnergyFuel S.A.</strong> est une entreprise publique ayant pour mission la commercialisation des produits pétroliers et de leurs dérivés sous le label EnergyFuel. Elle fait partie des grandes entreprises publiques tunisiennes qui, par leur dynamisme et la diversité de leurs activités, soutiennent l'économie nationale et lui assurent une croissance continue.</p>
            <p>En développant ses activités, EnergyFuel S.A. a fini par occuper la première place parmi les entreprises du secteur, tant par le volume de ses ventes que par l'importance de son chiffre d'affaires et le savoir-faire de ses ressources humaines.</p>
            <p>EnergyFuel S.A. est présente partout à travers ses 216 stations-service réparties sur tout le territoire tunisien, ses 54 stations portuaires et ses 6 dépôts aéroportuaires.</p>
            
            <h2>Dates Clés</h2>
            <div class="timeline">
                <ul>
                    <li><strong>1960</strong> : Création de la société internationale AGIP S.A. Tunisie par le groupe italien ENI.</li>
                    <li><strong>1963</strong> : Acquisition de 50 % du capital de la société AGIP S.A. Tunisie par l'État tunisien.</li>
                    <li><strong>1975</strong> : Achat du reste du capital de la société AGIP S.A. par l'État tunisien.</li>
                    <li><strong>1977</strong> : Changement du nom et du statut d'AGIP S.A. pour devenir « la Société Nationale de Distribution des Pétroles ».</li>
                    <li><strong>2000</strong> : La Société Nationale de Distribution des Pétroles devient une société anonyme.</li>
                </ul>
            </div>

            <h2>Chiffres Clés (2020)</h2>
            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <div class="stat-item" style="padding: 1.5rem; background: #f9f9f9; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b00;">1 845 M</div>
                    <p>Chiffre d'affaires (DT)</p>
                </div>
                <div class="stat-item" style="padding: 1.5rem; background: #f9f9f9; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b00;">1 125</div>
                    <p>Effectif</p>
                </div>
                <div class="stat-item" style="padding: 1.5rem; background: #f9f9f9; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b00;">210</div>
                    <p>Stations-service</p>
                </div>
                <div class="stat-item" style="padding: 1.5rem; background: #f9f9f9; border-radius: 8px; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b00;">54</div>
                    <p>Stations portuaires</p>
                </div>
            </div>

            <h2>Notre Kiosque</h2>
            <video controls autoplay loop class="kiosk-video" style="width: 100%; border-radius: 12px; margin-bottom: 2rem;">
                <source src="../assets/images/3727446-hd_1920_1080_30fps.mp4" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        </div>
    </section>

    <section class="hours-section" style="background: #f4f4f4; padding: 3rem 0;">
        <div class="container">
            <h2>Nos horaires d'ouverture</h2>
            <div class="opening-hours">
                <?php
                $days = [
                    'Lundi' => 'hours_monday',
                    'Mardi' => 'hours_tuesday',
                    'Mercredi' => 'hours_wednesday',
                    'Jeudi' => 'hours_thursday',
                    'Vendredi' => 'hours_friday',
                    'Samedi' => 'hours_saturday',
                    'Dimanche' => 'hours_sunday'
                ];
                foreach ($days as $label => $key): 
                    $hours = getSetting($key, $label === 'Dimanche' ? 'Fermé' : '08:00-18:00');
                ?>
                <div class="opening-day <?php echo ($hours === 'Fermé') ? 'closed' : ''; ?>" style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #ddd;">
                    <span class="day"><?php echo $label; ?></span>
                    <span class="hours"><?php echo $hours; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="opening-notes" style="margin-top: 1rem; font-style: italic; color: #666;">
                <p><?php echo getSetting('opening_special_notes', 'Service de carburant disponible 24/7'); ?></p>
            </div>
        </div>
    </section>

    <section class="sustainability" style="padding: 3rem 0;">
        <div class="container">
            <h2>Engagement Écologique</h2>
            <p>Nous investissons dans des carburants plus propres et des technologies respectueuses de l'environnement pour assurer un avenir durable.</p>
        </div>
    </section>

<?php include '../includes/footer.php'; ?>
