<?php
require_once '../core/config.php';
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$_SESSION['email']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: sign_in.php");
    exit();
}
?>

<section class="profile-section">
    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2><?php echo htmlspecialchars($user['nom']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            
            <div class="profile-details">
                <div class="detail-item">
                    <span class="label">Type de véhicule</span>
                    <span class="value"><?php echo htmlspecialchars($user['type_vehicule']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Immatriculation</span>
                    <span class="value"><?php echo htmlspecialchars($user['immatriculation']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Date d'inscription</span>
                    <span class="value"><?php echo date('d/m/Y', strtotime($user['created_at'] ?? 'now')); ?></span>
                </div>
            </div>
            
            <div class="profile-actions">
                <a href="panier.php" class="btn btn-primary">Voir mon panier</a>
                <a href="../core/logout.php" class="btn btn-outline">Se déconnecter</a>
            </div>
        </div>
    </div>
</section>

<style>
.profile-section {
    padding: 80px 0;
    background: #f8f9fa;
    min-height: 70vh;
}

.profile-card {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    padding: 40px;
    background: linear-gradient(135deg, #ff6b00, #ff8e3c);
    color: white;
    text-align: center;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
}

.profile-header h2 {
    margin-bottom: 5px;
    font-weight: 700;
}

.profile-header p {
    opacity: 0.9;
}

.profile-details {
    padding: 30px 40px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .label {
    color: #6c757d;
    font-weight: 500;
}

.detail-item .value {
    color: #212529;
    font-weight: 600;
}

.profile-actions {
    padding: 0 40px 40px;
    display: flex;
    gap: 15px;
}

.profile-actions .btn {
    flex: 1;
    text-align: center;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-primary {
    background: #ff6b00;
    color: white;
}

.btn-primary:hover {
    background: #e66000;
}

.btn-outline {
    border: 2px solid #ff6b00;
    color: #ff6b00;
}

.btn-outline:hover {
    background: #ff6b00;
    color: white;
}
</style>

<?php include '../includes/footer.php'; ?>
