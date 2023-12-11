<?php
function calculateAverageGameTime($players)
{
    if (empty($players)) {
        return 'N/A';
    }

    $totalGameTime = 0;

    foreach ($players as $player) {
        $startTime = strtotime($player['game_time_started']);
        $endTime = strtotime($player['game_time_completed']);

        // Check if both start and end times are valid
        if ($startTime !== false && $endTime !== false) {
            $totalGameTime += ($endTime - $startTime);
        }
    }

    if ($totalGameTime > 0) {
        $averageGameTimeSeconds = $totalGameTime / count($players);
        return gmdate("H:i:s", $averageGameTimeSeconds);
    } else {
        return 'N/A';
    }
}
?>
