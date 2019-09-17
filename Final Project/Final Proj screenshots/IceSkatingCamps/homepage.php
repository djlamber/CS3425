<?php
session_start();
if(!$_SESSION["loggedIn"]){
  header("LOCATION:home.html");
  return;
}
if($_SESSION["type"] === "camper"){
$email = $_SESSION["email"];
$name = $_SESSION["name"];
echo "Welcome $name ";
echo '
<form method=post action=logout.php>
 <input type="submit" name="button"  value="Logout">
</form>
<form method=post action=changeInfo.php>
 <input type="submit" name="button"  value="Change contact info">
</form>';

}
if($_SESSION["type"] === "coach"){
$email = $_SESSION["email"];
$name = $_SESSION["name"];
$fee = $_SESSION["fee"];
echo "Welcome coach $name";

echo ' 
<form method=post action=logout.php>
 <input type="submit" name="button" value="Logout">
</form>
<form method=post action=changeInfo.php>
 <input type="submit" name="button"  value="Change contact info">
</form>';

echo "Your current rate is $$fee per session <br>";

echo '
<form method=post action="">
 <input type="text" name="fee" placeholder="update rate here">
 <input type="submit" name="update" value="Update">
</form>';

}

if(isset($_POST['fee'])){
  if(empty($_POST['fee'])){
    echo"Fee is empty<br><br>";
  }else{
  include('config.php');
  $fee = $_POST['fee'];
  $qry = "update teaches set fee=$fee where coach_email='$email'";
  $qry2 = "update coaches set fee=$fee where email='$email'";
  $dbh->beginTransaction();
  $dbh->query($qry);
  $dbh->query($qry2);
  $dbh->commit();
  $_SESSION['fee'] = $_POST['fee'];
  Header('Location: '.$_SERVER['PHP_SELF']);
  }
}


include('config.php');
$qry = "select * from camps";
$statement = $dbh->query($qry);
echo "<table border ='1'>";
echo "<TR> <TH> Camps </TH> <TH> Location </TH> <TH> Dates </TH> <TH> Registration Dates </TH> <TH> Brochure </TH> <TH> Schedule </TH> <TH> Register </TH> </TR>";
foreach($statement as $row){
  echo '<TR>';

  echo '<form method=post action="">';
  echo '<TD>'.$row[0].'</TD>';
  echo '<TD>'.$row[1].'</TD>';
  echo '<TD>'.$row[2].' to '.$row[3].'</TD>';
  echo '<TD>'.$row[4].' to '.$row[5].'</TD>';
  echo '<TD> <input type="submit" name="brochure" value="'.$row[6].'"> </TD>';
  echo '</form>';

  echo '<form method=post action="">';
  echo '<input type="hidden" name="camp" value="'.$row[0].'">';
  echo '<TD> <input type="submit" name="sched" value="Schedule"> </TD>';
  echo '</form>';

  echo '<form method=post action="">';
  echo '<input type="hidden" name="camp" value="'.$row[0].'">';
  echo '<TD> <input type="submit" name="submit" value="Register"> </TD>';
  echo '</form>';
  echo '</TR>';
}


if(isset($_POST['camp'])){
  $_SESSION["camp"] = $_POST['camp'];
  header("LOCATION:campInfo.php");
}
if(isset($_POST['brochure'])){
 $brochure = $_POST['brochure'];
 header("LOCATION:$brochure");
}
if(isset($_POST['sched'])){
 $_SESSION["camp"] = $_POST['camp'];
 header("LOCATION:schedule.php");
}
 
?>