<?php

session_start();
//$noNavBar = '' ;
$pageTitle = 'Members Page' ;

// First We Do Check There Is Session For User Logined Here ?
if (isset($_SESSION['UserNameSe']))
{
    include 'init.php';
    
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if ($do == 'manage')
    {
        $query = '' ;
        if (isset ($_GET['page']) == "pending")
        {
            $query = 'And RegStatus = 0' ;
        }
        $stmt =$con->prepare ("select * from users Where GroupId !=1   $query") ;
        $stmt->execute() ;
        $rows = $stmt->fetchAll() ;              
?>
       <h1 class= 'text-center'> Manage Members </h1>
       <div class= 'container'>
        <div class= 'table-responsive'>
            <table class= 'main-table table table-bordered'>
                <tr>
                    <td> #ID </td>
                    <td> User </td>
                    <td> Email </td>
                    <td> Full Name </td>
                    <td> Registerd Data </td>
                    <td> Regster Status </td>
                    <td> Control </td>
                
                </tr>
<?php                   
                    foreach ($rows as $row)
                    {
                        echo "<tr>" ; 
                                echo "<td>  $row[UserId]  </td>" ;
                                echo "<td>  $row[1]       </td>" ;
                                echo "<td>  $row[4]       </td>" ;
                                echo "<td>  $row[3]       </td>" ;
                                echo "<td>  $row[Date]       </td>" ;
                                echo "<td>  $row[7]    </td>" ;
                                echo "<td>
                                        <a href= '?do=edit&Id= $row[0]'  class = 'btn btn-success'> <i class ='fa fa-edit'> </i> Edit </a>
                                        <a href= '?do=delete&Id= $row[0]'  class = 'btn btn-danger'> Delete <i class ='fa fa-close'> </i> </a> " ;
                                        
                                        if($row['RegStatus'] == 0)
                                        {
                                            echo "<a href='members.php?do=activate&Id=$row[0]' class ='btn btn-success'> <i class ='fa fa-check'> </i> Active </a>" ;
                                        }
                                echo    " </td>" ;
                        echo "</tr>" ;
                    }
?>
           </table> 
        </div>
         <a href= '?do=add' class= 'btn btn-primary'> <i class= 'fa fa-plus'></i> Add New Member </a>
       </div>
      
<?php   }

    elseif ($do == 'add')
    {
      //echo 'Welcome You Are At Add Page ' ;  ?>

      <h1 class ='text-center'> Add New Member </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action ='?do=insert'  method = 'POST'>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > User Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'UserName'  class ='form-control' autocomplete = 'off' required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Pass Word </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='Password' name = 'PassWord'  class ='pass form-control' autocomplete = 'off'  required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Email </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'email'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Full Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'fullUserName'  class ='form-control'  required ='required' >
                    </div>                        
                </div>
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Add Member'  ">
                    </div> 
                </div>          
            </form>
        </div>

      <?php
    }
    
    elseif($do == 'insert')
    {
         if ($_SERVER['REQUEST_METHOD'] == "POST" )
        {
          echo "<h1 class ='text-center'> Insert Member </h1> " ;
          
          $user    = $_POST ['UserName'] ;
          $pass    = sha1 ($_POST ['PassWord'] );   
          $email   = $_POST ['email'] ;
          $name    = $_POST ['fullUserName'] ;

          // echo  $user  . '<br>' . $pass . '<br>'. $email . '<br>' . $name  . '<br>' ;

           $formerror = array() ; 
          
          
          if(empty($user))
          {
            $formerror [] = 'User Name Cant Be <strong> Empty <strong>' ; 
          }

          if(strlen($user) < 4)
          {
            $formerror [] = 'User Name Cant Be <strong> Less Than 4 Char </strong>'; 
          }

          if(strlen($user) > 10)
          {
            $formerror [] = 'User Name Cant Be <strong> Greater Than 10 Char </strong> '; 
          }


          if(empty($name))
          {
            $formerror [] = 'Full Name Cant Be <strong> Empty </strong>'; 
          }
          
           if (empty($pass))
          {
            $formerror [] ='Pass Word Cant Be <strong> Empty </strong>' ; 
          }

          if (empty($email))
          {
            $formerror [] ='Email Cant Be <strong> Empty </strong>' ; 
          }

          foreach ($formerror as $error ) 
          {
            echo '<div class = "alert alert-danger">' . $error . '</div>';
          }
          
          // For Add Member

          if(empty ($formerror))

           {
                $check = checkItem ("UserName" , "users" , $user) ;
                  
                if($check == 1)
                {
                  $cls = 'alert alert-danger' ;
                  $page = 'Add' ;
                  $msge = "Sorry You Cant Add This UserName  $user Again" ;
                  redirectHome ($page , $msge ,'B', 9 ,$cls) ;
                }
                
                else
                {             
                    $stmt = $con->prepare("INSERT INTO
                                                 users (UserName ,PassWord ,Email ,FullName ,RegStatus ,Date)
                                           VALUES (:Us ,:Pa ,:Ma ,:Na ,1 ,now() ) "); 
                    $stmt->execute(array(
                     
                             'Us' => $user ,
                             'Pa' => $pass ,
                             'Ma' => $email ,
                             'Na' => $name      )) ;
                    
                    $page = 'Add' ;
                    $msge ="<div>" . $stmt->rowCount() . " Record Added </div>" ;
                    redirectHome($page , $msge , 'B' , 4) ;
                }
           }

          
        }
        else
        { 
           $msge = 'Sorry :: You Cant Enter To Insert Page Directly' ;

           redirectHome($msge , 'back') ;
        }
    }
    
    elseif ($do == 'edit')
    {
        $userid = (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0 ;
        
        //echo $userid  . '<br>';
        
        $stmt  = $con->prepare("SELECT  * FROM  users  WHERE UserId = ? LIMIT 1") ;
        $stmt ->execute(array ($userid) ) ;
        $row = $stmt->fetch() ;
        $count = $stmt->rowCount();
        
        if ($count > 0)
        {
?>               
              <h1 class ='text-center'> Edit Member </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action ='?do=update'  method = 'POST'>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > User Id </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type = 'text' name ='iduser' value = '<?php echo $row ['UserId'] ?>'  class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>

                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > User Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'userName' value ='<?php echo $row ['UserName'] ?>' class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Pass Word </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='hidden' name = 'oldPassWord' value ="<?php echo $row['PassWord']?>" >
                        <input type ='Password' name = 'newPassWord'  class ='form-control' autocomplete = 'off' >
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Email </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'email' value = '<?php echo $row ['Email']?>'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Full Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'fullUserName'  value = '<?php echo $row ['FullName']?>'  class ='form-control'>
                    </div>                        
                </div>
                
                
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Save Updates'  ">
                    </div> 
                </div>
                                  
            </form>
        
        
        </div>
        
<?php           }
                else
                {
                     $msge =' Sorry This Id Not Found Here' ;
                     $page = 'Members' ;
                     redirectHome ($page , $msge ,'Back' , 4) ;
                }    
    }
        
    elseif ($do == 'update')
    {            
        if ($_SERVER['REQUEST_METHOD'] == "POST" )
        {
                        echo "<h1 class ='text-center'> Update Member  </h1>" ;

          $id      = $_POST ['iduser'] ;
          $user    = $_POST ['userName'] ;
          $email   = $_POST ['email'] ;
          $name    = $_POST ['fullUserName'] ;


          // Pass Word Track For Check 

           $pass = (!empty($_POST['newPassWord'])) ? $pass = sha1($_POST ['newPassWord']) : $pass = $_POST ['oldPassWord'] ; 

          // echo $id .'<br>' . $user  . '<br>' . $email . '<br>' . $name  . '<br>' ;

          $formerror = array() ; 
          
          
          if(empty($user))
          {
            $formerror [] = 'User Name Cant Be <strong> Empty <strong>' ; 
          }

          if(strlen($user) < 4)
          {
            $formerror [] = 'User Name Cant Be <strong> Less Than 4 Char </strong>'; 
          }

          if(strlen($user) > 10)
          {
            $formerror [] = 'User Name Cant Be <strong> Greater Than 10 Char </strong> '; 
          }

          if(empty($name))
          {
            $formerror [] = 'Full Name Cant Be <strong> Empty </strong>'; 
          }

          if (empty($email))
          {
            $formerror [] ='Email Cant Be <strong> Empty </strong>' ; 
          }

          foreach ($formerror as $error ) 
          {
            
            $msge = '<div>' . $error . '</div>';
            $page = 'Edit' ;
            $url = 'edit.php' ;
            $se = 3 ;
            $cls = 'alert alert-danger' ;
            
            redirectHome($page, $msge, $url ,$se ,$cls) ;
        
          }

          // For Update Record

          if(empty ($formerror))

           {
               $stmt = $con->prepare("UPDATE  users SET  UserName = ? , Email = ? , FullName = ? , PassWord = ?
                                        WHERE UserId = ? "); 
               $stmt->execute(array($user , $email , $name , $pass , $id)) ;
               
               $msge = "<div>" . $stmt->rowCount() . " Record Updated </div>" ;
               $page = 'Edit' ;
               redirectHome($page , $msge , 'back' , 4) ;
           }
           
        }
            
        else
        {
            $page = 'Index' ;
            $msge ='<div class = "$cls"> You Cant Enter To Update Page Directly </div>' ;
            redirectHome($page ,$msge , '' , 6 ) ;
        }
    }
    
    elseif ($do == 'delete')
    {   
            $userid = (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0  ;
       
            $check = checkItem ('UserId' , 'users' , $userid) ;

            if($check > 0)
            
            {
                $stmt = $con->prepare ('delete from users where UserId = :zu') ;
                $stmt->bindParam('zu', $userid) ;
                $stmt ->execute () ;
            
                $page = 'Members' ;
                $url = 'Back' ;
                $msge ="<div>" . $stmt->rowCount() . " Record Deleted </div>" ;
                redirectHome ($page , $msge , $url ,4);
            }
            else
            {
                $url = 'Back' ;
                $page = 'Member' ;
                $msge = "<div> error !! There Is No User Id =  $userid  Here </div>" ;
                $cls = 'alert alert-danger' ;
               
                redirectHome ($page , $msge , $url , 4 , $cls) ;
            }
    }
    elseif ($do = 'activate')
    {
        echo "<h1 class = 'text-center'> Activate Member </h1>" ;
        
        $userid = (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0  ;
       
            $check = checkItem ('UserId' , 'users' , $userid) ;

            if($check > 0)
            
            {
                $stmt = $con->prepare ('Update users Set RegStatus = 1 where UserId = ?') ;
                $stmt ->execute (array($userid)) ;
                
                $page = 'Members' ;
                $msge ="<div>" . $stmt->rowCount() . " One Record Activated </div>" ;
                redirectHome ($page , $msge ,4);
            }
            else
            {
                $url = 'Back' ;
                $page = 'Member' ;
                $msge = "<div> error !! There Is No User Id =  $userid  Here </div>" ;
                $cls = 'alert alert-danger' ;
               
                redirectHome ($page , $msge , $url , 4 , $cls) ;
            }
    }
    
    else
    {
      echo 'You Enter Page Name Not Founded ' ;
    }
    
    include $tmps . 'footer.php' ;
}
else
{
    header('location: Index.php') ;
    exit () ;
}
?>