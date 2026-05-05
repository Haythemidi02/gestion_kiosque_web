<?php
require_once '../core/admin_functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    if (deleteProduct($id)) {
        $_SESSION['notification'] = "Produit supprimé avec succès.";
    } else {
        $_SESSION['notification'] = "Erreur lors de la suppression.";
    }
}

header("Location: products.php");
exit;
