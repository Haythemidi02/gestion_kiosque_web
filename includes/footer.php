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
    <?php if (isset($extra_js)): foreach ($extra_js as $js): ?>
        <script src="../assets/js/<?php echo $js; ?>" defer></script>
    <?php endforeach; endif; ?>
</body>
</html>
