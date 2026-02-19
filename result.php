<nav>
    <a href="index.php">Home</a> |
    <a href="predict.php">Predict</a> |
    <a href="results.php">Results</a> |
    <a href="about.php">About</a>
</nav>

<?php
require 'db.php';
require 'functions.php';

// 1) Read and validate input
$homeId = isset($_POST['home_team']) ? (int)$_POST['home_team'] : 0;
$awayId = isset($_POST['away_team']) ? (int)$_POST['away_team'] : 0;

if ($homeId <= 0 || $awayId <= 0) {
    die("Error: Please select both teams.");
}

if ($homeId === $awayId) {
    die("Error: Home and Away teams must be different.");
}

// 2) Fetch team names for display
$stmt = $pdo->prepare("SELECT team_name FROM teams WHERE team_id = :id");
$stmt->execute([':id' => $homeId]);
$homeName = $stmt->fetchColumn();

$stmt->execute([':id' => $awayId]);
$awayName = $stmt->fetchColumn();

if (!$homeName || !$awayName) {
    die("Error: One or both teams not found in the database.");
}

// 3) Run prediction
$result = predict_poisson($pdo, $homeId, $awayId, 5);

// 4) Store prediction (for evaluation later)
$insert = $pdo->prepare("
    INSERT INTO predictions (home_team_id, away_team_id, predicted_outcome, p_home, p_draw, p_away, created_at)
    VALUES (:home, :away, :pred, :ph, :pd, :pa, NOW())
");
$insert->execute([
    ':home' => $homeId,
    ':away' => $awayId,
    ':pred' => $result['predicted'],
    ':ph'   => $result['p_home'],
    ':pd'   => $result['p_draw'],
    ':pa'   => $result['p_away']
]);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Prediction Result</title>
  <!--<link rel="stylesheet" href="styles.css">-->
</head>
<body>

<h1>Prediction Result</h1>

<p><strong>Match:</strong> <?= htmlspecialchars($homeName) ?> vs <?= htmlspecialchars($awayName) ?></p>

<p><strong>Predicted Outcome:</strong> <?= htmlspecialchars($result['predicted']) ?></p>

<h2>Outcome Probabilities</h2>
<ul>
  <li>Home Win: <?= round($result['p_home'] * 100, 2) ?>%</li>
  <li>Draw: <?= round($result['p_draw'] * 100, 2) ?>%</li>
  <li>Away Win: <?= round($result['p_away'] * 100, 2) ?>%</li>
</ul>

<h2>Model Details (for transparency)</h2>
<ul>
  <li>Home expected goals (λ): <?= round($result['home_lambda'], 3) ?></li>
  <li>Away expected goals (λ): <?= round($result['away_lambda'], 3) ?></li>
</ul>

<p><a href="index.php">Make another prediction</a></p>

</body>
</html>
