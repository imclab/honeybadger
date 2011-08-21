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
		
		FB.getLoginStatus(function(response) {
		  
		  $.post("face_magic.php", {
		    image_url: msg,
		    fb_user_id: response.session.uid,
		    fb_oauth_token: response.session.access_token
		  }, function(data) {
		    var res = $.parseJSON(data);
        var results = photos[0].tags[0];
        
        var uids = results.uids.slice(0,5);
        var names = [];
        
        for(var i=0; i<uids.length; i++) {
          FB.api('/' + uids[i].uid, function(response) {
            console.log(response)
            //names.push()
          })
        }
        
        // $.post("callback.php", {
        //   fb_user_id: response.session.uid,
        //   names: names
        // })
		  })
		})
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
