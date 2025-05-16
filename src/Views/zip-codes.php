<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Environment variables are handled by Docker
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zip Code Validator</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="g360-theme g360-theme--dark">
    <div class="g360-container" style="margin-top: 100px">
        <div class="g360-zip-code-section">
            <form class="g360-zip-code-form" id="zipCodeForm">
                <div class="g360-zip-code-form-input-wrapper">
                    <input
                        type="text"
                        name="zip_code"
                        class="g360-zip-code-form-input"
                        placeholder="Search zip code"
                        aria-label="Search zip code"
                    />
                    <button  
                        type="submit"
                        class="g360-button g360-button--tertiary g360-zip-code-form-submit-button"
                    >
                        Submit
                    </button>
                </div>

                <div class="g360-zip-code-form-error g360-body-extra-small" aria-live="polite" style="display: none;"></div>
            </form>

            <div class="g360-zip-code-claim-wrapper">
                <!-- Initial State - Simple Placeholder -->
                <div class="g360-zip-code-claim-initial">
                </div>

                <!-- Success State -->
                <div class="g360-zip-code-claim-success" style="display: none;">
                    <div class="g360-zip-code-claim">
                        <div class="g360-zip-code-claim-content">
                            <h2 class="g360-h5">Awesome, that Zip code is 
                                <span class="g360-zip-code-claim-success-text">available</span>
                                &nbsp;for exclusivity.
                            </h2>
                            <p class="g360-body-small g360-zip-code-claim-description">
                                Now is your chance to claim this zip code for available leads.
                            </p>
                        </div>
                        <div class="g360-zip-code-claim-action">
                            <button
                                class="g360-button g360-button--primary g360-button--rounded g360-button--small g360-zip-code-claim-button"
                            >
                                Claim zip code now
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div class="g360-zip-code-claim-error" style="display: none;">
                    <div class="g360-zip-code-claim">
                        <div class="g360-zip-code-claim-content">
                            <h2 class="g360-h5">Sorry, that Zip code is 
                                <span class="g360-zip-code-claim-error-text">unavailable.</span>
                            </h2>
                            <p class="g360-body-small g360-zip-code-claim-description">
                                Contact one of our team and we can provide some further options.
                            </p>
                        </div>
                        <div class="g360-zip-code-claim-action">
                            <button
                                class="g360-button g360-button--primary g360-button--rounded g360-button--small g360-zip-code-claim-button"
                            >
                                Talk to our team
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/zip-validator.js"></script>
</body>
</html> 