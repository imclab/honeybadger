<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
  html, body {width:100%;height:100%;}
  body {margin:0;padding:0;position:relative}
  #cam,
  #memed {
    position:absolute;
    top:50%;
    left:50%;
    margin-top:-240px;
    margin-left:-320px;
    z-index:3;
  }
  </style>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script type="text/javascript" src="jpegcam/webcam.js"></script>
  <script type="text/javascript">
  var interval_secs = 20;
  var interval = null;
  
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
		    
		    if(res.photos[0].tags.length > 0) {
		      console.log('clear interval')
          clearInterval(interval);
          
		      var results = res.photos[0].tags[0];
		      console.log(results);

          var uid = results.uids[0].uid.replace("@facebook.com","");

          FB.api('/' + uid, function(fb_user) {
            hit_twilio(response.session.uid, fb_user.name, file.filename);
          })
		    } else {
		      console.log('nobody in the frame')
		    }
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
	  webcam.set_hook('onCameraStatus', function(status) {
	    if(status == 'allow') {
	      $("#cam").css("top","-1000px");
	      interval = setInterval(begin_checking, interval_secs * 1000);
      }
	  })
	})
	
	function begin_checking() {
	  console.log('snap')
	  webcam.snap();
	}
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

