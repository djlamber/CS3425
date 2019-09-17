<?php

echo '<h2> Coach Login </h2>';
session_start();
if (isset($_SESSION["loggedIn"]) ){
   echo "You have already logged in";
   header("LOCATION:homepage.php");
   return;
}

function login(){
  if(empty($_POST['email'])){
    echo"<br>Email is empty";
    return false;
  }
  if(empty($_POST['password'])){
    echo"<br>Password is empty";
    return false;
  }

  $email = $_POST['email'];
  $password = $_POST['password'];

  if(CheckLoginInDB($email,$password)){
    return false;
  }

  session_start();
  $_SESSION["email"] = $email;
  header("LOCATION:homepage.php");
  return true;
}
function CheckLoginInDB($email,$password){
  include('config.php');
  $pw = md5($password);
  $qry = "select * from coaches where email = '$email' and password='$pw'";
  $statement =$dbh->query($qry);
  foreach($statement as $row){
    if($row > 0){
      session_start();
      $_SESSION["loggedIn"] = true;
      $_SESSION["type"] = "coach";
      $_SESSION["email"] = $email;
      $_SESSION["name"] = $row['name'];
      $_SESSION["address"] = $row['address'];
      $_SESSION["phone"] = $row['phone'];
      $_SESSION["fee"] = $row['fee'];
      header("LOCATION:homepage.php");
      return false;
      echo "<br>Email and password do match";
    }
  }
  echo "<br> Email and password do not match";
  return true;
}

if (isset($_POST['email'])) {
    echo login();
}
echo '
<form name="login" method="post" action="">
  <p>
    <label>
      <input type="text" name="email" id="email">
    </label>
  </p>
  <p>
    <label>
      <input type="password" name="password" id="password">
    </label>
  </p>
  <p>
    <label>
      <input type="submit" name="button" id="button" value="Submit">
    </label>
  </p>
</form>';

?>
