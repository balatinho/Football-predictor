<?php require 'header.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <title>About Page</title>
</head>

<body>
    <main class="container">
        <h1 class="page-title">About ScoreSight</h1>
        <p>ScoreSight is a web-based football outcome prediction system using a transparent Poisson-based statistical
            approach.</p>

        <h2>Data Source</h2>
        <p>Historical match results were imported from Football-Data.co.uk and stored in a normalised MySQL database.
        </p>

        <h2>How Predictions Work</h2>
        <p>The model estimates expected goals (λ) for each team and computes probabilities for Home Win, Draw and Away
            Win.</p>

        <h2>Limitations</h2>
        <ul class="steps">
            <li>Does not include injuries, transfers or live team form.</li>
            <li>Poisson assumptions may not hold for all matches.</li>
        </ul>
        <script src="js/script.js"></script>
    </main>
    <?php require 'footer.php'; ?>
</body>