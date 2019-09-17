<?php
session_start();
if(!$_SESSION["loggedIn"]){
  header("LOCATION:home.html");
  return;
}
$camp = $_SESSION["camp"];
$type = $_SESSION["type"];
$email = $_SESSION["email"];
$name = $_SESSION["name"];
echo "<h2>$name's $camp schedule</h2> <br>";

echo'
<form method=post action="homepage.php">
 <input type="submit" name="home" value="Back to Homepage">
</form>';
if(isset($_POST['home'])){
  header("LOCATION:homepage.php");
}

if($type === "camper"){
$fees = 0;
$regis = 0;
$bill = 0;
  include('config.php');
  $qry ="select sum(fee) from teaches s left join takes t on s.teaches_ice_start_time = t.takes_ice_start_time and s.teaches_slot_time = t.takes_slot_start_time and s.teaches_teaching_date = t.takes_teaching_date and s.camp = t.camp where t.camper_email = '$email' and s.camp = '$camp' ";
  $statement=$dbh->query($qry);
  foreach($statement as $row){
   $bill = $row[0];
   if($bill === NULL){
    $bill = 0;
   }
  }
  $qry ="select sum(i.ice_fee) from ice_sessions i left join takes t on i.start_time = t.takes_ice_start_time and i.ice_date = t.takes_teaching_date and i.camp = t.camp where t.camper_email = '$email' and t.camp = '$camp'; ";
  $statement=$dbh->query($qry);
  foreach($statement as $row){
   $fees = $row[0];
   if($fees === NULL){
    $fees = 0;
   }
  }
  $qry ="select i.registration_fee from ice_sessions i left join takes t on i.start_time = t.takes_ice_start_time and i.ice_date = t.takes_teaching_date and i.camp = t.camp where t.camper_email = '$email' and t.camp = '$camp'; ";
  $statement=$dbh->query($qry);
  foreach($statement as $row){
   $regis = $row[0];
   if($regis === NULL){
    $regis = 0;
   }
  }
  $total = $bill + $fees + $regis; 
  echo "Your $camp bill is $$total <br> ($$fees in ice fees, $$regis in registration fees, $$bill in coach fees) <br><br>";
 
  echo "Your registered lesson slots, each is 15 minutes long <br>";
  $qry = "select * from teaches s left join takes t on s.teaches_ice_start_time = t.takes_ice_start_time and s.teaches_slot_time = t.takes_slot_start_time and s.teaches_teaching_date = t.takes_teaching_date and s.camp = t.camp where t.camper_email = '$email' ";
  $statement = $dbh->query($qry);
  echo "<table border ='1'>";
  echo "<TR> <TH> Date </TH> <TH> Start Time </TH> <TH> Instructor </TH> <TH> Price </TH> <TH> Drop </TH> </TR>";
  foreach($statement as $row){
   echo '<TR>';
   echo '<form method=post action="">';
   echo '<TD> '.$row[1].' </TD>';
   echo '<input type="hidden" name="date" value="'.$row[1].'">';
   echo '<input type="hidden" name="iceStart" value="'.$row[2].'">';
   echo '<input type="hidden" name="slot" value="'.$row[3].'">';
   echo '<TD>'.$row[3].'</TD>';
   echo '<TD>'.$row[0].'</TD>';
   echo '<input type="hidden" name="price" value="Price">';
   echo '<TD>$'.$row[4].'</TD>';
   echo '<TD> <input type="submit" name="dropslot" value="drop"> </TD>';
   echo '</form>';
   echo '</TR>';
 }
}
if(isset($_POST['dropslot'])){
  include('config.php');
  $statement =$dbh->prepare( "delete from takes where camper_email=:email and takes_teaching_date=:date and takes_ice_start_time=:iceStart and takes_slot_start_time=:slot and camp=:camp");
  $dbh->beginTransaction();
  $statement->execute(array(':email'=>$email,':date'=>$_POST['date'],':iceStart'=>$_POST['iceStart'],':slot'=>$_POST['slot'],':camp'=>$_SESSION['camp']));
  $dbh->commit();
}



if($type === "coach"){
  echo "Your registered teaching slots for $camp <br>";
  echo "Each slot is 15 minutes long <br>";
  echo "Please contact a camper if you decide to drop a slot they have registered for<br>";
  include('config.php');
  $qry = "select * from teaches s left join takes t on s.teaches_ice_start_time = t.takes_ice_start_time and s.teaches_slot_time = t.takes_slot_start_time and s.teaches_teaching_date = t.takes_teaching_date and s.camp = t.camp left join campers c on t.camper_email = c.email  where s.coach_email = '$email' and s.camp = '$camp'";
  $statement = $dbh->query($qry);
  echo "<table border ='1'>";
  echo "<TR> <TH> Date </TH> <TH> Start Time </TH> <TH> Camper </TH> <TH> Camper's Email </TH> <TH> Camper's Address </TH> <TH> Camper's Phone Number </TH> <TH> Camper's Emergency Contact </TH> <TH> Drop </TH> </TR>";
  foreach($statement as $row){
   echo '<TR>';
   echo '<form method=post action="">';
   echo '<TD> '.$row[1].' </TD>';
   echo '<input type="hidden" name="date" value="'.$row[1].'">';
   echo '<TD> '.$row[3].' </TD>';
   echo '<input type="hidden" name="slot" value="'.$row[3].'">';
   echo '<TD> '.$row[11].' </TD>';
   echo '<TD> '.$row[12].' </TD>';
   echo '<TD> '.$row[14].' </TD>';
   echo '<TD> '.$row[15].' </TD>';
   echo '<TD> '.$row[16].' </TD>';
   echo '<input type="hidden" name="cemail" value="'.$row[12].'">';
   echo '<input type="hidden" name="iceStart" value="'.$row[2].'">';
   echo '<TD> <input type="submit" name="drop" value="drop"> </TD>';
   echo '</form>';
   echo '</TR>';
 }
}
if(isset($_POST['drop'])){
  include('config.php');
  $statement =$dbh->prepare("delete from teaches where coach_email=:email and teaches_teaching_date=:date and teaches_ice_start_time=:iceStart and teaches_slot_time=:slot and camp=:camp");
  $statement2 =$dbh->prepare("delete from takes where camper_email=:cemail and takes_teaching_date=:date and takes_ice_start_time=:iceStart and takes_slot_start_time=:slot and camp=:camp");
  $dbh->beginTransaction();
  $statement->execute(array(':email'=>$email,':date'=>$_POST['date'],':iceStart'=>$_POST['iceStart'],':slot'=>$_POST['slot'],':camp'=>$_SESSION['camp']));
  if($_POST['cemail'] !== NULL){
    $statement2->execute(array(':cemail'=>$_POST['cemail'],':date'=>$_POST['date'],':iceStart'=>$_POST['iceStart'],':slot'=>$_POST['slot'],':camp'=>$_SESSION['camp']));
  }
  $dbh->commit();
}
?>