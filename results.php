<?php
require 'db.php';

// Get search input (if provided)
$teamFilter = isset($_GET['team']) ? trim($_GET['team']) : '';

// Base SQL query
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
";

// If user typed a team name, add WHERE clause
if ($teamFilter !== '') {
    $sql .= "
    WHERE t1.team_name LIKE :team
       OR t2.team_name LIKE :team
    ";
}

$sql .= "
ORDER BY p.created_at DESC
LIMIT 50
";

$stmt = $pdo->prepare($sql);

// Bind parameter only if filtering
if ($teamFilter !== '') {
    $stmt->bindValue(':team', '%' . $teamFilter . '%', PDO::PARAM_STR);
}

$stmt->execute();
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

    <main class="container results-page">

        <h1>Saved Predictions</h1>

        <form method="get" class="filter-form">
            <label for="team">Filter by Team:</label>
            <input type="text" id="team" name="team" value="<?= htmlspecialchars($teamFilter) ?>"
                placeholder="Enter team name">
            <button class="search-btn" type="submit">Search</button>

            <?php if ($teamFilter !== ''): ?>
                <a href="results.php"><button class="search-btn" type="button">Clear Filter</button></a>
            <?php endif; ?>
        </form>

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
    </main>

</body>

</html>