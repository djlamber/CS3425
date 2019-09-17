<?php

echo '<h2>Camper Login</h2>';
session_start();
if (isset($_SESSION["loggedIn"]) ){
   echo "You have already logged in";
   header("LOCATION:homepage.php");
   return;
}

echo'
<form method=post action="register.php">
 <br>
 <input type="submit" name="home" value="Not a camper? Register!">
</form>';

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
  $qry = "select * from campers where email = '$email' and password='$pw'";
  $statement =$dbh->query($qry);
  foreach($statement as $row){
    if($row > 0){
      session_start();
      $_SESSION["loggedIn"] = true;
      $_SESSION["type"] = "camper";
      $_SESSION["email"] = $email;
      $_SESSION["name"] = $row['name'];
      $_SESSION["address"] = $row['address'];
      $_SESSION["phone"] = $row['phone'];
      $_SESSION["emergency"] = $row['emergency_contact'];
      $_SESSION["bill"] = $row['bill'];
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
      <input type="text" name="email">
    </label>
  </p>
  <p>
    <label>
      <input type="password" name="password">
    </label>
  </p>
  <p>
    <label>
      <input type="submit" name="button" value="Submit">
    </label>
  </p>
</form>';

?>
