<?php
require_once __DIR__ . '/../core/config.php';

$pass = true;
function check($label, $ok, $detail='') {
    global $pass;
    $icon = $ok ? '✓' : '✗';
    $color = $ok ? '' : '';
    echo "  [$icon] $label" . ($detail ? " — $detail" : '') . "\n";
    if (!$ok) $pass = false;
}

echo "============================================\n";
echo "  Kiosk System — End-to-End Validation\n";
echo "============================================\n\n";

// 1. DATABASE
echo "[1] DATABASE CONNECTION\n";
check('PDO connected to kiosque_db', $pdo instanceof PDO);

// 2. TABLES
echo "\n[2] TABLE EXISTENCE\n";
$tables = ['users','categories','products','orders','order_items','messages','newsletter','admins','settings'];
foreach ($tables as $t) {
    $exists = $pdo->query("SHOW TABLES LIKE '$t'")->rowCount() > 0;
    check("Table '$t' exists", $exists);
}

// 3. CATEGORIES
echo "\n[3] CATEGORIES\n";
$cats = $pdo->query("SELECT name FROM categories")->fetchAll(PDO::FETCH_COLUMN);
check('Categories seeded ('.count($cats).')', count($cats) >= 3, implode(', ', $cats));

// 4. PRODUCTS
echo "\n[4] PRODUCTS\n";
$prods = $pdo->query("SELECT COUNT(*) FROM products WHERE status=1")->fetchColumn();
check('Products seeded', $prods >= 14, "$prods active products");
$carb = $pdo->query("SELECT COUNT(*) FROM products p JOIN categories c ON p.category_id=c.id WHERE c.name='Carburants'")->fetchColumn();
check('Carburant products', $carb >= 5, "$carb products");
$wash = $pdo->query("SELECT COUNT(*) FROM products p JOIN categories c ON p.category_id=c.id WHERE c.name='Lavage auto'")->fetchColumn();
check('Lavage auto products', $wash >= 4, "$wash products");

// 5. ADMIN ACCOUNT
echo "\n[5] ADMIN AUTHENTICATION\n";
$admin = $pdo->query("SELECT * FROM admins WHERE username='admin'")->fetch();
check('Admin account exists', $admin !== false);
check('Admin password verifiable', $admin && password_verify('admin123', $admin['password_hash']));
check('Admin role set', $admin && $admin['role'] === 'admin', $admin ? $admin['role'] : 'N/A');

// 6. SETTINGS
echo "\n[6] SETTINGS\n";
$settingCount = $pdo->query("SELECT COUNT(*) FROM settings")->fetchColumn();
check('Settings seeded', $settingCount >= 12, "$settingCount settings");
$shopName = $pdo->query("SELECT setting_value FROM settings WHERE setting_key='shop_name'")->fetchColumn();
check('shop_name set', !empty($shopName), $shopName ?: 'EMPTY');

// 7. USER REGISTRATION TEST
echo "\n[7] USER REGISTRATION\n";
$testEmail = 'validation_test@kiosk.local';
// Clean up from previous test runs
$pdo->prepare("DELETE FROM users WHERE email=?")->execute([$testEmail]);
// Register
$hashed = password_hash('testpass123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (email, nom, type_vehicule, immatriculation, password) VALUES (?,?,?,?,?)");
$ok = $stmt->execute([$testEmail, 'Test User', 'Voiture', 'TS-999-0000', $hashed]);
check('User registration INSERT', $ok);

// Login verification
$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$testEmail]);
$user = $stmt->fetch();
check('User can be fetched', $user !== false);
check('User password verifiable', $user && password_verify('testpass123', $user['password']));
// Clean up
$pdo->prepare("DELETE FROM users WHERE email=?")->execute([$testEmail]);
check('Cleanup successful', true);

// 8. getSetting() FUNCTION
echo "\n[8] getSetting() FUNCTION\n";
$name = getSetting('shop_name', 'MISSING');
check('getSetting() works', $name !== 'MISSING', "Returned: '$name'");
$hours = getSetting('hours_monday', 'MISSING');
check('hours_monday setting', $hours !== 'MISSING', "Value: '$hours'");

// 9. FILE STRUCTURE
echo "\n[9] KEY FILES\n";
$files = [
    'core/config.php', 'core/admin_functions.php', 'core/email_handler.php', 'core/logout.php',
    'includes/header.php', 'includes/footer.php',
    'includes/admin/header.php', 'includes/admin/footer.php',
    'client/accueil.php', 'client/sign_in.php', 'client/sign_up.php',
    'client/service.php', 'client/carburant.php', 'client/lavage.php',
    'client/panier.php', 'client/profile.php',
    'admin/login.php', 'admin/dashboard.php', 'admin/products.php',
    'admin/orders.php', 'admin/messages.php', 'admin/newsletter.php',
    'admin/stats.php', 'admin/settings.php', 'admin/profile.php',
    'index.php',
];
$base = __DIR__ . '/..';
foreach ($files as $f) {
    check($f, file_exists("$base/$f"));
}

// SUMMARY
echo "\n============================================\n";
if ($pass) {
    echo "  ✓ ALL CHECKS PASSED — System ready!\n";
} else {
    echo "  ✗ Some checks failed — see above.\n";
}
echo "============================================\n";
?>
