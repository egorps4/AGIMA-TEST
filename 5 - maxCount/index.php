<?php
$nums = [1, 1, 0, 1, 1, 1];
$count = 0;
$maxCount = 0;

foreach ($nums as $num) {
    if ($num == 1) {
        $count++;
        $maxCount = max($maxCount, $count);
    } else {
        $count = 0;
    }
}

echo "Максимальное число последовательных единиц - $maxCount";
?>