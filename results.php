<?php
require 'db.php';

$sql = "
SELECT
  p.prediction_id,
  t1.team_name AS home_team,
  t2.team_name AS away_team,
  p.predicted_outcome,
  p.p_home, p.p_draw, p.p_away,
  p.created_at
FROM predictions p
JOIN teams t1 ON p.home_team_id = t1.team_id
JOIN teams t2 ON p.away_team_id = t2.team_id
ORDER BY p.created_at DESC
LIMIT 50
";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Saved Preictions</title>
</head>

<body>
    <header class="banner">
        <div class="inner-banner">
            <a href="index.php" class="logo"><i>ScoreSight</i></a>

            <nav class="nav-bar">
                <a href="index.php">Home</a>
                <a href="predict.php">Predict</a>
                <a class="active" href="results.php">Results</a>
                <a href="about.php">About</a>
            </nav>
        </div>
    </header>

    <h1>Saved Predictions</h1>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Match</th>
            <th>Prediction</th>
            <th>Home%</th>
            <th>Draw%</th>
            <th>Away%</th>
            <th>Date</th>
        </tr>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['prediction_id'] ?></td>
                <td><?= htmlspecialchars($r['home_team']) ?> vs <?= htmlspecialchars($r['away_team']) ?></td>
                <td><?= htmlspecialchars($r['predicted_outcome']) ?></td>
                <td><?= round($r['p_home'] * 100, 2) ?>%</td>
                <td><?= round($r['p_draw'] * 100, 2) ?>%</td>
                <td><?= round($r['p_away'] * 100, 2) ?>%</td>
                <td><?= htmlspecialchars($r['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>