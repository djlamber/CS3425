<!DOCTYPE html>
<html>
<head>
  <h2>Registration Form</h2>
</head>
<body>
<?php
if (isset($_POST['email'])) {
    echo register();
}
function register(){
   if(empty($_POST['email'])){
    echo"<br>Email is empty";
    return false;
  }
   $email = $_POST['email'];
   if(empty($_POST['password'])){
    echo"<br>Password is empty";
    return false;
  }
   if(empty($_POST['name'])){
    echo"<br>Name is empty";
    return false;
  }
   if(empty($_POST['address'])){
    echo"<br>Address is empty";
    return false;
  }
   if(empty($_POST['phone'])){
    echo"<br>Phone is empty";
    return false;
  }
   if(empty($_POST['emergency'])){
    echo"<br>Emergency Contact is empty";
    return false;
  }
   if(checkEmailTaken($email)){
   include('config.php');
   $password = md5($_POST['password']);
   $statement = $dbh->prepare(" insert into campers values(:name, :email, :password, :address, :phone, :emergency, 0)");
   $dbh->beginTransaction();
   $statement->execute(array(':name' => $_POST['name'], ':email' => $_POST['email'], ':password' => $password, ':address' => $_POST['address'], ':phone' => $_POST['phone'], ':emergency' => $_POST['emergency']));
   $dbh->commit();
   header("LOCATION:registered.html");
   return;
  }
}

function checkEmailTaken($email){
include('config.php');
  $qry = "select * from campers where email = '$email'";
  $statement =$dbh->query($qry);
  foreach($statement as $row){
    if($row > 0){
      echo "<br>Email is taken";
      return false;
    }
  }
  echo "<br> Email isn't taken";
  return true;
}
?>

  <form method=post action="">
        email:<br> <input type="text" name="email" placeholder="name@email.com"><br>
        password:<br> <input type="password" name="password" placeholder="password"><br>
        name:<br> <input type="text" name="name" placeholder="John Smith"><br>
        address:<br> <input type="text" name="address" placeholder="1234 Main St."><br>
        phone number:<br> <input type="text" name="phone" placeholder="xxxyyyzzzz"><br>
        emergency contact:<br> <input type="text" name="emergency" placeholder="xxxyyyzzzz"><br>
        <input type="submit" name="submit"  value="Submit">
      </form>
</body>
</html>
