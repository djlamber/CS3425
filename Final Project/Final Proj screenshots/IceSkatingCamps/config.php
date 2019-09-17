<?php
try{
        $config = parse_ini_file("dbCamp.ini");
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e){
  print "Error!".$e->getMessage()."<br/>";
  die();
}
?>