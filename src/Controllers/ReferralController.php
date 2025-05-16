<?php

namespace App\Controllers;

use Exception;

class ReferralController
{
    public function submit()
    {
        header('Content-Type: application/json');
        
        try {
            // Validate required fields
            $requiredFields = ['first_name', 'last_name', 'email', 'phone', 'company_name', 'country', 'gdpr', 'salesforce_id'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Missing required field: {$field}");
                }
            }

            // Validate email format
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format");
            }

            // Validate phone format (basic validation)
            if (!preg_match('/^\+?[\d\s-]{10,}$/', $_POST['phone'])) {
                throw new Exception("Invalid phone format");
            }

            // Prepare data for Salesforce
            $contactData = [
                'FirstName' => $_POST['first_name'],
                'LastName' => $_POST['last_name'],
                'Email' => $_POST['email'],
                'Phone' => $_POST['phone'],
                'Source__c' => 'Girrafe360 Referral',
                'Status__c' => 'New',
                'GDPR__c' => $_POST['gdpr'],
                'GDPR_Data_collection_source__c' => $_POST['gdpr_source']
            ];

            $accountData = [
                'Name' => $_POST['company_name'],
                'Region__c' => $this->getRegionFromCountry($_POST['country']),
                'CurrencyIsoCode' => $this->getCurrencyFromCountry($_POST['country']),
                'Referral_Status__c' => 'New Referral',
                'Account_Referrer__c' => $_POST['salesforce_id']
            ];

            // Log the data being sent to Salesforce
            error_log('Contact Data: ' . print_r($contactData, true));
            error_log('Account Data: ' . print_r($accountData, true));

            // TODO: Inject Salesforce service and call it here
            // $salesforceService->createContactAndAccount($contactData, $accountData);

            echo json_encode([
                'success' => true,
                'message' => 'Referral submitted successfully'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function getRegionFromCountry($country)
    {
        $regions = [
            'GB' => 'Europe',
            'US' => 'North America',
            'FR' => 'Europe',
            'DE' => 'Europe'
        ];
        return $regions[$country] ?? 'Europe';
    }

    private function getCurrencyFromCountry($country)
    {
        $currencies = [
            'GB' => 'GBP',
            'US' => 'USD',
            'FR' => 'EUR',
            'DE' => 'EUR'
        ];
        return $currencies[$country] ?? 'EUR';
    }
} 