<?php
    require "twilio.php";
 
    // twilio REST API version
    $ApiVersion = "2010-04-01";
    
    // set our AccountSid and AuthToken
    $AccountSid = "ACe5852f9abb9e86ce395e8b88ff5817a7";
    $AuthToken = "af579e6ab6aa0e936f28f7404032f6fb";
 
        // instantiate a new Twilio Rest Client
        $client = new TwilioRestClient($AccountSid, $AuthToken);

        // make an associative array of people we know, indexed by phone number
        $people = array(
            "0"=>"+17322757699",
            "1"=>"+17322757699",
        );

        // iterate over all our friends
    	$counter = 0;
        foreach ($people as $index => $number) {

            // Send a new outgoinging SMS by POSTing to the SMS resource */
                  $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
                       "POST", array(
                       "To" => $number,
                       "From" => "732-662-2692",
                       "Body" => "It works, sire."
                   ));
                   if($response->IsError)
                      echo "Error: {$response->ErrorMessage}";
                  else
    				$counter++;
                // echo "Sent message to $name";
        }
    echo $counter;
?>
