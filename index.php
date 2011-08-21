<?php
define(FACEBOOK_API_KEY,"150009015084147");
define(FACEBOOK_API_SECRET,"276dab5b6cd370b695b0eadd2608c809");
require_once("lib/facebook/facebook.php");
$facebook = new Facebook(array(
  'appId'  => 150009015084147,
  'secret' => FACEBOOK_API_SECRET,
));
try {
  $user = $facebook->getUser();
} catch(FacebookApiException $e) {
  var_dump($e);
}
print_r($user);
?>
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script type="text/javascript" src="jpegcam/webcam.js"></script>
  <script type="text/javascript">
  webcam.set_api_url( 'jpegcam/upload.php' );
	webcam.set_quality( 100 );
	webcam.set_shutter_sound( false );
	
  webcam.set_hook( 'onComplete', 'upload_complete' );
	
	function upload_complete(msg) {
		if (msg.match(/ERROR/)) console.log("PHP Error: " + msg);
		else webcam.reset();
	}
	
	$(function() {
	  $("#configure").click(function() {
	    webcam.configure()
	  })
	  $("#take-pic").click(function() {
	    webcam.snap();
	  })
	})
  </script>
</head>
<body>
  <script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<button id="configure">configure</button>
	<button id="take-pic">take pic</button>

<br>
<fb:login-button perms="user_photos, friends_photos, offline_access">
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '150009015084147', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>	
</body>
</html>
