<?php
// Prevent any output before headers
ob_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Only load .env file if it exists (typically for local dev)
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    $dotenv->required(['API_BASE_URL', 'SERVICE_TOKEN', 'ALLOWED_ORIGIN']);
}

// Set headers
header('Content-Type: application/json');

// CORS protection
$allowed_origin = $_ENV['ALLOWED_ORIGIN'];

if (isset($_SERVER['HTTP_ORIGIN'])) {
    if ($_SERVER['HTTP_ORIGIN'] !== $allowed_origin) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['error' => 'Unauthorized origin']);
        exit;
    }
    header('Access-Control-Allow-Origin: ' . $allowed_origin);
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get zip code from either POST or JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$zipCode = $data['zip_code'] ?? $_POST['zip_code'] ?? '';

// Validate zip code format (5 digits)
if (empty($zipCode) || !preg_match('/^\d{5}$/', $zipCode)) {
    http_response_code(400);
    echo json_encode(['error' => 'Please enter a valid 5-digit zip code']);
    exit;
}

try {
    // Initialize cURL session
    $ch = curl_init();
    

    // Log the full API URL for debugging
    error_log("API URL: " . $_ENV['API_BASE_URL'] . '/gapi/services/wordpress/zip-codes/validate/?zipcode=' . urlencode($zipCode));

    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $_ENV['API_BASE_URL'] . '/gapi/services/wordpress/zip-codes/validate/?zipcode=' . urlencode($zipCode),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Authorization: ServiceToken ' . $_ENV['SERVICE_TOKEN']
        ]
    ]);

    // Execute cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    
    // Close cURL session
    curl_close($ch);

    if ($httpCode === 200) {
        $responseData = json_decode($response, true);

        if ($responseData['valid'] === true) {
            echo json_encode([
                'success' => true,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Sorry, this zip code is not eligible for discount.'
            ]);
        }
    } else {
        throw new Exception('Unexpected response from API');
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while validating the zip code']);
}

// Flush output buffer
ob_end_flush(); 