<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
  html, body {width:100%;height:100%;}
  body {
    margin:0;
    padding:0;
    position:relative;
    background-image:url(reddit.png);
    background-repeat:no-repeat;
    background-position:top center;
    font-family:Arial, Helvetica, Tahoma, sans-serif;
    font-size:14px;
    line-height:1.4;
  }
  #cam {
    position:absolute;
    top:50%;
    left:50%;
    margin-top:-240px;
    margin-left:-320px;
  }
  #memed {
    position: relative;
    z-index: 3;
    text-align: center;
  }
  #directions {
    width:300px;
    background-color:#000;
    color:#fff;
    position:absolute;
    left:50%;
    top:20px;
    margin-left:-180px;
    text-align:center;
    padding:0 30px;
  }
  #memed img{
    height: 666px;
  }
  </style>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script type="text/javascript" src="jpegcam/webcam.js"></script>
  <script type="text/javascript">
  var interval_secs = 20;
  var interval = null;
  var been_memed = false;
  
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
		    
		    if(res.photos[0].tags.length > 0 && res.photos[0].tags[0].recognizable) {
		      console.log('clear interval')
		      $("#cam").remove();
          clearInterval(interval);
          
		      var results = res.photos[0].tags[0];

          var uid = results.uids[0].uid.replace("@facebook.com","");

          FB.api('/' + uid, function(fb_user) {
            hit_twilio(response.session.uid, uid, fb_user.name, file.filename);
          })
		    } else {
		      console.log('nobody in the frame')
		    }
		  })
		})
	}
	
	function hit_twilio(fb_user_id, troll_id, name, filename) {
	  $.post("callback.php", {
      fb_user_id: fb_user_id,
      name: name
    }, function(data) {
      $.post("/a/honeybadger/aviary_magic.php", { filename: filename, troll_name: name }, function(res) {
        var av_magic = $.parseJSON(res);
        if(av_magic.success && !been_memed) {
          memed = av_magic.memed;
          
          var img = $("<img>").attr("src",memed);
          var br1 = $("<br>");
          var br2 = $("<br>");
          var a = $("<a>").attr("href","http://www.facebook.com/profile.php?id=" + troll_id).attr("target","_blank").html("Not " + name + "?");
          $("#memed").append(a,br1,br2,img);
          
          $("body").css("background","none");
          
          alert('YO ' + name.toUpperCase() + ' YOU WON $3,550!');
          
          been_memed = true;
          
          $.post("/a/honeybadger/save_aviary.php", { fb_user_id: fb_user_id, name: name, image_url: memed }, function(aviary_saved) {
            console.log(aviary_saved)
          });
        }
      });
    });
	}
	
	$(function() {
	  webcam.set_hook('onCameraStatus', function(status) {
	    if(status == 'allow') {
	      // hide cam and directions
	      $("#directions").fadeOut();
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
  
  <div id="directions">
    <h3>Click allow and tracking will begin. Just close the window to end tracking.</h3>
  </div>
  
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
    
   FB.getLoginStatus(function(response) {
	    if(!response.session) {
	      window.location = "index.php";
     } else {
       $.post("/a/honeybadger/register.php", {
         id: response.session.uid,
         check: true
       }, function(data) {
         if(data != 'true') {
           window.location = "index.php";
         }
       })
     }
	  })
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

