<?php

define(FACE_API_KEY,"9d7f7b0e135972820852c9665c46a352");
define(FACE_API_SECRET,"3496ddb11098381389cda9ea0908ce5e");

function curl_url($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

$filename = date('YmdHis') . '.jpg';
$result = file_put_contents( $filename, file_get_contents('php://input') );
if (!$result) {
 print "ERROR: Failed to write data to $filename, check permissions\n";
 exit();
}
$image_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
echo($image_url);

?>