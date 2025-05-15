<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ReferralController;
use App\Services\ReferralService;

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle root path
if ($path === '/') {
    echo "Hello World";
    exit;
}

// Handle form submission
if ($method === 'POST' && $path === '/submit') {
    $controller = new ReferralController();
    $controller->submit();
    exit;
}

// Handle referral view
if (preg_match('/^\/referrals\/([a-zA-Z0-9]+)$/', $path, $matches)) {
    $id = $matches[1];
    $referralService = new ReferralService();
    $result = $referralService->getReferralById($id);
    
    if ($result['success'] === false) {
        header('Location: https://www.giraffe360.com/');
        exit;
    }
    
    require_once __DIR__ . '/../src/Views/referral.php';
    exit;
}

// No route found, redirect to Giraffe360
header('Location: https://www.giraffe360.com/');
exit;

// Helper functions for country mapping
function getRegionFromCountry($country) {
    $regions = [
        'GB' => 'Europe',
        'US' => 'North America',
        'FR' => 'Europe',
        'DE' => 'Europe'
    ];
    return $regions[$country] ?? 'Europe';
}

function getCurrencyFromCountry($country) {
    $currencies = [
        'GB' => 'GBP',
        'US' => 'USD',
        'FR' => 'EUR',
        'DE' => 'EUR'
    ];
    return $currencies[$country] ?? 'EUR';
}