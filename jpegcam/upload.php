<?php

define(FACE_API_KEY,"9d7f7b0e135972820852c9665c46a352");
define(FACE_API_SECRET,"3496ddb11098381389cda9ea0908ce5e");

define(FACEBOOK_API_KEY,"150009015084147");
define(FACEBOOK_API_SECRET,"276dab5b6cd370b695b0eadd2608c809");

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
// if (!$result) {
//  print "ERROR: Failed to write data to $filename, check permissions\n";
//  exit();
// }
$image_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;


// setup facebook
include_once("../lib/facebook/facebook.php");
$facebook = new Facebook(array(
  'appId'  => 150009015084147,
  'secret' => FACEBOOK_API_SECRET,
));
$user = $facebook->getUser();
print_r($user);

// prepare the face.com url
$url = 'http://api.face.com/faces/recognize.json?';
$url .= 'api_key=' . FACE_API_KEY . '&';
$url .= 'api_secret=' . FACE_API_SECRET . '&';
$url .= 'urls=' . $image_url . '&';
$url .= 'uids=friends@facebook.com&';
$url .= 'namespace=facebook.com&';
$url .= 'detector=Aggressive&';
$url .= 'attributes=all&';
$url .= 'user_auth=fb_user:' . $user['id'] . ',fb_oauth_token:' . $fb_oauth_token;

$recognize = json_decode(curl_url($url));

print_r($recognize);

?>