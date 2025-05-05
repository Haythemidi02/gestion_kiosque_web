<?php
session_start();

// Database configuration (XAMPP defaults)
$host = 'localhost';
$dbname = 'kiosque';
$username = 'root';
$password = ''; // Empty for XAMPP default

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginEmail'], $_POST['loginPassword'])) {
    $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['loginPassword'];

    // Query to find user by email
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: index_service.html");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnergyFuel - Station Service</title>
    <link rel="stylesheet" href="style_sign.css">
</head>
<body>
    <header>
        <div class="logo">Energy<span>Fuel</span></div>
        <nav>
            <ul>
                <li><a href="index_acceuil.html" id="navHome">Accueil</a></li>
                <li><a href="index_service.html" id="navServices">Services</a></li>
                <li><a href="index_classement.html" id="navLeaderboard">Classement</a></li>
                <li><a href="index_about_us.html" id="navAccount">about us</a></li>
            </ul>
        </nav>
    </header>
    <!-- formulaire de connexion -->
    <div id="authSection" class="container">
        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="auth-form active" id="loginForm" method="POST">
            <div class="form-group">
                <label for="loginEmail">Email <span class="required">*</span></label>
                <input type="email" id="loginEmail" name="loginEmail" placeholder="Votre email" value="<?php echo isset($_POST['loginEmail']) ? htmlspecialchars($_POST['loginEmail']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Mot de passe <span class="required">*</span></label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Votre mot de passe" required>
            </div>
            <section>
                <button type="submit" class="btn btn-block" id="loginButton">Se connecter</button>
            </section>
        </form>
    </div>
    <footer class="minimised">
        <p>© 2025 EnergyFuel. Tous droits réservés.</p>
        <p>Adresse : 5051 moknine, monastir</p>
        <p>Téléphone : (+216) 27 312 507 | Email : <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="c7efe6fef3efe2eaa9eee3eec7e2e9f4eeaaf2eae6a9f3e9">[email&#160;protected]</a></p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* ========== Gestion commune ========== */
            // Ajout de Font Awesome
            const fontAwesome = document.createElement('link');
            fontAwesome.rel = 'stylesheet';
            fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
            document.head.appendChild(fontAwesome);

            // Animation d'entrée pour les formulaires
            function animateForm(form) {
                form.style.opacity = '0';
                form.style.transform = 'translateY(20px)';
                form.style.transition = 'all 0.5s ease-out';
                setTimeout(() => {
                    form.style.opacity = '1';
                    form.style.transform = 'translateY(0)';
                }, 100);
            }

            /* ========== INSCRIPTION (Sign Up) ========== */
            const registerForm = document.getElementById('registerForm');
            if (registerForm) {
                animateForm(registerForm);
                const registerButton = document.getElementById('registerButton');
                const requiredFields = document.querySelectorAll('#registerForm [required]');

                // Validation en temps réel
                requiredFields.forEach(field => {
                    field.addEventListener('input', () => validateField(field));
                    field.addEventListener('blur', () => validateField(field));
                });

                function validateField(field) {
                    const errorElement = document.getElementById(`${field.id}Error`) || createErrorElement(field);

                    if (field.type === 'radio') {
                        validateRadioGroup(field.name);
                        return;
                    }

                    if (field.checkValidity()) {
                        field.classList.remove('invalid');
                        field.classList.add('valid');
                        errorElement.textContent = '';
                    } else {
                        field.classList.remove('valid');
                        field.classList.add('invalid');
                        showValidationError(field, errorElement);
                    }
                }

                function validateRadioGroup(name) {
                    const radioGroup = document.querySelectorAll(`input[name="${name}"]`);
                    const errorElement = document.getElementById(`${name}Error`) || createErrorElement(radioGroup[0], name);
                    const isChecked = Array.from(radioGroup).some(radio => radio.checked);

                    radioGroup.forEach(radio => {
                        radio.classList.toggle('invalid', !isChecked);
                        radio.classList.toggle('valid', isChecked);
                    });

                    errorElement.textContent = isChecked ? '' : 'Veuillez sélectionner une option';
                }

                function createErrorElement(field, name = null) {
                    const errorElement = document.createElement('small');
                    errorElement.id = name ? `${name}Error` : `${field.id}Error`;
                    errorElement.className = 'error-message';
                    errorElement.style.color = 'var(--primary)';
                    errorElement.style.display = 'block';
                    errorElement.style.marginTop = '5px';
                    errorElement.style.fontSize = '0.8rem';

                    if (field.type === 'radio') {
                        field.closest('.form-group').appendChild(errorElement);
                    } else {
                        field.insertAdjacentElement('afterend', errorElement);
                    }

                    return errorElement;
                }

                function showValidationError(field, errorElement) {
                    if (field.validity.valueMissing) {
                        errorElement.textContent = 'Ce champ est obligatoire';
                    } else if (field.validity.typeMismatch) {
                        errorElement.textContent = 'Format incorrect';
                    } else if (field.validity.tooShort) {
                        errorElement.textContent = `Trop court (min ${field.minLength} caractères)`;
                    } else if (field.validity.patternMismatch && field.id === 'immatriculation') {
                        errorElement.textContent = 'Format AA-123-BB ou 1234-A-56';
                    }
                }

                const immatriculationField = document.getElementById('immatriculation');
                if (immatriculationField) {
                    immatriculationField.addEventListener('input', function () {
                        const regex = /^(([A-Za-z]{2}-\d{3}-[A-Za-z]{2})|(\d{4}-[A-Za-z]{1}-\d{2}))$/;
                        this.setCustomValidity(this.value && !regex.test(this.value) ? 'Format valide : AA-123-BB ou 1234-A-56' : '');
                    });
                }

                const passwordField = document.getElementById('registerPassword');
                const confirmPasswordField = document.getElementById('registerPasswordConfirm');

                if (passwordField && confirmPasswordField) {
                    confirmPasswordField.addEventListener('input', function () {
                        this.setCustomValidity(this.value !== passwordField.value ? 'Les mots de passe ne correspondent pas' : '');
                    });
                }

                registerForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    let isValid = true;
                    requiredFields.forEach(field => {
                        if (field.type === 'radio') {
                            validateRadioGroup(field.name);
                            if (!document.querySelector(`input[name="${field.name}"]:checked`)) isValid = false;
                        } else if (!field.checkValidity()) {
                            validateField(field);
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        registerForm.classList.add('shake');
                        setTimeout(() => registerForm.classList.remove('shake'), 500);
                        return;
                    }

                    registerButton.disabled = true;
                    registerButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Création du compte...';

                    setTimeout(() => {
                        window.location.href = 'index_service.html';
                    }, 1500);
                });

                registerButton.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 5px 15px rgba(239, 68, 68, 0.4)';
                });

                registerButton.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            }

            /* ========== CONNEXION (Sign In) ========== */
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                animateForm(loginForm);
                const loginButton = document.getElementById('loginButton');
                const emailField = document.getElementById('loginEmail');
                const passwordField = document.getElementById('loginPassword');

                [emailField, passwordField].forEach(field => {
                    field.addEventListener('input', () => validateField(field));
                });

                function validateField(field) {
                    const errorElement = document.getElementById(`${field.id}Error`) || createErrorElement(field);

                    if (field.checkValidity()) {
                        field.classList.remove('invalid');
                        errorElement.textContent = '';
                    } else {
                        field.classList.add('invalid');
                        showValidationError(field, errorElement);
                    }
                }

                function createErrorElement(field) {
                    const errorElement = document.createElement('small');
                    errorElement.id = `${field.id}Error`;
                    errorElement.className = 'error-message';
                    errorElement.style.color = 'var(--primary)';
                    errorElement.style.display = 'block';
                    errorElement.style.marginTop = '5px';
                    errorElement.style.fontSize = '0.8rem';
                    field.insertAdjacentElement('afterend', errorElement);
                    return errorElement;
                }

                function showValidationError(field, errorElement) {
                    if (field.validity.valueMissing) {
                        errorElement.textContent = 'Ce champ est obligatoire';
                    } else if (field.validity.typeMismatch && field.id === 'loginEmail') {
                        errorElement.textContent = 'Veuillez entrer un email valide';
                    }
                }

                loginForm.addEventListener('submit', function (e) {
                    let isValid = true;
                    [emailField, passwordField].forEach(field => {
                        if (!field.value) {
                            validateField(field);
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        loginForm.classList.add('shake');
                        setTimeout(() => loginForm.classList.remove('shake'), 500);
                    }
                });

                loginButton.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 5px 15px rgba(239, 68, 68, 0.4)';
                });

                loginButton.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            }
        });
    </script>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'93af744a1bfe6751',t:'MTc0NjQzOTg5MS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script>
</body>
</html>