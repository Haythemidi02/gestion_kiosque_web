<?php
require_once 'config.php';

$tables = ['users', 'products', 'categories', 'orders', 'order_items', 'settings', 'admins', 'newsletter', 'messages'];

foreach ($tables as $table) {
    try {
        $pdo->query("SELECT 1 FROM $table LIMIT 1");
        echo "Table $table exists.\n";
    } catch (Exception $e) {
        echo "Table $table does NOT exist.\n";
    }
}
?>
