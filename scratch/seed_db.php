<?php
require_once __DIR__ . '/../core/config.php';

$queries = [
    // Users table
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        nom VARCHAR(100) NOT NULL,
        type_vehicule VARCHAR(50),
        immatriculation VARCHAR(20),
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Categories table
    "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Products table
    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        discount INT DEFAULT 0,
        image VARCHAR(255) DEFAULT 'default.jpg',
        status TINYINT(1) DEFAULT 1,
        stock INT DEFAULT 100,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    )",

    // Orders table
    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        total DECIMAL(10,2) NOT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )",

    // Order items table
    "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        product_id INT,
        quantity INT NOT NULL DEFAULT 1,
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
    )",

    // Messages table
    "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255),
        message TEXT NOT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Newsletter table
    "CREATE TABLE IF NOT EXISTS newsletter (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Admins table
    "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Settings table
    "CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )"
];

echo "=== Creating tables ===\n";
foreach ($queries as $query) {
    try {
        $pdo->exec($query);
        preg_match('/TABLE IF NOT EXISTS (\w+)/', $query, $m);
        echo "  ✓ Table '{$m[1]}' ready\n";
    } catch (PDOException $e) {
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
}

// --- Seed Categories ---
echo "\n=== Seeding categories ===\n";
$cats = [
    ['Carburants',   'Essence, diesel et carburants alternatifs'],
    ['Lavage auto',  'Formules de lavage professionnel'],
    ['Produits',     'Huiles, lubrifiants et accessoires automobiles'],
];
foreach ($cats as [$name, $desc]) {
    $pdo->prepare("INSERT IGNORE INTO categories (name, description) VALUES (?, ?)")
        ->execute([$name, $desc]);
    echo "  ✓ Category: $name\n";
}

// --- Seed Products ---
echo "\n=== Seeding products ===\n";
$catIds = [];
$stmt = $pdo->query("SELECT id, name FROM categories");
foreach ($stmt->fetchAll() as $c) { $catIds[$c['name']] = $c['id']; }

$products = [
    // Carburants
    [$catIds['Carburants'], 'Sans Plomb 95',        'Essence standard adaptée à la majorité des véhicules.', 1.85, 0, 'sp95.jpg'],
    [$catIds['Carburants'], 'Sans Plomb 98',        'Essence haute performance pour moteurs exigeants.',      2.05, 5, 'sp98.jpg'],
    [$catIds['Carburants'], 'Diesel B7',            'Gazole de qualité pour véhicules diesel modernes.',      1.75, 0, 'diesel.jpg'],
    [$catIds['Carburants'], 'Diesel B10 Premium',   'Diesel haute performance avec additifs nettoyants.',     1.95, 10,'diesel_premium.jpg'],
    [$catIds['Carburants'], 'Recharge Électrique',  'Borne de recharge rapide 50 kW, compatible CCS/CHAdeMO.',0.35, 0,'electric.jpg'],
    // Lavage auto
    [$catIds['Lavage auto'], 'Lavage Basique',   'Lavage extérieur complet en 30 min.',                  25.00, 0,  'wash_basic.jpg'],
    [$catIds['Lavage auto'], 'Lavage Premium',   'Extérieur + intérieur, traitement jantes.',             45.00, 0,  'wash_premium.jpg'],
    [$catIds['Lavage auto'], 'Lavage Deluxe',    'Complet avec polissage, cirage et désodorisation.',    75.00, 15, 'wash_deluxe.jpg'],
    [$catIds['Lavage auto'], 'Nettoyage Moteur', 'Dégraissage professionnel du compartiment moteur.',    60.00, 0,  'wash_engine.jpg'],
    // Produits
    [$catIds['Produits'], 'Huile Moteur 5W-40',   'Huile synthétique haute performance, 5 litres.',       35.90, 0,  'oil_5w40.jpg'],
    [$catIds['Produits'], 'Huile Moteur 10W-40',  'Huile semi-synthétique polyvalente, 5 litres.',        28.50, 5,  'oil_10w40.jpg'],
    [$catIds['Produits'], 'Liquide de Frein DOT4', 'Liquide de frein haute température 500ml.',           12.90, 0,  'brake_fluid.jpg'],
    [$catIds['Produits'], 'Antigel Concentré',     'Protection jusqu\'à -30°C, flacon 1 litre.',          8.50,  0,  'antifreeze.jpg'],
    [$catIds['Produits'], 'Additif Carburant',     'Nettoie le circuit d\'injection, flacon 250ml.',      9.90,  20, 'fuel_additive.jpg'],
];
foreach ($products as [$cat, $name, $desc, $price, $disc, $img]) {
    $pdo->prepare("INSERT IGNORE INTO products (category_id, name, description, price, discount, image) VALUES (?,?,?,?,?,?)")
        ->execute([$cat, $name, $desc, $price, $disc, $img]);
    echo "  ✓ Product: $name\n";
}

// --- Default admin ---
echo "\n=== Seeding admin account ===\n";
$cnt = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if ($cnt == 0) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)")->execute(['admin', $hash]);
    echo "  ✓ Admin created: username=admin  password=admin123\n";
} else {
    echo "  ✓ Admin already exists\n";
}

// --- Default settings ---
echo "\n=== Seeding settings ===\n";
$settings = [
    ['shop_name',         'EnergyFuel Station'],
    ['shop_email',        'haythem.idi@ensi-uma.tn'],
    ['shop_phone',        '(+216) 27 312 507'],
    ['shop_address',      '5051 Moknine, Monastir'],
    ['hours_monday',      '08:00-20:00'],
    ['hours_tuesday',     '08:00-20:00'],
    ['hours_wednesday',   '08:00-20:00'],
    ['hours_thursday',    '08:00-20:00'],
    ['hours_friday',      '08:00-22:00'],
    ['hours_saturday',    '09:00-18:00'],
    ['hours_sunday',      'Fermé'],
    ['opening_special_notes', 'Service carburant disponible 24h/7j'],
];
foreach ($settings as [$key, $val]) {
    $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)")->execute([$key, $val]);
    echo "  ✓ Setting: $key\n";
}

echo "\n=== All done! Database fully seeded. ===\n";
?>
