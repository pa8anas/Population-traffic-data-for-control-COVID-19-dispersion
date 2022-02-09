<?php


function toMonth($m) {
    return date("F", mktime(0, 0, 0, $m, 10));
}

function monthOption() {
    $options = "";
    for ($m = 1; $m <= 12; $m++) {
        $currentMonth = ($m === date('m') ? "selected='$m'" : "");
        $options = $options . "<option value='$m' $currentMonth>";
        $options = $options . toMonth($m) . "</option>";
    }
    return $options;
}


?>
