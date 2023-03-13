<?php

$value = imagecreatetruecolor(32,32);
$str = imagecolorallocate($value,255,255,255);
imagestring($value,5,11,7,$_GET['value'],$str);

imagepng($value);
imagedestroy($value);