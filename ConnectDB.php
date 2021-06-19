<?php
      
      
  // $con = mysqli_connect('localhost' , 'root' ,'') ;

  // if (!$con)
  // {
  //    echo 'no Connection' ;
  //    exit()  ;
  // }
  
  // else
  // {
  //   $con = mysqli_select_db('shop', $con) ; 
  //   echo 'You Are Connected' ;
  // }
    



define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'shop');


try
{ //create PDO connection
 $con = new PDO("mysql:host=" . DBHOST . ";port=3306 ;dbname=" . DBNAME, DBUSER, DBPASS);
 $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 $con->exec("SET NAMES 'utf8';");
//  echo 'You Are Conncted' ;
 }
 
 catch (PDOException $e)
 { //show error
  echo 'CONNECTION FIELD'. $e->getMessage()  ;
  exit();
 }

 
?> 