<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral #<?php echo htmlspecialchars($id); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="g360-theme g360-theme--light">
    <div class="g360-page-container">
        <div class="g360-container">
            <div class="g360-card">
                <h1 class="g360-h1">Referral Details</h1>
                <div class="g360-body">
                    <div class="g360-referral-info">
                        <span>Referral ID:</span>
                        <span class="g360-value"><?php echo htmlspecialchars($id); ?></span>
                    </div>
                    <?php if ($result['success'] && isset($result['contact_id'])): ?>
                        <div class="g360-referral-info">
                            <span>Contact ID:</span>
                            <span class="g360-value"><?php echo htmlspecialchars($result['contact_id']); ?></span>
                        </div>
                        <form class="g360-form" method="POST" action="/submit">
                            <input type="hidden" name="salesforce_id" value="<?php echo htmlspecialchars($result['contact_id']); ?>">
                            
                            <div class="g360-form-section">
                                <h2 class="g360-h4">Contact Information</h2>
                                <div class="g360-form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>
                                <div class="g360-form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                                <div class="g360-form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="g360-form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                            </div>

                            <div class="g360-form-section">
                                <h2 class="g360-h4">Company Information</h2>
                                <div class="g360-form-group">
                                    <label for="company_name">Company Name:</label>
                                    <input type="text" id="company_name" name="company_name" required>
                                </div>
                                <div class="g360-form-group">
                                    <label for="country">Country:</label>
                                    <select id="country" name="country" required>
                                        <option value="">Select a country</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="US">United States</option>
                                        <option value="FR">France</option>
                                        <option value="DE">Germany</option>
                                        <!-- Add more countries as needed -->
                                    </select>
                                </div>
                            </div>

                            <div class="g360-form-section">
                                <div class="g360-form-group g360-form-group--checkbox">
                                    <input type="checkbox" id="gdpr" name="gdpr" value="Yes" required>
                                    <label for="gdpr">I consent to the processing of my personal data in accordance with Giraffe360's Privacy Policy</label>
                                </div>
                                <input type="hidden" name="gdpr_source" value="Referred to us by another Contact">
                            </div>

                            <button type="submit" class="g360-button g360-button--primary">Submit</button>
                        </form>
                    <?php else: ?>
                        <div class="g360-form-error">
                            <?php echo htmlspecialchars($result['error'] ?? 'An unexpected error occurred'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/referrals.js"></script>
</body>
</html> 