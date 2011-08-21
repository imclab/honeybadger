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
  <input id="area" name="area" maxlength="3"></input>
  <input id="first" name="first" maxlength="3"></input>
  <input id="second" name="second" maxlength="4"></input>
  </form>
<img id="badger" title="He don't give a shit." src="/a/honeybadger/honey_badger_vector.png"></img>
<button id="button" class="thoughtbot">Sign Up</button>

<div id="fb-root"></div>
<script>

  $(document).ready(function(){
    $('#area').focus();
    $('#area').keypress(function(){
      console.log($(this).val().length)
      if ($(this).val().length >= 2){
        $("#first").focus();
      };
    })
    $('#first').keypress(function(){
      if ($(this).val().length >= 2){
        $("#second").focus();
      };
    })
    $('#second').keyup(function(){
      if ($(this).val().length > 3){
        $("#button").focus();
      };
    })
  })
  
  var user_number;
  
  $("#button").click(function() {
    var area = $('#area').val();
    var first = $('#first').val();
    var second = $('#second').val();
    user_number = area + '' + first + '' + second;
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
     $.ajax({
       type: 'POST',
       url: '/a/honeybadger/register.php',
       data: { number: user_number, id: response.session.uid, oauth: response.session.access_token },
       success: function(data){
         console.log(data)
          window.location = "http://abe.is/a/honeybadger/monitoring.php";
       },
     }); 
    }
  }
</script>	
</body>
</html>

