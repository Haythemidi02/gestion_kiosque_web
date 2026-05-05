<?php
$extra_css = ['style_paiment.css'];
$extra_js = ['script_paiment.js'];
include '../includes/header.php';

if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}
?>
    <!-- paiement -->
    <div id="paymentSection" class="container">
        <div class="section-title">
            <h1>Paiement</h1>
            <p>Finalisez votre commande</p>
        </div>
        
        <div class="payment-container">
            <h2>Récapitulatif de la commande</h2>
            <div class="summary">
                <div class="summary-item">
                    <span id="selectedItem">Article sélectionné</span>
                    <span id="itemPrice">0.00 TND</span>
                </div>
                <div class="summary-item total">
                    <span>Total</span>
                    <span id="totalPrice">0.00 TND</span>
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 2rem;">
                <label for="cardNumber">Numéro de carte</label>
                <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" class="form-control">
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <div class="form-group" style="flex: 1;">
                    <label for="expiryDate">Date d'expiration</label>
                    <input type="text" id="expiryDate" placeholder="MM/AA" class="form-control">
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" placeholder="123" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label for="cardName">Nom sur la carte</label>
                <input type="text" id="cardName" placeholder="NOM PRÉNOM" class="form-control">
            </div>
            <section style="margin-top: 2rem;">
                <a href="pai_conf.php" class="btn btn-block">Payer</a>
            </section>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
