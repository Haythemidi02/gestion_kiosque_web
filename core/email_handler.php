<?php
require_once 'config.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'newsletter') {
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO newsletter (email) VALUES (?)");
                $stmt->execute([$email]);
                // En réalité, on enverrait un email ici
                header("Location: ../client/accueil.php?msg=newsletter_success");
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    header("Location: ../client/accueil.php?msg=newsletter_already");
                } else {
                    header("Location: ../client/accueil.php?msg=newsletter_error");
                }
            }
        } else {
            header("Location: ../client/accueil.php?msg=invalid_email");
        }
        exit;
    }
    
    if ($action === 'contact') {
        $name = trim($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST['subject'] ?? 'Nouveau message');
        $message = trim($_POST['message'] ?? '');
        
        if ($name && $email && $message) {
            try {
                $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $subject, $message]);
                header("Location: ../client/accueil.php?msg=contact_success");
            } catch (PDOException $e) {
                header("Location: ../client/accueil.php?msg=contact_error");
            }
        } else {
            header("Location: ../client/accueil.php?msg=missing_fields");
        }
        exit;
    }
}

header("Location: ../client/accueil.php");
exit;
?>
