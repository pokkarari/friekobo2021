<?php
// htmlspecialchars()の短縮形
function h($string,$doEcho = true) {
    $escaped = htmlspecialchars($string,ENT_QUOTES);
    if($doEcho == true){
        echo $escaped;
    }
    return $escaped;
}