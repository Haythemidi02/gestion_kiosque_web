<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$orders = getAllOrders(50);
$view_order_id = isset($_GET['view']) ? (int)$_GET['view'] : 0;
$order_details = $view_order_id ? getOrderById($view_order_id) : null;
$order_items = $view_order_id ? getOrderItems($view_order_id) : [];
?>

<div class="admin-content">
    <?php if ($view_order_id && $order_details): ?>
        <div class="section-title">
            <h2>Détails de la commande #<?php echo $order_details['id']; ?></h2>
            <a href="orders.php" class="btn">Retour à la liste</a>
        </div>

        <div class="card">
            <div class="form-row">
                <div class="form-col">
                    <h4>Informations</h4>
                    <p><strong>Date:</strong> <?php echo date('d/m/Y - H:i', strtotime($order_details['date_created'])); ?></p>
                    <p><strong>Statut:</strong> 
                        <span class="status status-<?php echo $order_details['status']; ?>">
                            <?php echo ucfirst($order_details['status']); ?>
                        </span>
                    </p>
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($order_details['order_type']); ?></p>
                    <p><strong>Client:</strong> <?php echo $order_details['customer_id'] ?: 'Anonyme'; ?></p>
                </div>
                <div class="form-col">
                    <h4>Articles</h4>
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Qté</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo number_format($item['price'], 2); ?> €</td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: right;">TOTAL</th>
                                <th><?php echo number_format($order_details['total_amount'], 2); ?> €</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="section-title">
            <h2>Historique des Commandes</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['date_created'])); ?></td>
                            <td><?php echo htmlspecialchars($order['order_type']); ?></td>
                            <td><?php echo number_format($order['total_amount'], 2); ?> €</td>
                            <td>
                                <span class="status status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="orders.php?view=<?php echo $order['id']; ?>" class="btn btn-sm">Détails</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Aucune commande trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/admin/footer.php'; ?>
