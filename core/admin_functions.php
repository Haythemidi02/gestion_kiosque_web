<?php
require_once __DIR__ . '/config.php';

// Vérification de l'authentification
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0;
}

// Fonctions CRUD pour les produits
function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT p.*, c.name as category_name 
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.name ASC
    ");
    return $stmt->fetchAll();
}

function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function saveProduct($data) {
    global $pdo;
    
    // Gérer l'upload de l'image
    $imagePath = $data['current_image'] ?? null;
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Supprimer l'ancienne image si elle existe
        if ($imagePath && file_exists($uploadDir . $imagePath)) {
            unlink($uploadDir . $imagePath);
        }
        
        // Générer un nom de fichier unique
        $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('prod_') . '.' . $ext;
        $targetPath = $uploadDir . $imageName;
        
        // Déplacer le fichier uploadé
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
            $imagePath = $imageName;
        }
    }
    
    if (isset($data['id']) && $data['id'] > 0) {
        // Mise à jour
        $stmt = $pdo->prepare("
            UPDATE products 
            SET name = ?, category_id = ?, price = ?, stock = ?, 
                description = ?, status = ?, image = ?, discount = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['name'],
            $data['category_id'] ?: null,
            $data['price'],
            $data['stock'],
            $data['description'] ?? '',
            $data['status'] ?? 1,
            $imagePath,
            $data['discount'] ?? 0,
            $data['id']
        ]);
        return $data['id'];
    } else {
        // Création
        $stmt = $pdo->prepare("
            INSERT INTO products 
            (name, category_id, price, stock, description, status, image, discount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['category_id'] ?: null,
            $data['price'],
            $data['stock'],
            $data['description'] ?? '',
            $data['status'] ?? 1,
            $imagePath,
            $data['discount'] ?? 0
        ]);
        return $pdo->lastInsertId();
    }
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}

// Fonctions pour les catégories
function getAllCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function saveCategory($data) {
    global $pdo;
    
    if (isset($data['id']) && $data['id'] > 0) {
        // Mise à jour
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['id']]);
        return $data['id'];
    } else {
        // Création
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$data['name']]);
        return $pdo->lastInsertId();
    }
}

function deleteCategory($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}

// Fonctions pour les commandes
function getAllOrders($limit = 50) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY date_created DESC LIMIT :limit");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOrderById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getOrderItems($order_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT oi.*, p.name as product_name 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}

// Fonctions pour les statistiques
function getDailySales($days = 7) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            DATE(date_created) as sale_date,
            SUM(total_amount) as daily_total
        FROM orders
        WHERE date_created >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY DATE(date_created)
        ORDER BY sale_date ASC
    ");
    $stmt->execute([$days]);
    return $stmt->fetchAll();
}

function getProductCategorySales() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT 
            c.name as category_name,
            SUM(oi.quantity * oi.price) as total_sales,
            COUNT(DISTINCT o.id) as order_count
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN categories c ON p.category_id = c.id
        JOIN orders o ON oi.order_id = o.id
        WHERE o.date_created >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY c.id
        ORDER BY total_sales DESC
    ");
    return $stmt->fetchAll();
}

function getTopSellingProducts($limit = 5) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            p.id,
            p.name,
            c.name as category_name,
            p.price,
            SUM(oi.quantity) as total_quantity,
            SUM(oi.quantity * oi.price) as total_sales
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN categories c ON p.category_id = c.id
        JOIN orders o ON oi.order_id = o.id
        WHERE o.date_created >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY p.id
        ORDER BY total_quantity DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonctions pour les paramètres
function getSettings() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function updateSetting($key, $value) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO settings (setting_key, setting_value) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE setting_value = ?
    ");
    return $stmt->execute([$key, $value, $value]);
}
