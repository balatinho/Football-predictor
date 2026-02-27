<?php

require 'db.php';

$stmt = $pdo->query("SELECT team_id, team_name FROM teams ORDER BY team_name");
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Prediction Page</title>
</head>

<body>
    <header class="banner">
        <div class="inner-banner">
            <a href="index.php" class="logo"><i>ScoreSight</i></a>

            <nav class="nav-bar">
                <a href="index.php">Home</a>
                <a class="active" href="predict.php">Predict</a>
                <a href="results.php">Results</a>
                <a href="about.php">About</a>
            </nav>

            <button id="theme" class="theme-toggle" type="button" aria-label="Toggle dark mode"> Dark Mode </button>
        </div>
    </header>

    <main class="prediction-page">
        <div class="predict-card">

            <h1>Make a Prediction</h1>
            <p>Select two different teams and click <strong>Prediction</strong> to generate outcome probabilities.</p>

            <p id="teamError" style="color: red; font-weight: bold; <?= $error ? '' : 'display:none;' ?>">
                <?= htmlspecialchars($error) ?>
            </p>

            <form method="post" action="result.php" id="predictionForm">

                <div class="team-grid">

                    <div class="field">
                        <label for="home_team"><strong>Home Team</strong></label><br>
                        <select id="home_team" name="home_team" required>
                            <option value="" disabled selected hidden>Choose Home Team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= (int) $team['team_id'] ?>">
                                    <?= htmlspecialchars($team['team_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="away_team"><strong>Away Team</strong></label><br>
                        <select id="away_team" name="away_team" required>
                            <option value="" disabled selected hidden>Choose Away Team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= (int) $team['team_id'] ?>">
                                    <?= htmlspecialchars($team['team_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="btn">
                    <button type="submit">Prediction</button>
                    <button type="reset">Reset</button>
                </div>

            </form>
        </div>
    </main>

    <script src="js/script.js"></script>

</body>

</html>