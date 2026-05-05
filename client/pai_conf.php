<?php
$extra_css = ['style_pai_conf.css'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}
?>
    <!--confirmation de paiment-->
    <div id="confirmationSection" class="container">
        <div class="section-title">
            <div style="font-size: 5rem; color: #4CAF50; margin-bottom: 2rem;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Merci pour votre achat !</h1>
            <p>Votre transaction a été complétée avec succès</p>
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Un reçu a été envoyé à votre adresse email (<?php echo htmlspecialchars($_SESSION['email']); ?>).</p>
            <section>
                <a href="service.php" class="btn">Retour aux services</a>
                <a href="accueil.php" class="btn" style="background-color: transparent; border: 1px solid #ddd; color: #333; margin-left: 10px;">Accueil</a>
            </section>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
