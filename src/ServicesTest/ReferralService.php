<?php

namespace App\ServicesTest;

class ReferralService
{
    private string $apiBaseUrl = 'https://referrers.giraffe360.com';

    public function getReferralById(string $id): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->apiBaseUrl}/{$id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return [
                'success' => false,
                'error' => 'not_found'
            ];
        }

        $data = json_decode($response, true);
        
        if (!is_array($data)) {
            return [
                'success' => false,
                'error' => 'not_found'
            ];
        }

        if (!isset($data['contact_id'])) {
            return [
                'success' => false,
                'error' => 'not_found'
            ];
        }

        return [
            'success' => true,
            'contact_id' => $data['contact_id']
        ];
    }
} 