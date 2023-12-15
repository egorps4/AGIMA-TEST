<?php
$originalArray = [
    '0' => 'Был первым',
    '1' => 'Был вторым',
    '2' => 'Был третьим',
    '3' => 'Был последним'
];

$reversedArray = [];
$keys = array_keys($originalArray);

for ($i = count($keys) - 1; $i >= 0; $i--) {
    $key = $keys[$i];
    $reversedArray[$key] = $originalArray[$key];
}

foreach ($reversedArray as $key => $value) {
    echo "$key => $value;" . PHP_EOL;
}
?>