<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="home.css"></link>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
</head>
<body>
<div id="text">YO FOOL</div>
<button id="button" class="thoughtbot">yo</button>

<div id="fb-root"></div>
<script>
  $("#button").click(function() {
      console.log("sup.")
      FB.login(fbResponse, { perms: "user_photos, friends_photos, offline_access"});
  })

  window.fbAsyncInit = function() {
    FB.init({appId: '150009015084147', status: true, cookie: true,
             xfbml: true});
    FB.Event.subscribe('auth.login', function () {
             window.location = "http://abe.is/a/honeybadger/monitoring.php";
        });
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
  
  function fbResponse(response) {
   if(response.session) {
     window.location = "http://abe.is/a/honeybadger/monitoring.php";
    }
  }
</script>	
</body>
</html>

