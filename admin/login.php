<?php
session_start();
require_once '../core/config.php';
require_once '../core/admin_functions.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login_submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            $login_error = "Identifiants incorrects";
        }
    } else {
        $login_error = "Veuillez remplir tous les champs";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration - EnergyFuel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">Fuel<span>Admin</span></div>
                <p>Connectez-vous pour accéder au panneau d'administration</p>
            </div>
            
            <?php if (isset($login_error)): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
            <?php endif; ?>
            
            <form class="login-form" method="post" action="login.php">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login_submit" class="login-btn">Connexion</button>
            </form>
        </div>
    </div>
</body>
</html>
