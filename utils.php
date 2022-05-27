<?php
function getTimePassed($date) {
    $passedMessage = "A moment ago";
    $minutesPassed = (int)((round(microtime(true) * 1000) - $date)/60000);
    if ($minutesPassed > 1) 
        $passedMessage = "$minutesPassed minutes ago";
    if ($minutesPassed > 59) {
        $hoursPassed = (int)($minutesPassed / 60);
        $passedMessage = "$hoursPassed hours ago";
        if ($hoursPassed > 23) {
            $daysPassed = (int)($hoursPassed / 24);
            $passedMessage = "$daysPassed days ago";
            if ($daysPassed > 6) {
                $weeksPassed = (int)($daysPassed / 7);
                $passedMessage = "$weeksPassed weeks ago";
            }
        }
    }
    return $passedMessage;
}
?>