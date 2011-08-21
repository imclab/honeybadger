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

$image_url = $_POST['image_url'];
$fb_user_id = $_POST['fb_user_id'];
$fb_oauth_token = $_POST['fb_oauth_token'];

// prepare the face.com url
$url = 'http://api.face.com/faces/recognize.json?';
$url .= 'api_key=' . FACE_API_KEY . '&';
$url .= 'api_secret=' . FACE_API_SECRET . '&';
$url .= 'urls=' . $image_url . '&';
$url .= 'uids=friends@facebook.com&';
$url .= 'namespace=facebook.com&';
$url .= 'detector=Aggressive&';
$url .= 'attributes=all&';
$url .= 'user_auth=fb_user:' . $fb_user_id . ',fb_oauth_token:' . $fb_oauth_token;

echo(curl_url($url));

?>