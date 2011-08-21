<?php
  require "connection.php";
  $number = $_POST['number'];
  $oauth = $_POST['oauth'];
  $id = $_POST['id'];
  $check = $_POST['check'];
  
  $number = filter_that_shit($number);
  $oauth = filter_that_shit($oauth);
  $id = filter_that_shit($id);
  $check = filter_that_shit($check);
  
  if ($check == 'true') {
    $user_exists = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE `id`=$id"));
    if($user_exists){
      echo 'true';
    } else {
      echo 'false';
    }
  } else {
    $user_exists = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE `id`=$id"));
    if(!$user_exists) {
      $query = mysql_query("INSERT INTO users (`id`, `auth`,`number`) VALUES('$id', '$oauth', '$number')");
    }
  }
  
	function filter_that_shit($message){
		// trim whitespace from the begining and end of the message
		$message = trim($message);
		// this takes away any HTML or PHP tags someone might have entered into the form (hacking)
		$message = strip_tags($message);
		// this escapes any quotes (') or bad characters with a \ so it doesn't fuck up the SQL query
		$message = mysql_real_escape_string($message);
		// this returns the clean message
		return $message;
	}
?>