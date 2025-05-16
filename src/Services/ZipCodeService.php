<?php

namespace App\Services;

use Exception;
use Dotenv\Dotenv;

class ZipCodeService
{
    private $apiBaseUrl;
    private $serviceToken;

    public function __construct()
    {
        // Try to load .env file only if it exists (for local development)
        $envPath = dirname(__DIR__, 2);
        if (file_exists($envPath . '/.env')) {
            $dotenv = Dotenv::createImmutable($envPath);
            $dotenv->load();
        }

        // Check if required environment variables are set
        if (!isset($_ENV['API_BASE_URL']) || !isset($_ENV['SERVICE_TOKEN'])) {
            throw new Exception('Required environment variables API_BASE_URL and SERVICE_TOKEN must be set');
        }

        $this->apiBaseUrl = $_ENV['API_BASE_URL'];
        $this->serviceToken = $_ENV['SERVICE_TOKEN'];
    }

    public function getZipCodeInfo(string $zipCode): array
    {
        // Validate zip code format (5 digits)
        if (empty($zipCode) || !preg_match('/^\d{5}$/', $zipCode)) {
            return [
                'success' => false,
                'error' => 'Please enter a valid 5-digit zip code'
            ];
        }

        try {
            // Initialize cURL session
            $ch = curl_init();
            
            // Set cURL options
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->apiBaseUrl . '/gapi/services/wordpress/zip-codes/validate/?zipcode=' . urlencode($zipCode),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30, // Hardcoded 30 seconds timeout
                CURLOPT_HTTPHEADER => [
                    'Authorization: ServiceToken ' . $this->serviceToken
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
                    return [
                        'success' => true,
                        'data' => [
                            'zip_code' => $zipCode,
                            'valid' => true
                        ]
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'Sorry, this zip code is not eligible for discount.'
                    ];
                }
            } else {
                throw new Exception('Unexpected response from API');
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'An error occurred while validating the zip code'
            ];
        }
    }
} 