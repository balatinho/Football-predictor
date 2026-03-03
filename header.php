<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<header class="banner">
  <div class="inner-banner">
    <a href="/predictor" class="logo"><i>ScoreSight</i></a>

    <nav class="nav-bar">
      <a href="/predictor" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="/predictor/predict" class="<?= $currentPage === 'predict.php' ? 'active' : '' ?>">Predict</a>
      <a href="/predictor/results" class="<?= $currentPage === 'results.php' ? 'active' : '' ?>">Results</a>
      <a href="/predictor/about" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">About</a>
    </nav>

    <button id="theme" class="theme-toggle" type="button" aria-label="Toggle dark mode">🌙 Dark Mode</button>
  </div>
</header>