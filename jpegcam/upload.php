<?php

$filename = date('YmdHis') . '.jpg';
$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
 print "ERROR: Failed to write data to $filename, check permissions\n";
 exit();
}
$image_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
echo($image_url);

?>