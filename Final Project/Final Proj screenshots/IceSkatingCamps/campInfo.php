<?php
session_start();
if(!$_SESSION["loggedIn"]){
  header("LOCATION:home.html");
  return;
}
$camp = $_SESSION["camp"];
$type = $_SESSION["type"];
echo "<h2>$camp schedule</h2> <br>";

echo'
<form method=post action="homepage.php">
 <input type="submit" name="home" value="Back to Homepage">
</form>';


if($type === "camper"){
  echo "Open slots for $camp <br>";
  echo "Each slot is 15 minutes long <br>";
  include('config.php');
  $qry = "select * from teaches s left join takes t on s.teaches_ice_start_time = t.takes_ice_start_time and s.teaches_slot_time = t.takes_slot_start_time and s.teaches_teaching_date = t.takes_teaching_date and s.camp = t.camp left join coaches c on s.coach_email = c.email where t.camper_email is null and s.camp = '$camp'";
  $statement = $dbh->query($qry);
  echo "<table border ='1'>";
  echo "<TR> <TH> Date </TH> <TH> Start Time </TH> <TH> Instructor </TH> <TH> Instructor Email </TH> <TH> Instructor Phone </TH> <TH> Price </TH> <TH> Register </TH> </TR>";
  foreach($statement as $row){
   if($row[6] = $camp){
   echo '<TR>';
   echo '<form method=post action="">';
   echo '<TD> '.$row[1].' </TD>';
   echo '<input type="hidden" name="date" value="'.$row[1].'">';
   echo '<input type="hidden" name="iceStart" value="'.$row[2].'">';
   echo '<TD> '.$row[3].' </TD>';
   echo '<input type="hidden" name="start" value="'.$row[3].'">';
   echo '<TD> '.$row[11].' </TD>';
   echo '<TD> '.$row[12].' </TD>';
   echo '<TD> '.$row[15].' </TD>';
   echo '<TD> $'.$row[4].' </TD>';
   echo '<TD> <input type="submit" name="register" value="register"> </TD>';
   echo '</form>';
   echo '</TR>';
  }
 }
}

if(isset($_POST['register'])){
  include('config.php');
  $statement =$dbh->prepare( "insert into takes values(:email,:date,:iceStart,:start,:camp)");
  $dbh->beginTransaction();
  $statement->execute(array(':email'=>$_SESSION['email'],':date'=>$_POST['date'],':iceStart'=>$_POST['iceStart'],':start'=>$_POST['start'],':camp'=>$_SESSION['camp']));
  $dbh->commit();
}



if($type === "coach"){
  echo "Open teaching slots for $camp <br>";
  include('config.php');
  $qry = "select * from teaching_slot s left join teaches t on s.ice_start_time = t.teaches_ice_start_time and s.slot_start_time = t.teaches_slot_time and s.teaching_date = t.teaches_teaching_date and s.camp = t.camp  where t.teaches_ice_start_time is null and t.teaches_slot_time is null and t.teaches_teaching_date is null and t.camp is null and s.camp = '$camp'";
  $statement = $dbh->query($qry);
  echo "<table border ='1'>";
  echo "<TR> <TH> Date </TH> <TH> Start Time </TH> <TH> End Time </TH> <TH> Teach  </TH> </TR>";
  foreach($statement as $row){
   echo '<TR>';
   echo '<form method=post action="">';
   echo '<input type="hidden" name="date" value="'.$row[0].'">';
   echo '<TD>'.$row[0].'</TD>';
   echo '<input type="hidden" name="iceStart" value="'.$row[1].'">';
   echo '<input type="hidden" name="start" value="'.$row[2].'"> ';
   echo	'<TD>'.$row[2].'</TD>';
   echo '<input type="hidden" name="end" value="'.$row[3].'">';
   echo	'<TD>'.$row[3].'</TD>';
   echo '<TD> <input type="submit" name="teach" value="teach"> </TD>';
   echo '</form>';
   echo '</TR>';
  }
}

if(isset($_POST['teach'])){
  include('config.php');
  $statement =$dbh->prepare( "insert into teaches values(:email,:date,:iceStart,:start,:fee,:camp)");
  $dbh->beginTransaction();
  $statement->execute(array(':email'=>$_SESSION['email'],':date'=>$_POST['date'],':iceStart'=>$_POST['iceStart'],':start'=>$_POST['start'],':fee'=>$_SESSION['fee'],':camp'=>$_SESSION['camp']));
  $dbh->commit();
}


if(isset($_POST['home'])){
  header("LOCATION:homepage.php");
}
?>