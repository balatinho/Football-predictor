<nav>
    <a href="index.php">Home</a> |
    <a href="predict.php">Predict</a> |
    <a href="result.php">Results</a> |
    <a href="about.php">About</a>
</nav>

<?php
$home = $_POST['home_team'];
$away = $_POST['away_team'];
$outcome = ["$home Win", "Draw", "$away Win"];
$prediction = $outcome[array_rand( $outcome)];

if ($home === $away) {
  die("Error: Home and Away teams must be different.");
}

elseif (empty($home) || empty($away)) {
    echo "Both teams must be entered.";
    exit;
}
echo "<h2>Prediction Request</h2>";
echo "<p>Home Team: $home</p>";
echo "<p>Away Team: $away</p>";
echo "<h3>Predicted Outcome: $prediction</h3>";
?>