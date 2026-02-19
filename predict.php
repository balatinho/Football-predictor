<?php

require 'db.php';

$stmt = $pdo->query("SELECT team_id, team_name FROM teams ORDER BY team_name");
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1><i>ScoreSight</i></h1>
    <h3>A Football Match Outcome Prediction System</h3>
    <nav>
        <a href="index.php">Home</a> |
        <a href="predict.php">Predict</a> |
        <a href="results.php">Results</a> |
        <a href="about.php">About</a>

        <form method="post" action="result.php">
            <h2>Choose an Option</h2>
            <select id="home_team" name="home_team" defaultValue="" required>
                <option hidden value="">Home Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= (int) $team['team_id'] ?>">
                        <?= htmlspecialchars($team['team_name']) ?>

                    </option>
                <?php endforeach; ?>
            </select>


            <?php
            $stmt = $pdo->query("SELECT team_id, team_name FROM teams ORDER BY team_name");
            $teams = $stmt->fetchAll();
            ?>

            <select id="away_team" name="away_team" defaultValue="" required>
                <option hidden value="">Away Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= (int) $team['team_id'] ?>">
                        <?= htmlspecialchars($team['team_name']) ?>

                    </option>
                <?php endforeach; ?>
            </select><br><br>
            <button type="submit">Prediction</button>

        </form>
</body>

</html>

