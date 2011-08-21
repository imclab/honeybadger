<?php

// aviary magic to create bw version
require_once("lib/AviaryFX.php");
$api_key = "a29051063";
$api_secret = "9a29165c4";
$aviaryfx = new AviaryFX($api_key, $api_secret);

$image_url = $_POST['image_url'];
$troll_name = $_POST['troll_name'];

$uploadResponse = $aviaryfx->upload($image_url);
$aviary_image = $uploadResponse['url'];

$backgroundcolor = "0xFFFFFFFF";
$quality = "100";
$scale = "1";
$size = getimagesize($image_url);
$width = $size[0];
$height = $size[1];
$renderparameters = array (
  "parameter" => array	(
     array("id" => "Text Top", "value" => "gtfo " . $troll_name . "!!" ),
     array("id" => "Text Bottom", "value" => "a text was just sent to my phone the cops are after you" )
  )
);

$renderResponse = $aviaryfx->render($backgroundcolor, $extension, $quality, $scale, $color, 27, $width, $height, $renderparameters);
$memed = $renderResponse['url'];

$res = array();
$res['success'] = true;
$res['memed'] = $memed;
echo(json_encode($res));

?>