<?php
$extra_css = ['style_panier.css'];
$extra_js = ['script_panier.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit();
}
?>
    <div id="authSection" class="container">
        <h2>Votre Panier</h2>
        <p id="emptyMessage" style="display: none;">Votre panier est vide.</p>
        <div id="cartSection" style="display: none;">
            <table id="cartTable" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <!-- Rows will be dynamically generated -->
            </table>
            <p><strong>Total :</strong> <span id="total">0.00 €</span></p>
            <button id="clearCart" class="btn">Vider le panier</button>
            <a href="paiement.php" id="payButton" class="btn" style="background-color: #4CAF50;">Payer</a>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
