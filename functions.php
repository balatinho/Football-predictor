<?php
function factorial(int $k): int {
    $result = 1;
    for ($i = 2; $i <= $k; $i++) {
        $result *= $i;
    }
    return $result;
}


function poisson_pmf(float $lambda, int $k): float {
    return (pow($lambda, $k) * exp(-$lambda)) / factorial($k);
}


function get_home_lambda(PDO $pdo, int $homeTeamId): float {
    $sql = "SELECT AVG(home_goals) AS avg_goals
            FROM matches
            WHERE home_team_id = :tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':tid' => $homeTeamId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row && $row['avg_goals'] !== null ? (float)$row['avg_goals'] : 1.2;
}


function get_away_lambda(PDO $pdo, int $awayTeamId): float {
    $sql = "SELECT AVG(away_goals) AS avg_goals
            FROM matches
            WHERE away_team_id = :tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':tid' => $awayTeamId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row && $row['avg_goals'] !== null ? (float)$row['avg_goals'] : 1.0;
}

function predict_poisson(PDO $pdo, int $homeTeamId, int $awayTeamId, int $maxGoals = 5): array {
    $homeLambda = get_home_lambda($pdo, $homeTeamId); 
    $awayLambda = get_away_lambda($pdo, $awayTeamId);

    $pHomeWin = 0.0;
    $pDraw    = 0.0;
    $pAwayWin = 0.0;

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

    $total = $pHomeWin + $pDraw + $pAwayWin;
    if ($total > 0) {
        $pHomeWin /= $total;
        $pDraw    /= $total;
        $pAwayWin /= $total;
    }

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
