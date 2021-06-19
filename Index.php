 <?php
   
    session_start () ;
    
    $noNavBar = '' ;
    $pageTitle = 'Login' ;
    
   if (isset($_SESSION['UserNameSe']))
    {
      header ('location: dash.php') ;
    } 
   
    include 'init.php' ;
    
    if ($_SERVER ['REQUEST_METHOD'] == "POST" )
    {
      
      $userName = $_POST ['user'] ;
      $passWord = $_POST ['pass'] ;
      $hashPass = sha1 ($passWord) ;
      
     
      $stmt  = $con->prepare("SELECT  UserId , UserName , PassWord FROM  users
                            
                                     WHERE UserName = ?
                                     And   PassWord = ?
                                     And   GroupId  = 1 
                                     limit 1 ") ;
      
      $stmt ->execute(array ($userName , $hashPass) ) ;
      
      $row = $stmt->fetch() ;
      $count = $stmt->rowCount();
      
      if ($count > 0)
      {
         $_SESSION ['UserNameSe'] = $row ['UserName'] ;
         $_SESSION ['ID'] = $row['UserId'] ;
        
         header('locatiion: dash.php' ) ;
         exit() ; 
      }
      
    }
      
?>
        
        <form class ="login" action ="<?php  echo $_SERVER ['PHP_SELF'] ?>" method ="POST">
        
                              <h3> Admin Login </h3>
         <input class="form-control" type ="text" name ="user" placeholder ="UserName" autocomplete ="off" />
         <input class="form-control" type ="password" name ="pass" placeholder ="PassWord" autocomplete ="new-password" />
         <input class="btn btn-primary btn-block" type ="submit" value ="login" />
         
        </form>
        
        
 <?php  include $tmps .'footer.php' ; ?>