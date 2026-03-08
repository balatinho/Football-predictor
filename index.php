<?php
require 'db.php';
$teamCount = (int) $pdo->query("SELECT COUNT(*) FROM teams")->fetchColumn();
$matchCount = (int) $pdo->query("SELECT COUNT(*) FROM matches")->fetchColumn();
$predCount = (int) $pdo->query("SELECT COUNT(*) FROM predictions")->fetchColumn();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Home Page</title>
</head>

<body>

    <?php require 'header.php'; ?>

    <main class="container">
        <section class="hero">
            <h1 class="page-title">Football Match Outcome Prediction System</h1>
            <p class="subtitle">
                ScoreSight predicts match outcomes using historical football data and a transparent statistical
                approach.
                Select two teams to receive a predicted outcome and probabilities for Home Win, Draw, and Away Win.
            </p>

            <a class="primary-btn" href="/predictor/predict">Make a Prediction</a>

        </section>

        <section class="card">
            <h2>How it works</h2>
            <ol class="steps">
                <li>Select a home team and an away team.</li>
                <li>The system retrieves relevant historical match data from the database.</li>
                <li>A statistical model calculates outcome probabilities.</li>
                <li>The predicted outcome and probabilities are displayed and saved.</li>
            </ol>
        </section>

        <section class="card">
            <h2>System Status</h2>
            <ul class="steps">
                <li><strong>Teams:</strong>
                    <?= $teamCount ?>
                </li>
                <li><strong>Matches:</strong>
                    <?= $matchCount ?>
                </li>
                <li><strong>Predictions stored:</strong>
                    <?= $predCount ?>
                </li>
            </ul>
        </section>
    </main>

    <?php require 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>