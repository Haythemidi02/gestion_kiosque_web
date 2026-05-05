<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    echo 'Connected successfully to 127.0.0.1';
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
