<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panneau d'Administration du Kiosque</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- TailwindCSS 2.2.19 -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- FontAwesome 6.5.2 -->
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@3.3.1/index.min.css" rel="stylesheet">
  <!-- Chart.js 4.4.3 -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <style>
    body { font-family: 'Inter', Arial, sans-serif; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .section { margin-bottom: 2rem; }
    select, input, button, textarea { font-size: 1rem; }
    /* Animation keyframes */
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(16px);}
      100% { opacity: 1; transform: none;}
    }
    @keyframes slideInRight {
      0% { opacity: 0; transform: translateX(40px);}
      100% { opacity: 1; transform: none;}
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }
    .fadeInUp {
      animation: fadeInUp 0.7s cubic-bezier(0.39, 0.575, 0.565, 1) both;
    }
    .slideInRight {
      animation: slideInRight 0.5s ease-out both;
    }
    .pulse {
      animation: pulse 1.5s ease infinite;
    }
    .shake {
      animation: shake 0.4s ease-in-out;
    }
    .btn-transition {
      transition: background 0.24s, color 0.2s, box-shadow 0.2s;
    }
    /* Responsive tables for print (no scroll) */
    table {word-break: break-word;}
    
    /* Auth screens overlay */
    .auth-screen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(248, 250, 252, 0.98);
      z-index: 50;
      transition: opacity 0.3s ease;
    }
    .auth-container {
      max-width: 450px;
      width: 90%;
      margin: 0 auto;
      margin-top: 10vh;
    }
    .auth-box {
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .auth-box:hover {
      box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.3), 0 10px 15px -5px rgba(0, 0, 0, 0.08);
    }
    .auth-input {
      transition: all 0.2s ease;
      border: 1px solid #E5E7EB;
    }
    .auth-input:focus {
      border-color: #818CF8;
      box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.1);
      outline: none;
    }
    .auth-input.error {
      border-color: #EF4444;
    }
    .auth-btn {
      transition: all 0.3s ease;
    }
    .auth-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }
    .auth-btn:active {
      transform: translateY(1px);
    }
    .auth-link {
      transition: all 0.2s;
    }
    .auth-link:hover {
      color: #4F46E5;
    }
    /* Password strength indicators */
    .strength-indicator {
      height: 5px;
      transition: all 0.3s ease;
      border-radius: 3px;
    }
    .strength-indicator.weak { width: 25%; background-color: #EF4444; }
    .strength-indicator.medium { width: 50%; background-color: #F59E0B; }
    .strength-indicator.strong { width: 75%; background-color: #10B981; }
    .strength-indicator.very-strong { width: 100%; background-color: #059669; }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 no-scrollbar">

  <!-- Écran de connexion (signin) -->
  <div id="signin-screen" class="auth-screen" style="display: block;">
    <div class="auth-container">
      <div class="text-center mb-8 fadeInUp">
        <h1 class="text-3xl font-bold text-indigo-700 mb-2">
          <i class="fas fa-cogs mr-2"></i>Administration Kiosque
        </h1>
        <p class="text-gray-500">Connectez-vous pour accéder au panneau d'administration</p>
      </div>
      
      <div class="auth-box p-8 fadeInUp" style="animation-delay: 0.1s">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Connexion</h2>
        
        <form id="signin-form" class="space-y-4">
          <div>
            <label for="signin-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="signin-email" class="auth-input w-full px-4 py-2 rounded-md" placeholder="votre@email.com" required>
            <div id="signin-email-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div>
            <div class="flex justify-between items-center mb-1">
              <label for="signin-password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
              <button type="button" id="forgot-password-btn" class="text-xs text-indigo-600 auth-link">Mot de passe oublié ?</button>
            </div>
            <input type="password" id="signin-password" class="auth-input w-full px-4 py-2 rounded-md" placeholder="••••••••" required>
            <div id="signin-password-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div class="flex items-center">
            <input type="checkbox" id="remember-me" class="h-4 w-4 text-indigo-600 rounded border-gray-300">
            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Rester connecté</label>
          </div>
          
          <div>
            <button type="submit" class="auth-btn w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
              <span id="signin-btn-text">Se connecter</span>
              <i id="signin-spinner" class="fas fa-spinner fa-spin hidden ml-2"></i>
            </button>
          </div>
        </form>
        
        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Pas encore de compte ?</span>
          <button id="goto-signup-btn" class="ml-1 text-indigo-600 font-medium auth-link">S'inscrire</button>
        </div>
      </div>
      
      <!-- Formulaire de récupération de mot de passe -->
      <div id="forgot-password-box" class="auth-box p-8 mt-4 hidden">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Récupération de mot de passe</h3>
        <p class="text-sm text-gray-600 mb-4">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
        
        <form id="forgot-password-form" class="space-y-4">
          <div>
            <input type="email" id="recovery-email" class="auth-input w-full px-4 py-2 rounded-md" placeholder="votre@email.com" required>
            <div id="recovery-email-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div>
            <button type="submit" class="auth-btn w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none">
              <span id="recovery-btn-text">Envoyer le lien</span>
              <i id="recovery-spinner" class="fas fa-spinner fa-spin hidden ml-2"></i>
            </button>
          </div>
        </form>
        
        <div class="mt-4 text-center">
          <button id="back-to-signin" class="text-sm text-indigo-600 auth-link">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
          </button>
        </div>
      </div>
      
      <div id="signin-success-message" class="hidden mt-4 p-4 rounded-md bg-green-100 text-green-700 text-center fadeInUp">
        <i class="fas fa-check-circle mr-2"></i>
        <span>Connexion réussie ! Redirection...</span>
      </div>
    </div>
  </div>

  <!-- Écran d'inscription (signup) -->
  <div id="signup-screen" class="auth-screen" style="display: none;">
    <div class="auth-container">
      <div class="text-center mb-8 fadeInUp">
        <h1 class="text-3xl font-bold text-indigo-700 mb-2">
          <i class="fas fa-cogs mr-2"></i>Administration Kiosque
        </h1>
        <p class="text-gray-500">Créez un compte pour accéder au panneau d'administration</p>
      </div>
      
      <div class="auth-box p-8 fadeInUp" style="animation-delay: 0.1s">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Inscription</h2>
        
        <form id="signup-form" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="signup-firstname" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
              <input type="text" id="signup-firstname" class="auth-input w-full px-4 py-2 rounded-md" placeholder="Prénom" required>
              <div id="signup-firstname-error" class="hidden text-red-500 text-xs mt-1"></div>
            </div>
            <div>
              <label for="signup-lastname" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
              <input type="text" id="signup-lastname" class="auth-input w-full px-4 py-2 rounded-md" placeholder="Nom" required>
              <div id="signup-lastname-error" class="hidden text-red-500 text-xs mt-1"></div>
            </div>
          </div>
          
          <div>
            <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="signup-email" class="auth-input w-full px-4 py-2 rounded-md" placeholder="votre@email.com" required>
            <div id="signup-email-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div>
            <label for="signup-role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
            <select id="signup-role" class="auth-input w-full px-4 py-2 rounded-md bg-white" required>
              <option value="">Sélectionnez un rôle</option>
              <option value="admin">Administrateur</option>
              <option value="editor">Éditeur</option>
              <option value="tech">Technicien</option>
            </select>
            <div id="signup-role-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div>
            <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input type="password" id="signup-password" class="auth-input w-full px-4 py-2 rounded-md" placeholder="••••••••" required>
            <div id="signup-password-error" class="hidden text-red-500 text-xs mt-1"></div>
            
            <!-- Indicateur de force du mot de passe -->
            <div class="mt-2">
              <div class="flex justify-between text-xs mb-1">
                <span>Force:</span>
                <span id="password-strength-text">Non défini</span>
              </div>
              <div class="bg-gray-200 h-1 rounded-full">
                <div id="password-strength-bar" class="strength-indicator"></div>
              </div>
            </div>
          </div>
          
          <div>
            <label for="signup-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input type="password" id="signup-confirm-password" class="auth-input w-full px-4 py-2 rounded-md" placeholder="••••••••" required>
            <div id="signup-confirm-password-error" class="hidden text-red-500 text-xs mt-1"></div>
          </div>
          
          <div class="flex items-start">
            <input type="checkbox" id="terms-checkbox" class="h-4 w-4 mt-1 text-indigo-600 rounded border-gray-300">
            <label for="terms-checkbox" class="ml-2 block text-sm text-gray-700">
              J'accepte les <a href="#" class="text-indigo-600 hover:text-indigo-800">conditions d'utilisation</a> et la <a href="#" class="text-indigo-600 hover:text-indigo-800">politique de confidentialité</a>
            </label>
          </div>
          
          <div>
            <button type="submit" class="auth-btn w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
              <span id="signup-btn-text">Créer un compte</span>
              <i id="signup-spinner" class="fas fa-spinner fa-spin hidden ml-2"></i>
            </button>
          </div>
        </form>
        
        <div class="mt-6 text-center text-sm">
          <span class="text-gray-600">Déjà inscrit ?</span>
          <button id="goto-signin-btn" class="ml-1 text-indigo-600 font-medium auth-link">Se connecter</button>
        </div>
      </div>
      
      <div id="signup-success-message" class="hidden mt-4 p-4 rounded-md bg-green-100 text-green-700 text-center fadeInUp">
        <i class="fas fa-check-circle mr-2"></i>
        <span>Inscription réussie ! Vous pouvez maintenant vous connecter.</span>
      </div>
    </div>
  </div>

  <header class="bg-indigo-700 text-white py-6 px-8 rounded-b-lg shadow-md mb-10 fadeInUp">
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-extrabold flex items-center gap-4">
        <i class="fas fa-cogs"></i>Panneau d'Administration du Kiosque
      </h1>
      <div class="hidden" id="user-info">
        <div class="flex items-center gap-3">
          <div class="text-right">
            <div id="current-user" class="font-medium"></div>
            <div id="current-role" class="text-indigo-200 text-sm"></div>
          </div>
          <button id="logout-btn" class="ml-4 px-4 py-2 bg-indigo-800 rounded-md hover:bg-indigo-900 transition-all">
            <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
          </button>
        </div>
      </div>
    </div>
    <p class="mt-1 text-lg font-light">Gérez l'ensemble des fonctions de votre kiosque sur une seule interface.</p>
  </header>

  <main class="max-w-6xl mx-auto px-4">

    <!-- Authentification & Sécurité -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.10s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-shield-alt"></i> Authentification & Sécurité
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="font-semibold">Connexion</label>
          <form id="login-form" class="bg-gray-50 rounded mt-2 mb-4 p-4 shadow" autocomplete="off">
            <div class="mb-3">
              <input id="username" type="text" placeholder="Nom d'utilisateur" class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-200 transition" required autocomplete="username"/>
            </div>
            <div class="mb-3">
              <input id="password" type="password" placeholder="Mot de passe" class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-200 transition" required autocomplete="current-password"/>
            </div>
            <div class="flex items-center mb-3">
              <input type="checkbox" id="2fa" class="mr-2">
              <label for="2fa">Activer la double authentification (2FA)</label>
            </div>
            <button type="submit" class="bg-indigo-600 text-white w-full py-2 rounded hover:bg-indigo-700 transition btn-transition">
              Connexion
            </button>
            <div id="login-alert" class="hidden mt-3 text-red-500 text-sm"></div>
          </form>
        </div>
        <div>
          <label class="font-semibold">Gestion des rôles et permissions</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b">
                  <th class="text-left py-1">Rôle</th>
                  <th class="text-left py-1">Permissions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Administrateur</td>
                  <td>Tout accès</td>
                </tr>
                <tr>
                  <td>Éditeur</td>
                  <td>Gestion contenu & médias</td>
                </tr>
                <tr>
                  <td>Technicien</td>
                  <td>Maintenance & Diagnostics</td>
                </tr>
              </tbody>
            </table>
            <div class="mt-4 flex flex-col gap-1">
              <span class="text-xs text-gray-500">Changer le rôle :</span>
              <div class="flex gap-2">
                <input id="change-user-role" type="text" class="border rounded px-2 py-1" placeholder="Utilisateur">
                <select id="role-select" class="border rounded px-2 py-1">
                  <option>Administrateur</option>
                  <option>Éditeur</option>
                  <option>Technicien</option>
                </select>
                <button type="button" onclick="changeRoleDynamic()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-sm hover:bg-indigo-200 btn-transition"><i class="fas fa-sync"></i></button>
              </div>
              <div id="role-change-alert" class="hidden text-green-600 text-xs mt-1"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-6">
        <label class="font-semibold">Journalisation des actions</label>
        <textarea id="logs-text" rows="4" class="w-full bg-gray-50 border rounded mt-3 px-3 py-2 text-xs" placeholder="Logs d'activité système, actions utilisateurs, interventions…"></textarea>
        <div class="mt-2 flex gap-2">
          <button onclick="addLog()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-xs hover:bg-indigo-200 btn-transition"><i class="fas fa-plus"></i> Ajouter un log</button>
          <button onclick="clearLogs()" class="bg-red-100 text-red-700 px-3 rounded text-xs hover:bg-red-200 btn-transition"><i class="fas fa-trash"></i> Effacer</button>
        </div>
      </div>
    </section>

    <!-- Gestion du contenu affiché sur le kiosque -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.13s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-desktop"></i> Gestion du contenu affiché sur le kiosque
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="font-semibold">Pages & Écrans</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <ul id="pages-list" class="space-y-2">
              <!-- Will be dynamic -->
            </ul>
            <div class="flex mt-4 gap-2">
              <input id="new-page-input" type="text" placeholder="Titre de la page" class="border rounded px-2 py-1 flex-1 text-sm" />
              <button onclick="addPage()" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 py-1 px-4 rounded text-sm font-semibold btn-transition">
                <i class="fas fa-plus"></i> Ajouter
              </button>
            </div>
          </div>
        </div>
        <div>
          <label class="font-semibold">Médias</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <div class="mb-2">Images, vidéos, PDF…</div>
            <div class="flex items-center gap-4 mb-3">
              <input id="media-file" type="text" class="block border rounded px-2 py-1 text-sm" placeholder="Nom du fichier (ex: banner.jpg)" />
              <button onclick="addMedia()" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 py-1 px-3 rounded text-sm font-semibold btn-transition">
                <i class="fas fa-upload"></i> Upload
              </button>
            </div>
            <div id="media-list" class="flex flex-wrap gap-2"></div>
          </div>
        </div>
      </div>
      <div class="mt-7 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="font-semibold">Annonces & Bannières</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <div class="flex gap-2 mb-2">
              <textarea id="new-banner-input" class="w-full border p-2 rounded text-xs" rows="2" placeholder="Saisissez une nouvelle annonce…"></textarea>
              <button onclick="addBanner()" class="bg-indigo-100 text-indigo-700 py-1 px-4 rounded hover:bg-indigo-200 text-sm font-semibold btn-transition"><i class="fas fa-plus"></i></button>
            </div>
            <ul id="banner-list" class="mt-2 text-xs"></ul>
          </div>
        </div>
        <div>
          <label class="font-semibold">Prévisualisation du contenu</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow min-h-[130px] flex flex-col items-center justify-center">
            <div id="preview-content" class="text-gray-600 italic text-sm transition">Sélectionnez une page pour prévisualiser</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gestion des services proposés -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.16s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-clipboard-list"></i> Gestion des services proposés
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="font-semibold">Liste des services disponibles</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <ul class="text-xs" id="service-list"></ul>
            <div class="mt-3 flex gap-2">
              <input id="new-service-input" type="text" class="border rounded px-2 py-1 flex-1" placeholder="Nouveau service">
              <button onclick="addService()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-sm hover:bg-indigo-200 btn-transition"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div>
          <label class="font-semibold">Configuration / Options</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow space-y-2">
            <div>
              <span class="inline-block w-44">Formulaire de paiement :</span>
              <select class="border rounded px-2 py-1" id="payment-form-select">
                <option>Simple</option>
                <option>Avancé</option>
              </select>
            </div>
            <div>
              <span class="inline-block w-44">Options utilisateur :</span>
              <input type="checkbox" id="user-signature" class="mr-1">Activer la signature numérique
            </div>
          </div>
        </div>
      </div>
      <div class="mt-6">
        <label class="font-semibold">Suivi des opérations</label>
        <div class="bg-gray-50 rounded mt-2 p-4 shadow">
          <table class="table-auto w-full text-xs" id="operations-table">
            <thead>
              <tr class="text-left border-b">
                <th>Date</th>
                <th>Service</th>
                <th>Utilisateur</th>
                <th>Statut</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dynamic rows -->
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Configuration système du kiosque -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.19s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-tools"></i> Configuration système du kiosque
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="mb-2">
          <label class="font-semibold">Horaires de fonctionnement</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow flex gap-4 items-center">
            <span>Lun - Ven :</span>
            <input type="time" id="opening" value="08:00" class="border rounded px-2 py-1 w-28">
            <span>à</span>
            <input type="time" id="closing" value="19:00" class="border rounded px-2 py-1 w-28">
            <button onclick="saveHours()" class="ml-2 bg-indigo-100 text-indigo-700 px-3 rounded hover:bg-indigo-200 text-xs btn-transition"><i class="fas fa-save"></i></button>
          </div>
          <div id="hours-status" class="text-green-600 text-xs mt-1 hidden"></div>
        </div>
        <div>
          <label class="font-semibold">Redémarrage & Mises à jour</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow space-y-3">
            <button onclick="simulateReboot()" class="bg-red-100 text-red-700 py-1 px-4 rounded hover:bg-red-200 btn-transition"><i class="fas fa-sync-alt animate-spin" id="reboot-spin" style="display:none"></i> Reboot à distance</button>
            <button onclick="simulateUpdate()" class="bg-indigo-100 text-indigo-700 py-1 px-4 rounded hover:bg-indigo-200 btn-transition"><i class="fas fa-arrow-up" id="update-spin" style="display:none"></i> Lancer la mise à jour</button>
            <div id="system-action-msg" class="text-xs text-green-700"></div>
          </div>
        </div>
      </div>
      <div class="mt-6">
        <label class="font-semibold">Contrôle affichage en temps réel</label>
        <div class="bg-gray-50 rounded mt-2 p-4 shadow flex items-center gap-3 flex-wrap">
          <button onclick="notifyDisplay('rafraichissement')" class="bg-indigo-600 text-white py-1 px-4 rounded btn-transition">Forcer rafraîchissement</button>
          <button onclick="notifyDisplay('accueil')" class="border border-indigo-200 text-indigo-700 py-1 px-4 rounded btn-transition">Afficher écran d'accueil</button>
          <button onclick="notifyDisplay('veille')" class="border border-indigo-200 text-indigo-700 py-1 px-4 rounded btn-transition">Mode veille</button>
          <span class="text-green-700 text-xs ml-3"><i class="fas fa-check-circle"></i> État actuel : <span id="system-status">OPÉRATIONNEL</span></span>
        </div>
      </div>
    </section>

    <!-- Suivi & Statistiques -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.22s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-chart-bar"></i> Suivi & Statistiques
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
        <div>
          <div class="bg-gray-50 rounded p-4 shadow text-center">
            <div id="users-day" class="font-bold text-xl text-indigo-600">128</div>
            <div class="text-xs text-gray-500">Nombre usagers / jour</div>
          </div>
        </div>
        <div>
          <div class="bg-gray-50 rounded p-4 shadow text-center">
            <div id="ops-month" class="font-bold text-xl text-indigo-600">356</div>
            <div class="text-xs text-gray-500">Opérations ce mois</div>
          </div>
        </div>
        <div>
          <div class="bg-gray-50 rounded p-4 shadow text-center">
            <div id="eval-global" class="font-bold text-xl text-indigo-600">4.7 / 5</div>
            <div class="text-xs text-gray-500">Évaluation utilisateurs</div>
          </div>
        </div>
      </div>
      <div class="mt-8 flex flex-wrap gap-10">
        <div class="w-full md:w-2/3">
          <canvas id="usageChart" height="110"></canvas>
        </div>
        <div class="w-full md:w-1/3">
          <form id="feedback-form" class="bg-gray-50 rounded p-4 shadow">
            <label class="block font-semibold mb-2">Feedback utilisateur</label>
            <textarea id="feedback" class="border rounded w-full p-2 mb-2" rows="2" placeholder="Votre avis…"></textarea>
            <div class="flex gap-2 items-center">
              <input type="number" id="note" min="1" max="5" value="5" class="border rounded px-2 w-16 text-center" title="Note (1-5)"/>
              <span class="text-xs text-gray-500">/ 5</span>
              <button class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm hover:bg-indigo-200 btn-transition flex gap-1 items-center"><i class="fas fa-paper-plane"></i> Envoyer</button>
            </div>
            <div id="feedback-msg" class="text-xs text-green-700 mt-2 hidden"></div>
          </form>
        </div>
      </div>
    </section>

    <!-- Maintenance & Support -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.25s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-tools"></i> Maintenance & Support
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="font-semibold">Incidents / Bugs</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <ul id="incident-list" class="text-xs"></ul>
            <div class="mt-3 flex gap-2">
              <input id="incident-input" type="text" class="border rounded px-2 py-1 flex-1" placeholder="Nouvel incident / bug">
              <button onclick="addIncident()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-sm hover:bg-indigo-200 btn-transition"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div>
          <label class="font-semibold">Outils de diagnostic</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <button onclick="scanDiagnostic()" id="diagnostic-btn" class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded hover:bg-indigo-200 text-sm mb-2 btn-transition"><i class="fas fa-stethoscope"></i> Scanner l'état système</button>
            <div id="diagnostic-msg" class="text-xs text-gray-700 mt-1">Dernier diagnostic : Aucun problème détecté.</div>
          </div>
        </div>
      </div>
      <div class="mt-6">
        <label class="font-semibold">Historique des interventions</label>
        <div class="bg-gray-50 rounded mt-2 p-4 shadow">
          <table class="table-auto w-full text-xs" id="interventions-table">
            <thead>
              <tr class="text-left border-b">
                <th>Date</th>
                <th>Intervention</th>
                <th>Technicien</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dynamic rows -->
            </tbody>
          </table>
          <div class="mt-2 flex gap-2">
            <input id="new-intervention-date" type="date" class="border rounded px-2 py-1 text-xs w-32">
            <input id="new-intervention-label" type="text" placeholder="Intervention" class="border rounded px-2 py-1 text-xs flex-1">
            <input id="new-intervention-tech" type="text" placeholder="Technicien" class="border rounded px-2 py-1 text-xs w-32">
            <button onclick="addIntervention()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-xs hover:bg-indigo-200 btn-transition"><i class="fas fa-plus"></i></button>
          </div>
        </div>
      </div>
    </section>

    <!-- Gestion des utilisateurs -->
    <section class="section bg-white rounded-lg shadow-md p-7 mb-8 fadeInUp" style="animation-delay:.28s">
      <h2 class="text-2xl font-semibold mb-5 flex items-center gap-2 text-indigo-700">
        <i class="fas fa-users"></i> Gestion des utilisateurs
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
        <div>
          <label class="font-semibold">Comptes utilisateurs</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <table class="table-auto w-full text-xs" id="users-table">
              <thead>
                <tr class="text-left border-b">
                  <th>Utilisateur</th>
                  <th>Rôle</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <!-- Dynamic rows -->
              </tbody>
            </table>
            <div class="mt-3 flex gap-2">
              <input id="user-name-input" type="text" placeholder="Nom utilisateur" class="border rounded px-2 py-1 flex-1 text-xs">
              <select id="user-role-select" class="border rounded px-2 py-1 text-xs">
                <option>Administrateur</option>
                <option>Éditeur</option>
                <option>Technicien</option>
              </select>
              <button onclick="addUser()" class="bg-indigo-100 text-indigo-700 px-3 rounded text-sm hover:bg-indigo-200 btn-transition"><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
        <div>
          <label class="font-semibold">Suivi de l'activité</label>
          <div class="bg-gray-50 rounded mt-2 p-4 shadow">
            <ul id="user-activity-list" class="text-xs"></ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="w-full text-center py-8 text-sm text-gray-400">
      &copy; 2024 Administration Kiosque. Interface optimisée pour impression PDF continue.
    </footer>
  </main>

  <script>
    // ----------------------------
    // AUTH MANAGEMENT - NOUVEAU
    // ----------------------------
    // Stockage des utilisateurs enregistrés (simulé)
    let registeredUsers = [
      { email: 'admin@admin.com', password: 'admin123', firstName: 'Admin', lastName: 'Principal', role: 'admin' }
    ];
    
    // État d'authentification
    let authState = {
      isLoggedIn: false,
      currentUser: null,
      currentRole: null
    };
    
    // Navigation entre les écrans d'authentification
    document.getElementById('goto-signup-btn').addEventListener('click', function() {
      document.getElementById('signin-screen').style.display = 'none';
      document.getElementById('signup-screen').style.display = 'block';
    });
    
    document.getElementById('goto-signin-btn').addEventListener('click', function() {
      document.getElementById('signup-screen').style.display = 'none';
      document.getElementById('signin-screen').style.display = 'block';
    });
    
    document.getElementById('forgot-password-btn').addEventListener('click', function() {
      document.getElementById('signin-form').style.display = 'none';
      document.getElementById('forgot-password-box').style.display = 'block';
    });
    
    document.getElementById('back-to-signin').addEventListener('click', function() {
      document.getElementById('forgot-password-box').style.display = 'none';
      document.getElementById('signin-form').style.display = 'block';
    });
    
    // Gestion de la force du mot de passe
    document.getElementById('signup-password').addEventListener('input', function(e) {
      const password = e.target.value;
      const strengthBar = document.getElementById('password-strength-bar');
      const strengthText = document.getElementById('password-strength-text');
      
      // Évaluation de la force du mot de passe
      let strength = 0;
      if (password.length >= 8) strength += 1;
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
      if (password.match(/\d/)) strength += 1;
      if (password.match(/[^a-zA-Z\d]/)) strength += 1;
      
      // Mise à jour de l'indicateur visuel
      strengthBar.className = 'strength-indicator';
      
      if (password.length === 0) {
        strengthBar.classList.add(''); // Pas de classe
        strengthText.textContent = 'Non défini';
      } else if (strength < 2) {
        strengthBar.classList.add('weak');
        strengthText.textContent = 'Faible';
        strengthText.className = 'text-red-600';
      } else if (strength === 2) {
        strengthBar.classList.add('medium');
        strengthText.textContent = 'Moyen';
        strengthText.className = 'text-yellow-600';
      } else if (strength === 3) {
        strengthBar.classList.add('strong');
        strengthText.textContent = 'Fort';
        strengthText.className = 'text-green-600';
      } else {
        strengthBar.classList.add('very-strong');
        strengthText.textContent = 'Très fort';
        strengthText.className = 'text-green-700';
      }
    });
    
    // Validation du formulaire d'inscription
    document.getElementById('signup-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Récupération des valeurs du formulaire
      const firstName = document.getElementById('signup-firstname').value.trim();
      const lastName = document.getElementById('signup-lastname').value.trim();
      const email = document.getElementById('signup-email').value.trim();
      const role = document.getElementById('signup-role').value;
      const password = document.getElementById('signup-password').value;
      const confirmPassword = document.getElementById('signup-confirm-password').value;
      const termsAccepted = document.getElementById('terms-checkbox').checked;
      
      // Réinitialisation des messages d'erreur
      document.querySelectorAll('.auth-input').forEach(input => input.classList.remove('error'));
      document.querySelectorAll('[id$="-error"]').forEach(div => div.classList.add('hidden'));
      
      // Validation des champs
      let isValid = true;
      
      if (firstName === '') {
        document.getElementById('signup-firstname').classList.add('error');
        document.getElementById('signup-firstname-error').textContent = 'Le prénom est requis';
        document.getElementById('signup-firstname-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (lastName === '') {
        document.getElementById('signup-lastname').classList.add('error');
        document.getElementById('signup-lastname-error').textContent = 'Le nom est requis';
        document.getElementById('signup-lastname-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (email === '' || !email.includes('@')) {
        document.getElementById('signup-email').classList.add('error');
        document.getElementById('signup-email-error').textContent = 'Email invalide';
        document.getElementById('signup-email-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (role === '') {
        document.getElementById('signup-role').classList.add('error');
        document.getElementById('signup-role-error').textContent = 'Veuillez sélectionner un rôle';
        document.getElementById('signup-role-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (password === '' || password.length < 8) {
        document.getElementById('signup-password').classList.add('error');
        document.getElementById('signup-password-error').textContent = 'Le mot de passe doit contenir au moins 8 caractères';
        document.getElementById('signup-password-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (confirmPassword === '' || confirmPassword !== password) {
        document.getElementById('signup-confirm-password').classList.add('error');
        document.getElementById('signup-confirm-password-error').textContent = 'Les mots de passe ne correspondent pas';
        document.getElementById('signup-confirm-password-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (!termsAccepted) {
        document.getElementById('terms-checkbox').classList.add('error');
        isValid = false;
      }
      
      // Si le formulaire est valide, traitement de l'inscription
      if (isValid) {
        // Affichage du spinner pendant le traitement
        document.getElementById('signup-btn-text').textContent = 'Création en cours...';
        document.getElementById('signup-spinner').classList.remove('hidden');
        
        // Simulation d'un délai de traitement
        setTimeout(function() {
          // Vérification si l'email existe déjà
          const emailExists = registeredUsers.some(user => user.email === email);
          
          if (emailExists) {
            document.getElementById('signup-email').classList.add('error');
            document.getElementById('signup-email-error').textContent = 'Cet email est déjà utilisé';
            document.getElementById('signup-email-error').classList.remove('hidden');
            
            document.getElementById('signup-btn-text').textContent = 'Créer un compte';
            document.getElementById('signup-spinner').classList.add('hidden');
          } else {
            // Enregistrement du nouvel utilisateur
            registeredUsers.push({
              email: email,
              password: password,
              firstName: firstName,
              lastName: lastName,
              role: role
            });
            
            // Réinitialisation du formulaire
            document.getElementById('signup-form').reset();
            
            // Affichage du message de succès
            document.getElementById('signup-success-message').classList.remove('hidden');
            
            // Redirection vers la page de connexion après un délai
            setTimeout(function() {
              document.getElementById('signup-screen').style.display = 'none';
              document.getElementById('signin-screen').style.display = 'block';
              document.getElementById('signup-success-message').classList.add('hidden');
              document.getElementById('signup-btn-text').textContent = 'Créer un compte';
              document.getElementById('signup-spinner').classList.add('hidden');
            }, 2000);
          }
        }, 1500);
      }
    });
    
    // Validation du formulaire de connexion
    document.getElementById('signin-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Récupération des valeurs du formulaire
      const email = document.getElementById('signin-email').value.trim();
      const password = document.getElementById('signin-password').value;
      const rememberMe = document.getElementById('remember-me').checked;
      
      // Réinitialisation des messages d'erreur
      document.querySelectorAll('.auth-input').forEach(input => input.classList.remove('error'));
      document.querySelectorAll('[id$="-error"]').forEach(div => div.classList.add('hidden'));
      
      // Validation des champs
      let isValid = true;
      
      if (email === '' || !email.includes('@')) {
        document.getElementById('signin-email').classList.add('error');
        document.getElementById('signin-email-error').textContent = 'Email invalide';
        document.getElementById('signin-email-error').classList.remove('hidden');
        isValid = false;
      }
      
      if (password === '') {
        document.getElementById('signin-password').classList.add('error');
        document.getElementById('signin-password-error').textContent = 'Veuillez entrer votre mot de passe';
        document.getElementById('signin-password-error').classList.remove('hidden');
        isValid = false;
      }
      
      // Si le formulaire est valide, traitement de la connexion
      if (isValid) {
        // Affichage du spinner pendant le traitement
        document.getElementById('signin-btn-text').textContent = 'Connexion...';
        document.getElementById('signin-spinner').classList.remove('hidden');
        
        // Simulation d'un délai de traitement
        setTimeout(function() {
          // Vérification des identifiants
          const user = registeredUsers.find(user => user.email === email && user.password === password);
          
          if (user) {
            // Mise à jour de l'état d'authentification
            authState.isLoggedIn = true;
            authState.currentUser = user.firstName + ' ' + user.lastName;
            authState.currentRole = user.role;
            
            // Affichage du message de succès
            document.getElementById('signin-success-message').classList.remove('hidden');
            
            // Transition vers l'interface principale après un délai
            setTimeout(function() {
              document.getElementById('signin-screen').style.display = 'none';
              
              // Mise à jour des informations utilisateur dans l'interface
              document.getElementById('user-info').classList.remove('hidden');
              document.getElementById('current-user').textContent = authState.currentUser;
              
              let roleText = '';
              switch(user.role) {
                case 'admin': roleText = 'Administrateur'; break;
                case 'editor': roleText = 'Éditeur'; break;
                case 'tech': roleText = 'Technicien'; break;
                default: roleText = user.role;
              }
              document.getElementById('current-role').textContent = roleText;
              
              // Ajout d'un log de connexion
              let logsText = document.getElementById('logs-text');
              logsText.value += (logsText.value ? '\n' : '') + 
                (new Date().toLocaleString()) + " : Connexion de " + authState.currentUser;
              
              // Réinitialisation du formulaire et des états
              document.getElementById('signin-form').reset();
              document.getElementById('signin-success-message').classList.add('hidden');
              document.getElementById('signin-btn-text').textContent = 'Se connecter';
              document.getElementById('signin-spinner').classList.add('hidden');
              
              // Ajout dans les activités utilisateur
              userActivities.unshift({
                act: "s'est connecté(e)", 
                user: authState.currentUser, 
                date: new Date().toLocaleDateString()
              });
              renderUserActivity();
            }, 1500);
          } else {
            // Affichage du message d'erreur
            document.getElementById('signin-email').classList.add('error');
            document.getElementById('signin-password').classList.add('error');
            document.getElementById('signin-password-error').textContent = 'Email ou mot de passe incorrect';
            document.getElementById('signin-password-error').classList.remove('hidden');
            
            // Secousse d'erreur sur le formulaire
            const form = document.getElementById('signin-form');
            form.classList.add('shake');
            setTimeout(() => form.classList.remove('shake'), 400);
            
            // Réinitialisation de l'état du bouton
            document.getElementById('signin-btn-text').textContent = 'Se connecter';
            document.getElementById('signin-spinner').classList.add('hidden');
          }
        }, 1200);
      }
    });
    
    // Traitement du formulaire de récupération de mot de passe
    document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const email = document.getElementById('recovery-email').value.trim();
      
      // Validation de l'email
      if (email === '' || !email.includes('@')) {
        document.getElementById('recovery-email').classList.add('error');
        document.getElementById('recovery-email-error').textContent = 'Email invalide';
        document.getElementById('recovery-email-error').classList.remove('hidden');
        return;
      }
      
      // Affichage du spinner pendant le traitement
      document.getElementById('recovery-btn-text').textContent = 'Envoi en cours...';
      document.getElementById('recovery-spinner').classList.remove('hidden');
      
      // Simulation d'un délai de traitement
      setTimeout(function() {
        // Réinitialisation du formulaire
        document.getElementById('forgot-password-form').reset();
        
        // Affichage d'un message temporaire
        const emailError = document.getElementById('recovery-email-error');
        emailError.textContent = 'Un lien de récupération a été envoyé à votre adresse email.';
        emailError.classList.remove('text-red-500', 'hidden');
        emailError.classList.add('text-green-500');
        
        // Réinitialisation de l'état du bouton
        document.getElementById('recovery-btn-text').textContent = 'Envoyer le lien';
        document.getElementById('recovery-spinner').classList.add('hidden');
        
        // Retour au formulaire de connexion après un délai
        setTimeout(function() {
          document.getElementById('forgot-password-box').style.display = 'none';
          document.getElementById('signin-form').style.display = 'block';
          emailError.classList.add('hidden');
        }, 3000);
      }, 1500);
    });
    
    // Gestion de la déconnexion
    document.getElementById('logout-btn').addEventListener('click', function() {
      // Réinitialisation de l'état d'authentification
      authState.isLoggedIn = false;
      authState.currentUser = null;
      authState.currentRole = null;
      
      // Masquage des informations utilisateur
      document.getElementById('user-info').classList.add('hidden');
      
      // Ajout d'un log de déconnexion
      let logsText = document.getElementById('logs-text');
      logsText.value += (logsText.value ? '\n' : '') + 
        (new Date().toLocaleString()) + " : Déconnexion";
      
      // Affichage de l'écran de connexion
      document.getElementById('signin-screen').style.display = 'block';
    });

    // ----------------------------
    // 1. Dynamique : Pages & Preview
    // ----------------------------
    let pageList = [
      {title:'Accueil'}, {title:'Services'}
    ];
    function renderPages() {
      let ul = document.getElementById('pages-list');
      ul.innerHTML = "";
      pageList.forEach((p, i) => {
        ul.innerHTML += `<li class="flex justify-between items-center"><span>${p.title}</span>
            <span>
              <button type="button" class="text-green-600 text-xs mx-1" onclick="previewContent('${p.title}')"><i class="fas fa-eye"></i></button>
              <button type="button" class="text-blue-600 text-xs mx-1" onclick="editPage(${i})"><i class="fas fa-edit"></i></button>
              <button type="button" class="text-red-600 text-xs mx-1" onclick="delPage(${i})"><i class="fas fa-trash"></i></button>
            </span></li>`;
      });
    }
    function addPage() {
      const v = document.getElementById('new-page-input').value.trim();
      if (v.length) {
        pageList.push({title: v});
        renderPages();
        document.getElementById('new-page-input').value = "";
      }
    }
    function previewContent(page) {
      let node = document.getElementById('preview-content');
      node.innerHTML = 'Prévisualisation de la page <span class="font-semibold">'+page+'</span>';
      node.classList.remove('fadeInUp');
      void node.offsetWidth; // trick to re-trigger animation
      node.classList.add('fadeInUp');
    }
    function editPage(i) {
      let t = prompt("Nouveau nom de page :", pageList[i].title);
      if (t) {pageList[i].title=t; renderPages();}
    }
    function delPage(i) {pageList.splice(i,1); renderPages();}
    renderPages();

    // -------------------
    // 2. Bannière annonces
    // -------------------
    let banners = [{text:"Prochaine maintenance programmée le 15/09"}];
    function renderBanners() {
      let ul = document.getElementById('banner-list');
      ul.innerHTML = "";
      banners.forEach((b, i) => {
        ul.innerHTML += `<li class="flex justify-between items-center bg-white rounded p-2 mb-1">${b.text}
          <button class="text-red-600" onclick="delBanner(${i})"><i class="fas fa-trash"></i></button>
        </li>`;
      });
    }
    function addBanner() {
      const txt = document.getElementById('new-banner-input').value.trim();
      if (txt) {
        banners.unshift({text:txt});
        renderBanners();
        document.getElementById('new-banner-input').value="";
      }
    }
    function delBanner(i) { banners.splice(i,1); renderBanners(); }
    renderBanners();

    // ------------
    // 3. Médias
    // ------------
    let mediaFiles = [
      {name:"banniere.jpg"},
      {name:"doc-info.pdf"}
    ];
    function renderMedia() {
      let list = document.getElementById('media-list');
      list.innerHTML = '';
      mediaFiles.forEach((m,i) => {
        list.innerHTML += `<div class="border rounded p-2 text-xs bg-white flex items-center gap-1">
          ${m.name}
          <button class="text-red-500" onclick="delMedia(${i})"><i class="fas fa-trash"></i></button>
        </div>`;
      });
    }
    function addMedia() {
      const name = document.getElementById('media-file').value.trim();
      if (name) {
        mediaFiles.push({name:name});
        renderMedia();
        document.getElementById('media-file').value="";
      }
    }
    function delMedia(i) { mediaFiles.splice(i,1); renderMedia();}
    renderMedia();

    // -------------
    // 4. Services
    // -------------
    let services = [
      {name:"Paiement"},
      {name:"Consultation"},
      {name:"Impression de documents"}
    ];
    function renderServices() {
      let ul = document.getElementById('service-list');
      ul.innerHTML = '';
      services.forEach((s, i) => {
        ul.innerHTML += `<li class="flex justify-between items-center py-1">
            <span>${s.name}</span>
            <button onclick="delService(${i})" class="text-red-600"><i class="fas fa-trash"></i></button>
          </li>`;
      });
    }
    function addService() {
      let v = document.getElementById('new-service-input').value.trim();
      if (v) {
        services.push({name:v});
        renderServices();
        document.getElementById('new-service-input').value='';
      }
    }
    function delService(i) {services.splice(i,1); renderServices();}
    renderServices();

    // ---------------
    // 5. Journal/Logs
    // ---------------
    function addLog() {
      let t = document.getElementById('logs-text');
      t.value += (t.value ? '\n':'') + (new Date().toLocaleString()) + " : Action manuelle";
    }
    function clearLogs() {
      if (confirm('Confirmer effacement des logs ?')) document.getElementById('logs-text').value = "";
    }

    // ---------------
    // 6. Ops Table
    // ---------------
    let ops = [
      {date:'12/06/2024 09:48',serv:"Paiement",user:"userA",statut:"Succès"},
      {date:'12/06/2024 09:31',serv:"Impression",user:"userB",statut:"Erreur"}
    ];
    function renderOps() {
      let tb = document.getElementById('operations-table').getElementsByTagName('tbody')[0];
      tb.innerHTML='';
      ops.forEach(o=>{
        tb.innerHTML += `<tr>
          <td>${o.date}</td>
          <td>${o.serv}</td>
          <td>${o.user}</td>
          <td><span class="px-2 py-1 rounded ${o.statut==='Succès'?'bg-green-200 text-green-700':'bg-red-200 text-red-700'}">${o.statut}</span></td>
        </tr>`;
      });
    }
    renderOps();

    // -------------------
    // 7. Maintenance - incidents & intervention
    // -------------------
    let incidentList=[{label:"Ecran figé - 10/06/2024"},{label:"Problème d'impression - 08/06/2024"}];
    function renderIncidents() {
      let ul = document.getElementById('incident-list');
      ul.innerHTML='';
      incidentList.forEach((i,idx)=>{
        ul.innerHTML += `<li class="flex justify-between items-center py-1">
          <span>${i.label}</span>
          <button onclick="resolveIncident(${idx})" class="text-green-600 text-xs"><i class="fas fa-check"></i> Résolu</button>
        </li>`;
      });
    }
    function addIncident() {
      let v = document.getElementById('incident-input').value.trim();
      if (v) {incidentList.unshift({label:v}); renderIncidents(); document.getElementById('incident-input').value='';}
    }
    function resolveIncident(idx){incidentList.splice(idx,1);renderIncidents();}
    renderIncidents();

    let interventions = [
      {date:"10/06/2024",label:"Réparation écran",tech:"techA"},
      {date:"08/06/2024",label:"Maintenance imprimante",tech:"techB"}
    ];
    function renderInterventions() {
      let tb = document.getElementById('interventions-table').getElementsByTagName('tbody')[0];
      tb.innerHTML='';
      interventions.forEach(row => {
        tb.innerHTML += `<tr><td>${row.date}</td><td>${row.label}</td><td>${row.tech}</td></tr>`;
      });
    }
    function addIntervention() {
      let d = document.getElementById('new-intervention-date').value;
      let l = document.getElementById('new-intervention-label').value;
      let t = document.getElementById('new-intervention-tech').value;
      if (d && l && t) {
        interventions.unshift({date: d, label:l, tech:t});
        renderInterventions();
        document.getElementById('new-intervention-date').value='';
        document.getElementById('new-intervention-label').value='';
        document.getElementById('new-intervention-tech').value='';
      }
    }
    renderInterventions();

    // -------------------
    // 8. Gestion des utilisateurs dynamique
    // -------------------
    let users = [
      {name:"admin", role:"Administrateur"},
      {name:"editor", role:"Éditeur"},
      {name:"tech1", role:"Technicien"}
    ];
    function renderUsers() {
      let tb = document.getElementById('users-table').getElementsByTagName('tbody')[0];
      tb.innerHTML = '';
      users.forEach((u, i) => {
        tb.innerHTML += `<tr><td>${u.name}</td><td>${u.role}</td>
          <td><button class="text-red-600" onclick="delUser(${i})"><i class="fas fa-trash"></i></button></td>
        </tr>`;
      });
    }
    function addUser() {
      let name = document.getElementById('user-name-input').value.trim();
      let role = document.getElementById('user-role-select').value;
      if (name) {
        users.push({name, role});
        renderUsers();
        document.getElementById('user-name-input').value = "";
      }
    }
    function delUser(i){users.splice(i,1); renderUsers();}
    renderUsers();

    // Activity list
    let userActivities = [
      {act:"a publié une annonce", user:"admin", date:"12/06/2024"},
      {act:"a mis à jour une page", user:"editor", date:"12/06/2024"},
      {act:"a effectué une intervention", user:"tech1", date:"11/06/2024"}
    ];
    function renderUserActivity() {
      let ul = document.getElementById('user-activity-list');
      ul.innerHTML = '';
      userActivities.forEach(a => {
        ul.innerHTML += `<li><b>${a.user}</b> ${a.act} – ${a.date}</li>`;
      });
    }
    renderUserActivity();

    function changeRoleDynamic() {
      let uname = document.getElementById('change-user-role').value.trim();
      let nrole = document.getElementById('role-select').value;
      let idx = users.findIndex(u=>u.name===uname);
      let alertTag = document.getElementById('role-change-alert');
      if(idx>-1){
        users[idx].role = nrole;
        renderUsers();
        alertTag.textContent = `Rôle de ${uname} mis à jour !`;
        alertTag.classList.remove('hidden');
        setTimeout(()=>alertTag.classList.add('hidden'),1800);
      } else {
        alertTag.textContent = `Utilisateur non trouvé`;
        alertTag.classList.remove('hidden');
        setTimeout(()=>alertTag.classList.add('hidden'),1800);
      }
    }

    // -------------------
    // 9. Configuration système
    // -------------------
    function saveHours() {
      let op = document.getElementById('opening').value;
      let cl = document.getElementById('closing').value;
      let s = document.getElementById('hours-status');
      s.textContent = `Horaires mis à jour : ${op} à ${cl}`;
      s.classList.remove('hidden');
      setTimeout(()=>s.classList.add('hidden'),1400);
    }
    // Simulate reboot and update
    function simulateReboot() {
      let msg = document.getElementById('system-action-msg');
      msg.textContent = "Reboot à distance en cours ...";
      let icon = document.getElementById('reboot-spin');
      icon.style.display = 'inline-block';
      setTimeout(()=>{
        icon.style.display = 'none';
        msg.textContent = "Reboot effectué avec succès!";
        setTimeout(()=>msg.textContent='',1600);
      }, 1700);
    }
    function simulateUpdate() {
      let msg = document.getElementById('system-action-msg');
      msg.textContent = "Mise à jour en cours ...";
      let icon = document.getElementById('update-spin');
      icon.style.display = 'inline-block';
      setTimeout(()=>{
        icon.style.display = 'none';
        msg.textContent = "Mise à jour réussie !";
        setTimeout(()=>msg.textContent='',1600);
      }, 1850);
    }
    function notifyDisplay(action){
      let status = document.getElementById('system-status');
      let msg = {rafraichissement: "Rafraîchi!", accueil:"Accueil affiché!", veille:"En veille."};
      status.textContent = msg[action];
      setTimeout(()=>status.textContent="OPÉRATIONNEL",1400);
    }

    // -------------------
    // 10. Diagnostic
    // -------------------
    function scanDiagnostic() {
      let btn = document.getElementById('diagnostic-btn');
      let msg = document.getElementById('diagnostic-msg');
      btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Scanning...';
      setTimeout(()=>{
        btn.innerHTML = '<i class="fas fa-stethoscope"></i> Scanner l\'état système';
        msg.textContent = "Diagnostic : Système stable. Aucun problème détecté.";
      }, 1500);
    }

    // -------------------
    // 11. Statistiques Chart
    // -------------------
    let usageChart;
    function updateStats() {
      // Simule stats dynamiques
      let usersDay = 120+Math.round(Math.random()*25);
      let opsMonth = 340+Math.round(Math.random()*23);
      let evalScore = Math.round((4.5 + Math.random()*0.5)*10)/10;
      document.getElementById('users-day').textContent = usersDay;
      document.getElementById('ops-month').textContent = opsMonth;
      document.getElementById('eval-global').textContent = evalScore + " / 5";
      if(usageChart) {
        let arr = Array.from({length: 7}, ()=>Math.round(18+Math.random()*65));
        usageChart.data.datasets[0].data = arr;
        usageChart.update();
      }
    }
    window.onload = function() {
      let ctx = document.getElementById('usageChart').getContext('2d');
      usageChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
          datasets: [{
            label: 'Usagers',
            data: [22, 35, 40, 51, 68, 70, 55],
            fill: true,
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99,102,241,0.12)',
            tension: 0.35,
            pointRadius: 3,
            pointBorderWidth: 1.2
          }]
        },
        options: {
          plugins: { legend: { display: false }},
          scales: {
            x: { display: true, grid: { display: false }},
            y: { display: true, beginAtZero: true, grid: { color: '#E5E7EB' } }
          },
          maintainAspectRatio: false,
        }
      });
      renderPages(); renderBanners(); renderMedia(); renderServices(); renderIncidents(); renderInterventions(); renderUsers(); renderUserActivity(); renderOps();
      updateStats();
      setInterval(updateStats, 3000); // Mise à jour toutes les 3 secondes
    };

    // -------------------
    // 12. Feedback - note dynamique et message
    // -------------------
    document.getElementById('feedback-form').onsubmit = function(e) {
      e.preventDefault();
      let feedback = document.getElementById('feedback').value.trim();
      let note = document.getElementById('note').value;
      if(feedback && note >= 1 && note <= 5){
        document.getElementById('feedback-msg').textContent = "Merci de votre retour!";
        document.getElementById('feedback-msg').classList.remove('hidden');
        setTimeout(()=>document.getElementById('feedback-msg').classList.add('hidden'), 1800);
        document.getElementById('feedback').value = "";
        document.getElementById('note').value = "5";
      }
    };

    // -------------------
    // 13. Login Demo/Ajax Simulation
    // -------------------
    document.getElementById('login-form').onsubmit = function(e) {
      e.preventDefault();
      let uname = document.getElementById('username').value.trim();
      let pwd = document.getElementById('password').value;
      let alertDiv = document.getElementById('login-alert');
      alertDiv.classList.remove('hidden');
      alertDiv.classList.add('fadeInUp');
      setTimeout(function(){
        // Simule une authentification AJAX
        if(uname === 'admin' && pwd === 'admin123') {
          alertDiv.classList.add('text-green-600');
          alertDiv.textContent = "Connexion réussie !";
        } else {
          alertDiv.classList.remove('text-green-600');
          alertDiv.textContent = "Nom d'utilisateur ou mot de passe incorrect.";
        }
        setTimeout(()=>alertDiv.classList.add('hidden'),1800);
      }, 900);
    };
  </script>
</body>
</html>