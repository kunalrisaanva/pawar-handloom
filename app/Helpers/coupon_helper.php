<?php

if (!function_exists('calculateDiscount')) {

function calculateDiscount($type, $total, $value)
{

$type = strtolower($type);

switch ($type) {

case "percentage":

return ($total * $value) / 100;

case "flat":

return $value;

default:

return 0;

}

}

}