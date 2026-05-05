<?php
$extra_css = ['style_sign.css'];
$extra_js = ['script_sign_in.js'];
include '../includes/header.php';

$error = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $civilite = $_POST['choice'] ?? '';
    $nom = trim($_POST['registerName'] ?? '');
    $email = filter_var($_POST['registerEmail'] ?? '', FILTER_SANITIZE_EMAIL);
    $type_vehicule = $_POST['type_vehicule'] ?? '';
    $immatriculation = trim($_POST['immatriculation'] ?? '');
    $password = trim($_POST['registerPassword'] ?? '');
    $passwordConfirm = trim($_POST['registerPasswordConfirm'] ?? '');
    $conditions = isset($_POST['conditions']);

    if (!$civilite || !$nom || !$email || !$type_vehicule || !$immatriculation || !$password || !$conditions) {
        $error = "Tous les champs obligatoires doivent être remplis.";
    } elseif ($password !== $passwordConfirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, nom, type_vehicule, immatriculation, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$email, $nom, $type_vehicule, $immatriculation, $hashedPassword]);
            $message = "Inscription réussie ! Vous pouvez vous connecter.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Cet email est déjà utilisé.";
            } else {
                $error = "Erreur : " . $e->getMessage();
            }
        }
    }
}
?>
    <div id="authSection" class="container">
        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif ($message): ?>
            <p style="color: green; text-align: center;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form class="auth-form" id="registerForm" method="POST" style="display: block;">
            <div class="form-group">
                <label for="civilite">Civilité <span class="required">*</span></label><br>
                <input type="radio" id="civilite_m" name="choice" value="M." required> <label for="civilite_m" style="display: inline;">M.</label>
                <input type="radio" id="civilite_mme" name="choice" value="Mme" required style="margin-left: 10px;"> <label for="civilite_mme" style="display: inline;">Mme</label>
            </div>
            <div class="form-group">
                <label for="registerName">Nom complet <span class="required">*</span></label>
                <input type="text" id="registerName" name="registerName" placeholder="Votre nom complet" required>
            </div>
            <div class="form-group">
                <label for="registerEmail">Email <span class="required">*</span></label>
                <input type="email" id="registerEmail" name="registerEmail" placeholder="Votre email" required>
            </div>
            <div class="form-group">
                <label for="type_vehicule">Type de véhicule <span class="required">*</span></label>
                <select id="type_vehicule" name="type_vehicule" required>
                    <option value="">Sélectionnez</option>
                    <option value="voiture">Voiture</option>
                    <option value="camion">Camion</option>
                    <option value="moto">Moto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="immatriculation">Numéro d'immatriculation <span class="required">*</span></label>
                <input type="text" id="immatriculation" name="immatriculation" placeholder="AA-123-BB ou 1234-A-56" required>
            </div>
            <div class="form-group">
                <label for="registerPassword">Mot de passe <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="registerPassword" name="registerPassword" placeholder="Créez un mot de passe" required>
                    <i class="fas fa-eye toggle-password" data-target="registerPassword"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="registerPasswordConfirm">Confirmer le mot de passe <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="registerPasswordConfirm" name="registerPasswordConfirm" placeholder="Confirmez votre mot de passe" required>
                    <i class="fas fa-eye toggle-password" data-target="registerPasswordConfirm"></i>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="conditions" required> J'accepte les conditions générales d'utilisation <span class="required">*</span>
                </label>
            </div>
            <section>
                <button type="submit" class="btn btn-block" id="registerButton">S'inscrire</button>
            </section>
            <p style="text-align: center; margin-top: 1rem;"><a href="sign_in.php">Se connecter</a></p>
        </form>
    </div>
<?php include '../includes/footer.php'; ?>
