<?php
try {
    $pdo = new PDO('mysql:host=localhost', 'root', 'mysql');
    echo 'OK';
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
