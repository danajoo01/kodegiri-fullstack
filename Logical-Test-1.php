<?php

$data = ['11','12','cii','001','2','1998','7','89','iia','fii'];
$new_data = [];
for($d=0;$d<count($data);$d++) {
    if(!is_numeric($data[$d])) {
        $new_data[$data[$d]]  = substring($data[$d]);
    }
}
$new_data['S'] = joinarray($new_data);
print_r($new_data);

function joinarray($arr) {
    $new_array = [];
    foreach($arr as $ele) {
        foreach($ele as $val) {
            if (!in_array($val, $new_array)) {
                array_push($new_array, $val);
            }
        }
    }
    return $new_array;
}
function substring($string) {
    $arr = [];
    for($s=1;$s<=strlen($string);$s++) {
        array_push($arr, substr($string,0, $s));
    }
    for($s=strlen($string)-1;$s>=1;$s--) {
        $start = -$s;
        array_push($arr, substr($string,$start));
    }
    return $arr;
}
// Expected Output :
// cii = {"c", "ci", "cii", "ii", "i"}
// iia = {"i","ii',"iia","ia","a"}
// fii = {“f”,”fi”,”fii”,”ii”,”i”}
// S = {"c", "ci", "cii", "ii", "i", ”iia”, ”ia”, ”a”, ”f”, ”fi”, ”fii”}
