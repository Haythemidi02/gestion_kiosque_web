<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

// Pagination
$limit = 10;
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $limit;

// Filters
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$products = getAllProducts($limit, $offset, $category_filter, $status_filter, $search_query);
$categories = getAllCategories();

// Notification
$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : '';
unset($_SESSION['notification']);
?>

<div class="admin-content">
    <div class="section-title">
        <h2>Gestion des Produits</h2>
        <a href="product_edit.php" class="btn btn-success">+ Ajouter un produit</a>
    </div>

    <?php if ($notification): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($notification); ?></div>
    <?php endif; ?>

    <div class="filters">
        <form method="get" action="" id="filter-form">
            <input type="text" name="search" class="filter-select" placeholder="Rechercher..." value="<?php echo htmlspecialchars($search_query); ?>">
            
            <select name="category" class="filter-select" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($category_filter == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="1" <?php echo ($status_filter === '1') ? 'selected' : ''; ?>>Actif</option>
                <option value="0" <?php echo ($status_filter === '0') ? 'selected' : ''; ?>>Inactif</option>
            </select>
            
            <button type="submit" class="btn">Filtrer</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): 
                    $imagePath = !empty($product['image']) ? '../assets/images/' . htmlspecialchars($product['image']) : '../assets/images/default-product.jpg';
                ?>
                    <tr>
                        <td>P<?php echo sprintf('%03d', $product['id']); ?></td>
                        <td>
                            <div class="product-img" style="width: 50px; height: 50px; overflow: hidden; border-radius: 4px;">
                                <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'Non catégorisé'); ?></td>
                        <td><?php echo number_format($product['price'], 2, ',', ' '); ?> €</td>
                        <td><?php echo ($product['stock'] === null) ? '∞' : (int)$product['stock']; ?></td>
                        <td>
                            <?php if ($product['status'] == 1): ?>
                                <span class="status status-active">Actif</span>
                            <?php else: ?>
                                <span class="status status-inactive">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="product_edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="product_delete.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Aucun produit trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/admin/footer.php'; ?>
