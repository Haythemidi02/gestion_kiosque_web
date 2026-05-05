<?php
$passwords = ['', 'root', 'password', '123456', '1234', 'admin', 'mysql', 'toor', 'Root@123', 'root123', 'MySQL@123', 'Pass@123', 'Admin@123', '12345678', 'mysql8', 'xampp', 'raspberry', 'ensi', 'haythem', 'kiosque'];
foreach ($passwords as $pass) {
    try {
        $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', $pass, [PDO::ATTR_TIMEOUT => 2]);
        echo "SUCCESS with password: '$pass'\n";
        exit(0);
    } catch (PDOException $e) {
        echo "FAIL '$pass': " . $e->getMessage() . "\n";
    }
}
echo "\nNo common password worked. Manual reset required.\n";
?>
