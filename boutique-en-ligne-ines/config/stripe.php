<?php
// config/stripe.php

require_once  '/../vendor/autoload.php';

const STRIPE_SECRET_KEY = 'sk_test_your_secret_key_here'; // Clé secrète
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY); // Clé secrète
const STRIPE_PUBLIC_KEY = 'pk_test_51RObWLR5u061nyRmdZFKaeeLRbpjnNzCiC8ynVYXj6dnIXhkFpLPU7tt9xQXsHrWZ7685ZO28zUbldHb7nVm008T00qARN7Khc'; // Clé publique
const STRIPE_WEBHOOK_SECRET = 'whsec_...'; // Secret du webhook
const STRIPE_WEBHOOK_ENDPOINT = 'https://example.com/webhook'; // URL de votre webhook
const STRIPE_SUCCESS_URL = 'https://example.com/success'; // URL de succès
const STRIPE_CANCEL_URL = 'https://example.com/cancel'; // URL d'annulation
const STRIPE_MODE = 'test'; // Mode de test ou de production
const STRIPE_CURRENCY = 'eur'; // Devise utilisée
const STRIPE_PAYMENT_METHOD_TYPES = ['card']; // Méthodes de paiement acceptées

?>