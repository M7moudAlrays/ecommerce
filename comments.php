<?php

session_start();

$pageTitle = 'comments Page' ;

// First We Do Check There Is Session For User Logined Here ?
if (isset($_SESSION['UserNameSe']))
{
    include 'init.php';
    
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;
    if ($do == 'manage')
   
      {  
          $stmt =$con->prepare ("select comments.* , items.itemname , users.UserName    from comments 

                                            inner join items on comments.item_id    = items.itemid 
                                             
                                            inner join users on comments.user_Id = users.UserId ") ;
        $stmt->execute() ;
        $rows = $stmt->fetchAll() ;              
?>
       <h1 class= 'text-center'> Manage comments
       <div class= 'container'>
        <div class= 'table-responsive'>
            <table class= 'main-table table table-bordered'>
                <tr>
                    <td> #ID </td>
                    <td> comment </td>
                    <td> status </td>
                    <td> date </td>
                    <td> itemid </td>
                    <td> userid </td>
                    <td> Control </td>
                
                </tr>
<?php                   
                    foreach ($rows as $row)
                    {
                        echo "<tr>" ; 
                                echo "<td>  $row[0]   </td>" ;
                                echo "<td>  $row[1]   </td>" ;
                                echo "<td>  $row[2]   </td>" ;
                                echo "<td>  $row[3]   </td>" ;
                                echo "<td>  $row[6]   </td>" ;
                                echo "<td>  $row[7]   </td>" ;
                                echo "<td>
                                        <a href= '?do=edit&id=$row[0]'  class = 'btn btn-success'> 
                                        <i class ='fa fa-edit'> </i> Edit </a> 
                                        <a href= '?do=delete&id= $row[0]' class = 'btn btn-danger'>
                                        Delete <i class ='fa fa-close'></i>  </a> " ;
                                        
                                        if($row[2] == 1)
                                        {
                                            echo "<a href='?do=activate &id= $row[0]' class ='btn btn-info'> 
                                                  <i class ='fa fa-check'> </i> Approve </a> " ;
                                        } 
                                echo    " </td>" ;
                        echo "</tr>" ;
                    }
?>
           </table>
      
<?php   }

    
    elseif ($do == 'edit')
    {
        $comment_id = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval($_GET['id']) : 0 ;
        
        $stmt  = $con->prepare("SELECT  * FROM  comments") ;
        $stmt ->execute(array ($comment_id) ) ;
        $row = $stmt->fetch() ;
        $count = $stmt->rowCount();
        
        if ($count > 0)
        {
?>          
            <h1 class ='text-center'> Edit Comment </h1>
        
            <div class= 'container'>
            <form class ='form-horizontal' action ='?do=update'  method = 'POST'>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > comment Id </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type = 'text' name ='id' value = '<?php echo $row[0] ?>'  
                               class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>

                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Comment  </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'comment' value ='<?php echo $row [1] ?>' 
                               class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>
                
                
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Save Updates' ">
                    </div> 
                </div>               
            </form>
        </div>
<?php   }
            else
            {
                $msge =' Sorry This Id Not Found Here' ;
                $page = 'comments' ;
                redirectHome ($page , $msge ,'Back' , 4) ;
            }    
    }
        
    elseif ($do == 'update')
    {            
        if ($_SERVER['REQUEST_METHOD'] == "POST" )
        {
                        echo "<h1 class ='text-center'> Update Member  </h1>" ;

          $id      = $_POST [''] ;
          $user    = $_POST ['userName'] ;
          $email   = $_POST ['email'] ;
          $name    = $_POST ['fullUserName'] ;

               $stmt = $con->prepare("UPDATE  users SET  UserName = ? , Email = ? , FullName = ? , PassWord = ?
                                        WHERE UserId = ? "); 
               $stmt->execute(array($user , $email , $name , $pass , $id)) ;
               
               $msge = "<div>" . $stmt->rowCount() . " Record Updated </div>" ;
               $page = 'Edit' ;
               redirectHome($page , $msge , 'back' , 4) ;
           
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
            $comid= (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0  ;
            $check = checkItem ('c_id' , 'comments' , $comid) ;

            if($check > 0)
            {
                $stmt = $con->prepare ('delete from comments where c_id = :zu') ;
                $stmt->bindParam('zu', $comid) ;
                $stmt ->execute () ;
            
                $page = 'comments' ;
                $url = 'Back' ;
                $msge ="<div>" . $stmt->rowCount() . " Record Deleted </div>" ;
                redirectHome ($page , $msge , $url ,4);
            }
            else
            {
                $url = 'Back' ;
                $page = 'comments' ;
                $msge = "<div> error !! There Is No User Id =  $comid  Here </div>" ;
                $cls = 'alert alert-danger' ;
               
                redirectHome ($page , $msge , $url , 4 , $cls) ;
            }
    }
    elseif ($do = 'activate')
    {
        echo "<h1 class = 'text-center'> Activate Comment </h1>" ;
        
        $comment_id = (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0  ;
       
            $check = checkItem ('c_id' , 'comments' , $comment_id) ;

            if($check > 0)
            
            {
                $stmt = $con->prepare ('Update comments Set Status = 1 where c_id = ?') ;
                $stmt ->execute (array($comment_id)) ;
                
                $page = 'Comments' ;
                $msge ="<div>" . $stmt->rowCount() . " One Comment Activated </div>" ;
                redirectHome ($page , $msge ,4);
            }
            else
            {
                $url = 'Back' ;
                $page = 'comments' ;
                $msge = "<div> error !! There Is No Comment =  $comment_id  Here </div>" ;
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
