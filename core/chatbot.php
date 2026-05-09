<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['reply' => 'Methode non autorisee.']);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
$message = trim((string)($payload['message'] ?? ''));
$history = is_array($payload['history'] ?? null) ? $payload['history'] : [];

if ($message === '') {
    echo json_encode(['reply' => 'Posez une question sur nos services EnergyFuel.']);
    exit;
}

$serviceContext = <<<TEXT
EnergyFuel est une station-service avec ces pages et services:
- Accueil: presentation generale.
- Services: lavage auto, produits auto, carburant.
- Lavage auto: prise de rendez-vous, lavage exterieur, nettoyage interieur, jantes et pneus, polissage, cirage, deodorisation. Prix a partir de 25 EUR.
- Produits: huiles, lubrifiants, produits de nettoyage, accessoires, pieces detachees, additifs carburant, catalogue et panier.
- Carburant: essence sans plomb 95/98, diesel haute performance, carburants additifs, recharge electrique, points de fidelite.
- Paiement: carte bancaire, especes, application mobile et paiement des commandes.
- Compte: connexion, inscription, profil, historique des achats.
- Contact station: +216 27 312 507.
Reponds en francais, avec des phrases courtes, et guide l'utilisateur vers la page utile.
TEXT;

$reply = askHuggingFace($message, $history, $serviceContext);

if ($reply === null) {
    $reply = fallbackReply($message);
}

echo json_encode(['reply' => $reply], JSON_UNESCAPED_UNICODE);

function askHuggingFace(string $message, array $history, string $serviceContext): ?string
{
    $token = getenv('HF_TOKEN') ?: '';
    if ($token === '') {
        return null;
    }

    $model = getenv('HF_MODEL') ?: 'meta-llama/Llama-3.1-8B-Instruct';
    $messages = [
        [
            'role' => 'system',
            'content' => "Tu es l'assistant du site EnergyFuel. Utilise uniquement ce contexte pour guider les clients.\n\n" . $serviceContext
        ]
    ];

    foreach (array_slice($history, -8) as $item) {
        $role = $item['role'] ?? '';
        $content = trim((string)($item['content'] ?? ''));
        if (($role === 'user' || $role === 'assistant') && $content !== '') {
            $messages[] = ['role' => $role, 'content' => mb_substr($content, 0, 1000)];
        }
    }

    if (empty($messages) || end($messages)['role'] !== 'user') {
        $messages[] = ['role' => 'user', 'content' => $message];
    }

    $body = json_encode([
        'model' => $model,
        'messages' => $messages,
        'max_tokens' => 220,
        'temperature' => 0.4
    ]);

    $ch = curl_init('https://router.huggingface.co/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $status < 200 || $status >= 300) {
        return null;
    }

    $data = json_decode($response, true);
    $content = trim((string)($data['choices'][0]['message']['content'] ?? ''));

    return $content !== '' ? $content : null;
}

function fallbackReply(string $message): string
{
    $text = mb_strtolower($message);

    if (containsAny($text, ['lavage', 'nettoyage', 'rendez', 'rdv', 'jantes', 'polissage'])) {
        return 'Pour le lavage auto, allez sur la page Lavage. Vous pouvez choisir une formule avec lavage exterieur, interieur, jantes, pneus, polissage ou deodorisation. Le prix commence a 25 EUR.';
    }

    if (containsAny($text, ['produit', 'huile', 'accessoire', 'piece', 'catalogue', 'panier'])) {
        return 'Pour les produits, ouvrez la page Produits. Vous y trouverez huiles, lubrifiants, produits de nettoyage, accessoires, pieces detachees et additifs carburant.';
    }

    if (containsAny($text, ['carburant', 'essence', 'diesel', 'recharge', 'reservoir', 'plein'])) {
        return 'Pour le carburant, utilisez la page Carburant. EnergyFuel propose SP95, SP98, diesel haute performance, additifs et recharge electrique.';
    }

    if (containsAny($text, ['payer', 'paiement', 'carte', 'commande', 'espece'])) {
        return 'Pour le paiement, vous pouvez utiliser carte bancaire, especes ou application mobile. Pour une commande en ligne, continuez vers le panier puis la page Paiement.';
    }

    if (containsAny($text, ['compte', 'connexion', 'inscription', 'profil', 'achat'])) {
        return 'Pour votre compte, utilisez Connexion ou Inscrivez-vous depuis l’icone utilisateur. Une fois connecte, vous pouvez consulter votre profil et vos achats.';
    }

    return 'Je peux vous orienter vers Lavage, Produits, Carburant, Paiement ou Compte. Pour une aide directe, contactez la station au +216 27 312 507.';
}

function containsAny(string $text, array $needles): bool
{
    foreach ($needles as $needle) {
        if (mb_strpos($text, $needle) !== false) {
            return true;
        }
    }

    return false;
}
