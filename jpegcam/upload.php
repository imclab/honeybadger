<?php

$filename = date('YmdHis') . '.jpg';
$result = file_put_contents( '../uploads/' . $filename, file_get_contents('php://input') );
if (!$result) {
 print "ERROR: Failed to write data to $filename, check permissions\n";
 exit();
}

$image_url = 'http://abe.is/a/honeybadger/uploads/' . $filename;

$res = array();
$res['filename'] = $filename;
$res['image_url'] = $image_url;
echo(json_encode($res));

?>