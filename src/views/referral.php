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
                            <div class="g360-form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="g360-form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="g360-form-group">
                                <label for="phone">Phone:</label>
                                <input type="tel" id="phone" name="phone" required>
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