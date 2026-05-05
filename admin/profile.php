<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$admin_id = $_SESSION['admin_id'];
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

$notification = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if ($username) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET username = ?, password_hash = ? WHERE id = ?");
            $stmt->execute([$username, $hash, $admin_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE admins SET username = ? WHERE id = ?");
            $stmt->execute([$username, $admin_id]);
        }
        $_SESSION['admin_username'] = $username;
        $_SESSION['notification'] = "Profil mis à jour avec succès !";
        header("Location: profile.php");
        exit;
    }
}

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : '';
unset($_SESSION['notification']);
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Mon Profil</h2>
    </div>

    <?php if ($notification): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($notification); ?></div>
    <?php endif; ?>

    <div class="card" style="max-width: 600px;">
        <form method="post" action="">
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Rôle</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($admin['role']); ?>" disabled>
            </div>
            <div class="form-actions">
                <button type="submit" name="update_profile" class="btn btn-primary">Mettre à jour mon profil</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/admin/footer.php'; ?>
