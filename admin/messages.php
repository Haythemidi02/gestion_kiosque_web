<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

// Get messages from database
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();

$view_id = isset($_GET['view']) ? (int)$_GET['view'] : 0;
$view_msg = null;
if ($view_id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->execute([$view_id]);
    $view_msg = $stmt->fetch();
}

$delete_id = isset($_GET['delete']) ? (int)$_GET['delete'] : 0;
if ($delete_id) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: messages.php?msg=deleted");
    exit;
}
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Messages & Contacts</h2>
    </div>

    <?php if ($view_msg): ?>
        <div class="card">
            <div class="card-header">
                <h3>De: <?php echo htmlspecialchars($view_msg['name']); ?> (<?php echo htmlspecialchars($view_msg['email']); ?>)</h3>
                <p>Date: <?php echo date('d/m/Y H:i', strtotime($view_msg['created_at'])); ?></p>
            </div>
            <div class="card-body" style="padding: 1.5rem; background: #fff; border-radius: 8px; margin: 1rem 0;">
                <p><strong>Sujet:</strong> <?php echo htmlspecialchars($view_msg['subject']); ?></p>
                <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #eee;">
                <div style="line-height: 1.6; white-space: pre-wrap;"><?php echo htmlspecialchars($view_msg['message']); ?></div>
            </div>
            <div class="form-actions">
                <a href="mailto:<?php echo $view_msg['email']; ?>?subject=Re: <?php echo urlencode($view_msg['subject']); ?>" class="btn btn-success">Répondre par Email</a>
                <a href="messages.php" class="btn">Retour</a>
            </div>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($msg['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><?php echo htmlspecialchars($msg['email']); ?></td>
                            <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                            <td>
                                <a href="messages.php?view=<?php echo $msg['id']; ?>" class="btn btn-sm">Lire</a>
                                <a href="messages.php?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce message ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucun message reçu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/admin/footer.php'; ?>
