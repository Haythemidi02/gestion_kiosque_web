# Gestion Kiosque Web

Application web PHP/MySQL pour la gestion d'un kiosque de station-service EnergyFuel. Le projet contient une interface client pour consulter les services, produits, carburants, lavage et panier, ainsi qu'un espace d'administration pour gerer les produits, commandes, messages, newsletter et parametres.

## Fonctionnalites

- Page d'accueil client avec presentation des services EnergyFuel
- Catalogue de produits et services
- Gestion du panier et du paiement
- Inscription, connexion et profil utilisateur
- Pages carburant, lavage auto, produits et contact/newsletter
- Espace administrateur securise
- Gestion des produits avec upload d'images
- Consultation des commandes, messages et statistiques
- Parametres de la station: nom, email, telephone, adresse et horaires
- Scripts de creation et d'initialisation de la base de donnees

## Stack technique

- PHP
- MySQL
- PDO
- HTML, CSS, JavaScript

## Structure du projet

```text
.
|-- admin/              # Pages de l'espace administrateur
|-- assets/
|   |-- css/            # Feuilles de style
|   |-- images/         # Images, audio et media
|   `-- js/             # Scripts JavaScript
|-- client/             # Pages publiques et espace utilisateur
|-- core/               # Configuration, connexion DB et logique partagee
|-- includes/           # Headers et footers client/admin
|-- scratch/            # Scripts utilitaires de base de donnees et tests
|-- index.php           # Redirection vers client/accueil.php
`-- README.md
```

## Prerequis

- PHP 8.x recommande
- MySQL ou MariaDB
- Serveur local compatible PHP, par exemple XAMPP, WAMP, Laragon ou le serveur PHP integre
- Extension PHP PDO MySQL activee

## Installation

1. Placez le projet dans le dossier web de votre serveur local.

   Exemple avec XAMPP:

   ```text
   C:\xampp\htdocs\gestion_kiosque_web
   ```

2. Verifiez la configuration de la base de donnees dans `core/config.php`.

   Configuration par defaut:

   ```php
   $host = 'localhost';
   $db   = 'kiosque_db';
   $user = 'root';
   $pass = '';
   ```

3. Creez la base de donnees:

   ```bash
   php scratch/create_db.php
   ```

4. Creez les tables et ajoutez les donnees de demonstration:

   ```bash
   php scratch/seed_db.php
   ```

   Le script cree les tables principales: `users`, `categories`, `products`, `orders`, `order_items`, `messages`, `newsletter`, `admins` et `settings`.

5. Lancez le projet depuis votre serveur local.

   Avec XAMPP/WAMP/Laragon:

   ```text
   http://localhost/gestion_kiosque_web/
   ```

   Avec le serveur PHP integre, depuis la racine du projet:

   ```bash
   php -S localhost:8000
   ```

   Puis ouvrez:

   ```text
   http://localhost:8000/
   ```

## Acces

### Interface client

```text
http://localhost/gestion_kiosque_web/client/accueil.php
```

La racine `index.php` redirige automatiquement vers cette page.

### Interface administrateur

```text
http://localhost/gestion_kiosque_web/admin/login.php
```

Identifiants par defaut apres initialisation:

```text
Utilisateur: admin
Mot de passe: admin123
```

Changez ce mot de passe avant toute utilisation reelle.

## Pages principales

- `client/accueil.php`: accueil client
- `client/produit.php`: produits
- `client/carburant.php`: carburants
- `client/lavage.php`: lavage auto
- `client/panier.php`: panier
- `client/paiement.php`: paiement
- `client/profile.php`: profil utilisateur
- `admin/dashboard.php`: tableau de bord administrateur
- `admin/products.php`: gestion des produits
- `admin/orders.php`: commandes
- `admin/messages.php`: messages
- `admin/newsletter.php`: newsletter
- `admin/settings.php`: parametres

## Notes de developpement

- Les images de produits sont stockees dans `assets/images/`.
- Les scripts SQL/PHP de test et d'initialisation sont dans `scratch/`.
- La connexion PDO est centralisee dans `core/config.php`.
- Les fonctions d'administration sont regroupees dans `core/admin_functions.php`.
- Le projet utilise des sessions PHP pour l'authentification client et administrateur.

## Securite

- Ne gardez pas les identifiants administrateur par defaut en production.
- Ne versionnez pas de mots de passe reels.
- Configurez un utilisateur MySQL dedie avec des permissions limitees.
- Validez les uploads d'images avant une mise en production.
- Activez HTTPS sur un serveur public.
