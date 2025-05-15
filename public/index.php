<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\ReferralService;

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Basic routing - now accepts alphanumeric IDs
if (preg_match('/^\/referrals\/([a-zA-Z0-9]+)$/', $path, $matches)) {
    $id = $matches[1];
    $referralService = new ReferralService();
    $result = $referralService->getReferralById($id);
    
    if ($result['success'] === false && $result['error'] === 'not_found') {
        require_once __DIR__ . '/../src/views/not-found.php';
    } else {
        require_once __DIR__ . '/../src/views/referral.php';
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
} 