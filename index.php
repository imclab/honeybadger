<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="reset.css"></link>
  <link rel="stylesheet" href="home.css"></link>
  <link href='http://fonts.googleapis.com/css?family=Volkhov' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
</head>
<body>
  <div id="main">
    <div id="login">Login</div>
    <div id="text">Please enter your number to sign up.</div>
    <form id="formcakes">
      <div id="inputs">
        <span class="paren">(</span>
        <input id="area" name="area" maxlength="3"></input>
        <span class="paren">)</span>
        <input id="first" name="first" maxlength="3"></input>
        <input id="second" name="second" maxlength="4"></input>
      </div>
    </form>
    <button id="button" class="thoughtbot">Sign Up</button>
    <img id="badger" title="He don't give a shit." src="/a/honeybadger/honey_badger_vector.png"></img>
  </main>


<div id="fb-root"></div>
<script>

  $(document).ready(function(){
    $('#area').focus();
    // $('#area').keypress(function(){
    //   console.log($(this).val().length)
    //   if ($(this).val().length >= 2){
    //     $("#first").focus();
    //   };
    // })
    // $('#first').keypress(function(){
    //   if ($(this).val().length >= 2){
    //     $("#second").focus();
    //   };
    // })
    // $('#second').keyup(function(){
    //   if ($(this).val().length > 3){
    //     $("#button").focus();
    //   };
    // })
  })
  
  var user_number;
  
  $('#login').click(function(){
    FB.getLoginStatus(fbResponseLogIn);
  })
  
  $("#button").click(function() {
    var area = $('#area').val();
    var first = $('#first').val();
    var second = $('#second').val();
    user_number = area + '' + first + '' + second;
    user_number = parseInt(user_number,10);
    if (user_number > 0){
     FB.login(fbResponse, { perms: "user_photos, friends_photos, offline_access"}); 
    }
  })
  
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
  
  function fbResponse(response) {
   if(response.session) {
     $.ajax({
       type: 'POST',
       url: '/a/honeybadger/register.php',
       data: { number: user_number, id: response.session.uid, oauth: response.session.access_token, check: false },
       success: function(){
          window.location = "http://abe.is/a/honeybadger/monitoring.php";
       },
     }); 
    }
  }
  
  function fbResponseLogIn(response) {
   if(response.session) {
     $.ajax({
       type: 'POST',
       url: '/a/honeybadger/register.php',
       data: { number: user_number, id: response.session.uid, oauth: response.session.access_token, check: true },
       success: function(data){
         if(data == 'true'){
          window.location = "http://abe.is/a/honeybadger/monitoring.php"; 
         } else {
           alert("We can't seem to find you in our system. :/")
         }
       },
     }); 
    } else {
      FB.login(fbResponseLogIn, {perms: "user_photos, friends_photos, offline_access"});
    }
  }
</script>	
</body>
</html>

