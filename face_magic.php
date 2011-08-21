<?php

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

$recognize = json_decode(curl_url($url));

//print_r($recognize);

?>