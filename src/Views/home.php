<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giraffe360 Tools</title>
        <link rel="stylesheet" href="/assets/css/styles.css">
    </head>
    <body class="g360-theme g360-theme--light">
        <div class="g360-page-container">
            <div class="g360-container">
                <h1 class="g360-h1" style="text-align: center; margin-bottom: 2rem;">Giraffe360 Tools</h1>
                
                <!-- Referral Section -->
                <div class="g360-card" style="margin-bottom: 2rem;">
                    <h2 class="g360-h2">Referral System</h2>
                    <div class="g360-body">
                        <p class="g360-text">Check if a referral ID exists and manage referral information.</p>
                        <form id="referralForm" class="g360-form" style="margin: 1.5rem 0;">
                            <div class="g360-form-group">
                                <label for="referralId" class="g360-label">Enter Referral ID:</label>
                                <input type="text" id="referralId" name="referralId" class="g360-input" required>
                            </div>
                            <button type="submit" class="g360-button g360-button--primary">Check Referral</button>
                        </form>
                    </div>
                </div>

                <!-- Zip Code Section -->
                <div class="g360-card">
                    <h2 class="g360-h2">Zip Code Validator</h2>
                    <div class="g360-body">
                        <p class="g360-text">Validate zip codes and check eligibility for discounts.</p>
                        <div class="g360-navigation" style="margin-top: 1.5rem;">
                            <a href="/zip-codes" class="g360-button g360-button--secondary">Go to Zip Code Validator</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('referralForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const referralId = document.getElementById('referralId').value.trim();
                if (referralId) {
                    window.location.href = `/referrals/${encodeURIComponent(referralId)}`;
                }
            });
        </script>
    </body>
</html> 