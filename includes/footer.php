    <footer>
      <div class="footer-links">
        <div class="social-media">
          <h4>Suivez-nous</h4>
          <ul>
            <li><img src="../assets/images/facebook.png" width="20px" height="20px"><a href="#">Facebook</a></li>
            <li><img src="../assets/images/instagram.png" width="20px" height="20px"><a href="#">Instagram</a></li>
            <li><img src="../assets/images/twitter.png" width="20px" height="20px"><a href="#">X</a></li>
            <li><img src="../assets/images/linkedin.png" width="20px" height="20px"><a href="#">LinkedIn</a></li>
            <li><img src="../assets/images/youtube.png" width="20px" height="20px"><a href="#">Youtube</a></li>
          </ul>
        </div>
      </div>
  
      <div class="footer-bottom">
        <p>&copy; 2025 EnergyFuel</p>
        <ul>
          <li><a href="https://policies.google.com/privacy">Privacy Policy</a></li>
          <li><a href="https://policies.google.com/terms">Terms of Service</a></li>
          <li><a href="https://www.youronlinechoices.com/">Cookies Settings</a></li>
        </ul>
      </div>
    </footer>
    <div class="chatbot" id="chatbot" aria-live="polite">
      <button class="chatbot-toggle" id="chatbotToggle" type="button" aria-label="Ouvrir l'assistant">
        <i class="fas fa-comments"></i>
      </button>
      <section class="chatbot-panel" id="chatbotPanel" aria-label="Assistant EnergyFuel">
        <div class="chatbot-header">
          <div>
            <strong>Assistant EnergyFuel</strong>
            <span>Guide services</span>
          </div>
          <button class="chatbot-close" id="chatbotClose" type="button" aria-label="Fermer">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="chatbot-messages" id="chatbotMessages">
          <div class="chatbot-message bot">
            Bonjour, je peux vous guider vers le lavage auto, les produits, le carburant, le paiement ou votre compte.
          </div>
        </div>
        <div class="chatbot-quick-actions" aria-label="Questions rapides">
          <button type="button" data-chatbot-prompt="Je veux prendre rendez-vous pour un lavage auto">Lavage</button>
          <button type="button" data-chatbot-prompt="Je cherche des produits pour ma voiture">Produits</button>
          <button type="button" data-chatbot-prompt="Comment remplir le reservoir avec le service carburant ?">Carburant</button>
        </div>
        <form class="chatbot-form" id="chatbotForm">
          <input id="chatbotInput" type="text" maxlength="500" placeholder="Posez votre question..." autocomplete="off" aria-label="Votre question">
          <button type="submit" aria-label="Envoyer">
            <i class="fas fa-paper-plane"></i>
          </button>
        </form>
      </section>
    </div>
    <?php if (isset($extra_js)): foreach ($extra_js as $js): ?>
        <script src="../assets/js/<?php echo $js; ?>" defer></script>
    <?php endforeach; endif; ?>
    <script src="../assets/js/chatbot.js" defer></script>
</body>
</html>
