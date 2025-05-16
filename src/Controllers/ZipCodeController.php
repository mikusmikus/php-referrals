<?php

namespace App\Controllers;

use App\Services\ZipCodeService;

class ZipCodeController
{
    private $zipCodeService;

    public function __construct()
    {
        $this->zipCodeService = new ZipCodeService();
    }

    public function index()
    {
        require_once __DIR__ . '/../Views/zip-codes.php';
    }

    public function validateZipCode()
    {
        // Get JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['zip_code'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Zip code is required'
            ]);
            return;
        }

        $result = $this->zipCodeService->getZipCodeInfo($data['zip_code']);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }
} 