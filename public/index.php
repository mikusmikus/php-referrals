<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Debug information
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Import controllers and services
use App\Controllers\ReferralController;
use App\Controllers\HomeController;
use App\Controllers\ZipCodeController;
use App\Services\ReferralService;

// Get request information
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define routes
$routes = [
    // Home page
    'GET:/' => function() {
        $controller = new HomeController();
        $controller->index();
    },
    
    // Form submission
    'POST:/submit' => function() {
        $controller = new ReferralController();
        $controller->submit();
    },
    
    // Zip codes page
    'GET:/zip-codes' => function() {
        $controller = new ZipCodeController();
        $controller->index();
    },

    // Zip code validation API
    'POST:/api/validate-zip-code' => function() {
        $controller = new ZipCodeController();
        $controller->validateZipCode();
    }
];

// Handle referral view (special case due to dynamic parameter)
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

// Handle defined routes
$routeKey = $method . ':' . $path;
if (isset($routes[$routeKey])) {
    $routes[$routeKey]();
    exit;
}

// No route found, redirect to Giraffe360
header('Location: https://www.giraffe360.com/');
exit;

/**
 * Helper Functions
 */

/**
 * Get region based on country code
 * 
 * @param string $country Two-letter country code
 * @return string Region name
 */
function getRegionFromCountry($country) {
    $regions = [
        'GB' => 'Europe',
        'US' => 'North America',
        'FR' => 'Europe',
        'DE' => 'Europe'
    ];
    return $regions[$country] ?? 'Europe';
}

/**
 * Get currency based on country code
 * 
 * @param string $country Two-letter country code
 * @return string Currency code
 */
function getCurrencyFromCountry($country) {
    $currencies = [
        'GB' => 'GBP',
        'US' => 'USD',
        'FR' => 'EUR',
        'DE' => 'EUR'
    ];
    return $currencies[$country] ?? 'EUR';
}