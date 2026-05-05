<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=kiosque', 'root', '');
    echo 'OK';
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
