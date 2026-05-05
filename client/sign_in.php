<?php
$extra_css = ['style_sign.css'];
$extra_js = ['script_sign_in.js'];
include '../includes/header.php';

if (isset($_SESSION['email'])) {
    header("Location: accueil.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginEmail'], $_POST['loginPassword'])) {
    $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['loginPassword']);

    $stmt = $pdo->prepare("SELECT email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Email non trouvé.";
    } elseif (!password_verify($password, $user['password'])) {
        $error = "Mot de passe incorrect.";
    } else {
        session_regenerate_id(true);
        $_SESSION['email'] = $user['email'];
        header("Location: accueil.php");
        exit();
    }
}
?>
    <div id="authSection" class="container">
        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="auth-form active" id="loginForm" method="POST">
            <div class="form-group">
                <label for="loginEmail">Email <span class="required">*</span></label>
                <input type="email" id="loginEmail" name="loginEmail" placeholder="Votre email" value="<?php echo isset($_POST['loginEmail']) ? htmlspecialchars($_POST['loginEmail']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Mot de passe <span class="required">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="loginPassword" name="loginPassword" placeholder="Votre mot de passe" required>
                    <label class="toggle-password">
                        <input type="checkbox" class="toggle-checkbox">
                        <i class="fas fa-eye"></i>
                    </label>
                </div>
            </div>
            <section>
                <button type="submit" class="btn btn-block" id="loginButton">Se connecter</button>
            </section>
            <p style="text-align: center; margin-top: 1rem;"><a href="sign_up.php">S'inscrire</a></p>
        </form>
    </div>
<?php include '../includes/footer.php'; ?>
