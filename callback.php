<?php
    require "twilio.php";
    require "connection.php";

    $user_id = $_POST['fb_user_id'];
    $name = $_POST['name'];
    
    $query = "SELECT * FROM users WHERE (id=$user_id)";
    $res = mysql_query($query);

    $phone;
    while($row = mysql_fetch_array($res, MYSQL_NUM)){
      $phone = $row[2];
  	}

 
    // twilio REST API version
    $ApiVersion = "2010-04-01";
   
    // instantiate a new Twilio Rest Client
    $client = new TwilioRestClient($AccountSid, $AuthToken);

    // make an associative array of people we know, indexed by phone number
    $people = array(
        "0"=>"+1".$phone,
    );

    // iterate over all our friends
  $counter = 0;
    foreach ($people as $index => $number) {
              $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
                   "POST", array(
                   "To" => $number,
                   "From" => "7326622692",
                   "Body" => "Don't shoot the messenger, but I believe that ". $name ." is messing with yo' shit!"
               ));
               if($response->IsError) echo "Error: {$response->ErrorMessage}";
    }
?>