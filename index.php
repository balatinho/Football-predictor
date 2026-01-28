<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css" />
        <title>Home Page</title>
    </head>
    <body>
        <?php echo "<p>PHP is working!</p>"; ?>
        <h1><i>ScoreSight</i></h1>
        <nav>
            <a href="index.html">Home</a> |
            <a href="predict.html">Predict</a> |
            <a href="results.html">Results</a> |
            <a href="about.html">About</a>
        </nav>
        <p id="p1">MatchDay</p>
        <h2>Choose an Option</h2>
            <select>
                <option>Choose a Team</option>
                <option>Very Long Option Text That Will Be Truncated</option>
                <option>Another Long Option Example</option>
            </select>
            <select>
                <option>Choose a Team</option>
                <option>Very Long Option Text That Will Be Truncated</option>
                <option>Another Long Option Example</option>
            </select>
        <button type="button">Prediction</button>
        <script src="myScript.js"></script>
    </body>
</html>