<?php
function sort_by_date($a, $b) {
    $a = \DateTime::createFromFormat('M y', $a['date']);
    $b = \DateTime::createFromFormat('M y', $b['date']);
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}