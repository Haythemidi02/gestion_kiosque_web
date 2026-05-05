<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$daily_sales = getDailySales(30);
$category_sales = getProductCategorySales();
$top_products = getTopSellingProducts(10);

$total_revenue = 0;
foreach ($daily_sales as $sale) {
    $total_revenue += $sale['daily_total'];
}
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Rapports & Statistiques</h2>
    </div>

    <div class="dashboard">
        <div class="stat-card revenue">
            <h3>Revenus (30j)</h3>
            <div class="value"><?php echo number_format($total_revenue, 2, ',', ' '); ?> €</div>
        </div>
        <div class="stat-card orders">
            <h3>Total Produits vendus</h3>
            <div class="value">
                <?php 
                $total_q = 0;
                foreach($top_products as $tp) $total_q += $tp['total_quantity'];
                echo $total_q;
                ?>
            </div>
        </div>
    </div>

    <div class="chart-container" style="margin-top: 2rem;">
        <h3>Évolution des ventes journalières</h3>
        <div class="bar-chart" style="height: 300px; display: flex; align-items: flex-end; gap: 5px; border-bottom: 2px solid #ddd; padding-bottom: 10px;">
            <?php 
            $max_val = 1;
            foreach($daily_sales as $s) if($s['daily_total'] > $max_val) $max_val = $s['daily_total'];
            
            foreach ($daily_sales as $sale): 
                $h = ($sale['daily_total'] / $max_val) * 100;
            ?>
                <div class="bar-container" style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: <?php echo max($h, 2); ?>%; width: 100%; background: var(--primary); border-radius: 3px 3px 0 0;" title="<?php echo $sale['sale_date']; ?>: <?php echo $sale['daily_total']; ?> €"></div>
                    <div style="font-size: 0.7rem; margin-top: 5px;"><?php echo date('d', strtotime($sale['sale_date'])); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <div class="card">
            <h3>Ventes par Catégorie</h3>
            <table>
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Ventes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category_sales as $cs): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cs['category_name']); ?></td>
                            <td><?php echo number_format($cs['total_sales'], 2); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Produits les plus vendus</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_products as $tp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tp['name']); ?></td>
                            <td><?php echo $tp['total_quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/admin/footer.php'; ?>
