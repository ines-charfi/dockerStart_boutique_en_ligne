<?php
// webhook.php
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$endpoint_secret = 'whsec_...'; // Clé webhook Stripe

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch (\UnexpectedValueException | \Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

// Gestion des événements
switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;
        
        // Mettre à jour le statut de la commande en base
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            UPDATE commande 
            SET statut = 'payée' 
            WHERE stripe_session_id = ?
        ");
        $stmt->execute([$session->id]);
        break;
}

http_response_code(200);
?>
