<nav>
    <a href="index.php">Home</a> |
    <a href="predict.php">Predict</a> |
    <a href="result.php">Results</a> |
    <a href="about.php">About</a>
</nav>

<form method="post" action="result.php">
    <h2>Choose an Option</h2>
    <select id="home_team" name="home_team" defaultValue="" required>
        <option hidden value="">Home Team</option>
        <option>Liverpool</option>
        <option>Manchester City</option>
        <option>Manchester United</option>
        <option>Arsenal</option>
        <option>Chelsea</option>
    </select>
    <select id="away_team" name="away_team" defaultValue="" required>
        <option hidden value="">Away Team</option>
        <option>Arsenal</option>
        <option>Manchester City</option>
        <option>Chelsea</option>
        <option>Manchester United</option>
        <option>Liverpool</option>
    </select><br><br>



    <button type="submit">Prediction</button>
</form>