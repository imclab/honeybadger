<?php

$image = file_get_contents($_POST['image_url']);
$filename = strtolower(str_replace(" ","-",$_POST['name'])) . "-" . $_POST['fb_user_id'] . "-" . time() . ".jpg";
$dest = "jackpot/" . $filename;
file_put_contents($dest, $image);

?>