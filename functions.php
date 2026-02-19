<?php
// lib/poisson.php
// Purpose: All Poisson prediction logic lives here (keeps code clean and testable).

/**
 * Safe factorial for small k values (0..10).
 */
function factorial(int $k): int {
    $result = 1;
    for ($i = 2; $i <= $k; $i++) {
        $result *= $i;
    }
    return $result;
}

/**
 * Poisson probability mass function:
 * P(X = k) = (lambda^k * e^-lambda) / k!
 */
function poisson_pmf(float $lambda, int $k): float {
    return (pow($lambda, $k) * exp(-$lambda)) / factorial($k);
}

/**
 * Estimate home scoring rate (lambda) from DB:
 * average home_goals when this team played at home.
 */
function get_home_lambda(PDO $pdo, int $homeTeamId): float {
    $sql = "SELECT AVG(home_goals) AS avg_goals
            FROM matches
            WHERE home_team_id = :tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':tid' => $homeTeamId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no data, fall back to a small default so system doesn't crash
    return $row && $row['avg_goals'] !== null ? (float)$row['avg_goals'] : 1.2;
}

/**
 * Estimate away scoring rate (lambda) from DB:
 * average away_goals when this team played away.
 */
function get_away_lambda(PDO $pdo, int $awayTeamId): float {
    $sql = "SELECT AVG(away_goals) AS avg_goals
            FROM matches
            WHERE away_team_id = :tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':tid' => $awayTeamId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row && $row['avg_goals'] !== null ? (float)$row['avg_goals'] : 1.0;
}

/**
 * Compute outcome probabilities using Poisson goal distributions.
 * We cap at maxGoals to keep it simple and fast (0..5 is common).
 */
function predict_poisson(PDO $pdo, int $homeTeamId, int $awayTeamId, int $maxGoals = 5): array {
    $homeLambda = get_home_lambda($pdo, $homeTeamId);
    $awayLambda = get_away_lambda($pdo, $awayTeamId);

    $pHomeWin = 0.0;
    $pDraw    = 0.0;
    $pAwayWin = 0.0;

    // Compute probabilities of each scoreline and sum into outcome buckets
    for ($hg = 0; $hg <= $maxGoals; $hg++) {
        $pH = poisson_pmf($homeLambda, $hg);
        for ($ag = 0; $ag <= $maxGoals; $ag++) {
            $pA = poisson_pmf($awayLambda, $ag);
            $pScore = $pH * $pA;

            if ($hg > $ag) $pHomeWin += $pScore;
            elseif ($hg === $ag) $pDraw += $pScore;
            else $pAwayWin += $pScore;
        }
    }

    // Normalise in case probabilities don’t sum to 1 due to truncation at maxGoals
    $total = $pHomeWin + $pDraw + $pAwayWin;
    if ($total > 0) {
        $pHomeWin /= $total;
        $pDraw    /= $total;
        $pAwayWin /= $total;
    }

    // Pick most likely outcome
    $predicted = "Draw";
    $maxP = $pDraw;
    if ($pHomeWin > $maxP) { $maxP = $pHomeWin; $predicted = "Home Win"; }
    if ($pAwayWin > $maxP) { $maxP = $pAwayWin; $predicted = "Away Win"; }

    return [
        'home_lambda' => $homeLambda,
        'away_lambda' => $awayLambda,
        'p_home'      => $pHomeWin,
        'p_draw'      => $pDraw,
        'p_away'      => $pAwayWin,
        'predicted'   => $predicted
    ];
}
