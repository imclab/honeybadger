<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="reset.css"></link>
  <link rel="stylesheet" href="home.css"></link>
  <link href='http://fonts.googleapis.com/css?family=Volkhov' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
</head>
<body>
<div id="text">Please enter your number to sign up.</div>
<form id="form">
  <input id="area"></input>
  <input id="first"></input>
  <input id="second"></input>
  </form>
<img id="badger" title="He don't give a shit." src="/a/honeybadger/honey_badger_vector.png"></img>
<button id="button" class="thoughtbot">yo</button>

<div id="fb-root"></div>
<script>

  $(document).ready(function(){
    $('#area').focus();
    $('#area').keydown(function(){
      if ($(this).val().length >= 3){
        $("#first").focus();
      };
    })
    $('#first').keydown(function(){
      if ($(this).val().length >= 3){
        $("#second").focus();
      };
    })
    $('#second').keydown(function(){
      if ($(this).val().length >= 4){
        $("#button").focus();
      };
    })
  })
  
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

