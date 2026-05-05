<?php
include '../includes/admin/header.php';

$daily_sales = getDailySales(7);
$top_products = getTopSellingProducts(5);
$category_sales = getProductCategorySales();
$recent_orders = getAllOrders(10);
?>

<div class="section-title">
    <h2>Aperçu Rapide</h2>
</div>

<div class="dashboard">
    <div class="stat-card revenue">
        <h3>Chiffre d'affaires</h3>
        <?php 
        $today_sales = 0;
        foreach ($daily_sales as $sale) {
            if ($sale['sale_date'] === date('Y-m-d')) {
                $today_sales = $sale['daily_total'];
                break;
            }
        }
        ?>
        <div class="value"><?php echo number_format($today_sales, 2, ',', ' '); ?> €</div>
        <div class="time-format">Aujourd'hui</div>
    </div>
    <div class="stat-card fuel">
        <h3>Carburant vendu</h3>
        <div class="value">1,785 L</div>
        <div class="time-format">Dernières 24h</div>
    </div>
    <div class="stat-card wash">
        <h3>Lavages effectués</h3>
        <div class="value">42</div>
        <div class="time-format">Ce mois</div>
    </div>
    <div class="stat-card products">
        <h3>Produits vendus</h3>
        <div class="value">87</div>
        <div class="time-format">Cette semaine</div>
    </div>
</div>

<div class="chart-container">
    <div class="chart-header">
        <div class="chart-title">Ventes des 7 derniers jours</div>
        <div class="time-period-selector">
            <button class="time-btn">Jour</button>
            <button class="time-btn active">Semaine</button>
            <button class="time-btn">Mois</button>
            <button class="time-btn">Année</button>
        </div>
    </div>
    <div class="bar-chart">
        <div class="chart-y-axis">
            <div>3000€</div>
            <div>2250€</div>
            <div>1500€</div>
            <div>750€</div>
            <div>0€</div>
        </div>
        <div class="chart-grid">
            <div class="grid-line"></div>
            <div class="grid-line"></div>
            <div class="grid-line"></div>
            <div class="grid-line"></div>
            <div class="grid-line"></div>
        </div>
        
        <?php
        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        $height_values = [180, 220, 250, 280, 320, 240, 200]; 
        
        foreach ($days as $index => $day): 
            $height = $height_values[$index];
        ?>
        <div class="bar-container">
            <div class="bar" style="height: <?php echo $height; ?>px;"></div>
            <div class="bar-label"><?php echo $day; ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-title">
    <h2>Produits & Services populaires</h2>
</div>

<table>
    <thead>
        <tr>
            <th>Produit/Service</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Vendus</th>
            <th>Stock</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($top_products)): ?>
            <?php foreach ($top_products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                <td><?php echo number_format($product['price'], 2, ',', ' '); ?> €</td>
                <td><?php echo $product['total_quantity']; ?></td>
                <td><?php echo ($product['stock'] === null) ? '∞' : $product['stock']; ?></td>
                <td>
                    <?php if ($product['stock'] > 0 || $product['stock'] === null): ?>
                        <span class="status status-active">Actif</span>
                    <?php else: ?>
                        <span class="status status-inactive">Rupture</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Aucune donnée disponible</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="section-title">
    <h2>Transactions récentes</h2>
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
        <?php if (!empty($recent_orders)): ?>
            <?php foreach ($recent_orders as $order): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo date('d/m/Y - H:i', strtotime($order['date_created'])); ?></td>
                <td><?php echo htmlspecialchars($order['order_type']); ?></td>
                <td><?php echo number_format($order['total_amount'], 2, ',', ' '); ?> €</td>
                <td>
                    <span class="status status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span>
                </td>
                <td>
                    <a href="orders.php?view_order=<?php echo $order['id']; ?>">
                        <button class="btn btn-sm">Détails</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Aucune transaction récente</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../includes/admin/footer.php'; ?>
