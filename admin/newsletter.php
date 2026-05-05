<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$stmt = $pdo->query("SELECT * FROM newsletter ORDER BY subscribed_at DESC");
$subscribers = $stmt->fetchAll();

$delete_id = isset($_GET['delete']) ? (int)$_GET['delete'] : 0;
if ($delete_id) {
    $stmt = $pdo->prepare("DELETE FROM newsletter WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: newsletter.php?msg=deleted");
    exit;
}
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Abonnés Newsletter</h2>
        <a href="export_newsletter.php" class="btn btn-primary">Exporter (CSV)</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subscribers)): ?>
                <?php foreach ($subscribers as $sub): ?>
                    <tr>
                        <td><?php echo $sub['id']; ?></td>
                        <td><?php echo htmlspecialchars($sub['email']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($sub['subscribed_at'])); ?></td>
                        <td>
                            <a href="newsletter.php?delete=<?php echo $sub['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Désabonner cet email ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Aucun abonné pour le moment.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/admin/footer.php'; ?>
