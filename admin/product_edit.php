<?php
require_once '../core/admin_functions.php';
include '../includes/admin/header.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $product_id ? getProductById($product_id) : [
    'id' => '',
    'name' => '',
    'category_id' => '',
    'price' => '',
    'stock' => '',
    'description' => '',
    'status' => 1,
    'discount' => 0,
    'image' => ''
];

$categories = getAllCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $data = [
        'id' => $_POST['product_id'],
        'name' => $_POST['name'],
        'category_id' => $_POST['category_id'],
        'price' => $_POST['price'],
        'stock' => $_POST['stock'] === '' ? null : $_POST['stock'],
        'description' => $_POST['description'],
        'status' => isset($_POST['status']) ? 1 : 0,
        'discount' => $_POST['discount'],
        'current_image' => $_POST['current_image']
    ];
    
    $saved_id = saveProduct($data);
    if ($saved_id) {
        $_SESSION['notification'] = "Produit enregistré avec succès !";
        header("Location: products.php");
        exit;
    } else {
        $error = "Erreur lors de l'enregistrement.";
    }
}
?>

<div class="admin-content">
    <div class="section-title">
        <h2><?php echo $product_id ? 'Modifier' : 'Ajouter'; ?> un produit</h2>
        <a href="products.php" class="btn">Retour à la liste</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="current_image" value="<?php echo $product['image']; ?>">
            
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="name">Nom du produit</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="category_id">Catégorie</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="">Sélectionnez une catégorie</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="price">Prix (€)</label>
                        <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo $product['price']; ?>" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="stock">Stock (vide pour illimité)</label>
                        <input type="number" id="stock" name="stock" class="form-control" value="<?php echo $product['stock']; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label>Image du produit</label>
                        <div class="image-upload">
                            <input type="file" name="product_image" class="form-control" accept="image/*">
                            <?php if ($product['image']): ?>
                                <div style="margin-top: 10px;">
                                    <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" style="max-width: 100px; border-radius: 4px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="discount">Remise (%)</label>
                        <input type="number" id="discount" name="discount" class="form-control" min="0" max="100" value="<?php echo $product['discount']; ?>">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="status" <?php echo $product['status'] ? 'checked' : ''; ?>> Actif
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="save_product" class="btn btn-success">Enregistrer</button>
                <a href="products.php" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/admin/footer.php'; ?>
