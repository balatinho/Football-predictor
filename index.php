<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css" />
    <title>Home Page</title>
</head>

<body>
    <header class="banner">
        <div class="inner-banner">
            <div class="logo"><i>ScoreSight</i></div>

            <nav class="nav-bar">
                <a class="active" href="index.php">Home</a>
                <a href="predict.php">Predict</a>
                <a href="results.php">Results</a>
                <a href="about.php">About</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h1 class="page-title">Football Match Outcome Prediction System</h1>
            <p class="subtitle">
                ScoreSight predicts match outcomes using historical football data and a transparent statistical
                approach.
                Select two teams to receive a predicted outcome and probabilities for Home Win, Draw, and Away Win.
            </p>

            <a class="primary-btn" href="predict.php">Make a Prediction</a>

        </section>

        <section class="card">
            <h2>How it works</h2>
            <ol class="steps">
                <li>Select a home team and an away team.</li>
                <li>The system retrieves relevant historical match data from the database.</li>
                <li>A statistical model calculates outcome probabilities.</li>
                <li>The predicted outcome and probabilities are displayed and saved for evaluation.</li>
            </ol>
        </section>
    </main>
</body>

</html>