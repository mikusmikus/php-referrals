<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral #<?php echo htmlspecialchars($id); ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="referral-card">
            <h1>Referral Details</h1>
            <div class="referral-id">
                <span>Referral ID:</span>
                <span class="id-value"><?php echo htmlspecialchars($id); ?></span>
            </div>
        </div>
    </div>
    <script src="/assets/js/referrals.js"></script>
</body>
</html> 