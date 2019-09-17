<?php
session_start();
if(!$_SESSION["loggedIn"]){
  header("LOCATION:home.html");
  return;
}
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$address = $_SESSION["address"];
$phone = $_SESSION["phone"]; 
$type = $_SESSION["type"];
$status = "";
echo'<h2> Change contact info</h2>';
echo'
<form method=post action="homepage.php">
 <input type="submit" name="home" value="Back to Homepage">
</form>';

if($type ==="camper"){
echo"Current name: $name";
echo'
<form method=post action="">
 <input type="text" name="name" value="">
 <input type="submit" name="nChange" value="Change">
</form>';
if(isset($_POST['nChange'])){
  if(empty($_POST['name'])){
    echo"Name is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update campers set name = :name where email = :email");
  $statement->execute(array(':name'=>$_POST["name"], ':email'=>$email));
  $_SESSION["name"] = $_POST["name"];
  Header('Location: '.$_SERVER['PHP_SELF']);
 }
}

echo"Current email: $email";
echo'
<form method=post action="">
 <input type="text" name="email" value="">
 <input type="submit" name="eChange" value="Change">
</form>';
if(isset($_POST['eChange'])){
  if(empty($_POST['email'])){
    echo"Email is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update campers set email = :nemail where email = :email");
  $statement->execute(array(':nemail'=>$_POST["email"], ':email'=>$email));
  $_SESSION["email"] = $_POST["email"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Change Password";
echo'
<form method=post action="">
 <input type="password" name="password" value="">
 <input type="submit" name="pasChange" value="Change">
</form>';
if(isset($_POST['pasChange'])){
  if(empty($_POST['password'])){
    echo"Password is empty<br><br>";
  }else{
  include('config.php');
  $pas = md5($_POST["address"]);
  $statement = $dbh->prepare("update campers set password = :password where email = :email");
  $statement->execute(array(':address'=>$pas, ':email'=>$email));
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Current address: $address";
echo'
<form method=post action="">
 <input type="text" name="address" value="">
 <input type="submit" name="aChange" value="Change">
</form>';
if(isset($_POST['aChange'])){
  if(empty($_POST['address'])){
    echo"Address is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update campers set address = :address where email = :email");
  $statement->execute(array(':address'=>$_POST["address"], ':email'=>$email));
  $_SESSION["address"] = $_POST["address"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Current phone: $phone";
echo'
<form method=post action="">
 <input type="text" name="phone" value="" placeholder="xxxyyyzzzz">
 <input type="submit" name="pChange" value="Change">
</form>';
if(isset($_POST['pChange'])){
  if(empty($_POST['phone'])){
    echo"Phone is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update campers set phone = :phone where email = :email");
  $statement->execute(array(':phone'=>$_POST["phone"], ':email'=>$email));
  $_SESSION["phone"] = $_POST["phone"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

$emergency = $_SESSION["emergency"];
echo"Current emergency contact: $emergency";
echo'
<form method=post action="">
 <input type="text" name="emergency" value="" placeholder="xxxyyyzzzz">
 <input type="submit" name="emChange" value="Change">
</form>';
if(isset($_POST['emChange'])){
  if(empty($_POST['emergency'])){
    echo"Emergency contact is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update campers set emergency_contact = :emergency where email = :email");
  $statement->execute(array(':emergency'=>$_POST["emergency"], ':email'=>$email));
  $_SESSION["emergency"] = $_POST["emergency"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}


}
if($type ==="coach"){

echo"Current name: $name";
echo'
<form method=post action="">
 <input type="text" name="name" value="">
 <input type="submit" name="nChange" value="Change">
</form>';
if(isset($_POST['nChange'])){
  if(empty($_POST['name'])){
    echo"Name is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update coaches set name = :name where email = :email");
  $statement->execute(array(':name'=>$_POST["name"], ':email'=>$email));
  $_SESSION["name"] = $_POST["name"];
  Header('Location: '.$_SERVER['PHP_SELF']);
 }
}

echo"Current email: $email";
echo'
<form method=post action="">
 <input type="text" name="email" value="">
 <input type="submit" name="eChange" value="Change">
</form>';
if(isset($_POST['eChange'])){
  if(empty($_POST['email'])){
    echo"Email is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update coaches set email = :nemail where email = :email");
  $statement->execute(array(':nemail'=>$_POST["email"], ':email'=>$email));
  $_SESSION["email"] = $_POST["email"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Change Password";
echo'
<form method=post action="">
 <input type="password" name="password" value="">
 <input type="submit" name="pasChange" value="Change">
</form>';
if(isset($_POST['pasChange'])){
  if(empty($_POST['password'])){
    echo"Password is empty<br><br>";
  }else{
  include('config.php');
  $pas = md5($_POST["address"]);
  $statement = $dbh->prepare("update coaches set password = :password where email = :email");
  $statement->execute(array(':address'=>$pas, ':email'=>$email));
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Current address: $address";
echo'
<form method=post action="">
 <input type="text" name="address" value="">
 <input type="submit" name="aChange" value="Change">
</form>';
if(isset($_POST['aChange'])){
  if(empty($_POST['address'])){
    echo"Address is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update coaches set address = :address where email = :email");
  $statement->execute(array(':address'=>$_POST["address"], ':email'=>$email));
  $_SESSION["address"] = $_POST["address"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

echo"Current phone: $phone";
echo'
<form method=post action="">
 <input type="text" name="phone" value="" placeholder="xxxyyyzzzz">
 <input type="submit" name="pChange" value="Change">
</form>';
if(isset($_POST['pChange'])){
  if(empty($_POST['phone'])){
    echo"Phone is empty<br><br>";
  }else{
  include('config.php');
  $statement = $dbh->prepare("update coaches set phone = :phone where email = :email");
  $statement->execute(array(':phone'=>$_POST["phone"], ':email'=>$email));
  $_SESSION["phone"] = $_POST["phone"];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}

}
?>