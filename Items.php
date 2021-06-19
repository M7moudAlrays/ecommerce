<?php
session_start();

// $noNavBar = '' ;

$pageTitle = 'Items Page' ;

// First We Do Check There Is Session For User Logined Here ?

if (isset($_SESSION['UserNameSe']))
{
    include 'init.php';
    
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if ($do == 'manage')
    {
        $stmt =$con->prepare ("select items.* ,categories.CatName , users.UserName    
                                            from items  
                                            inner join categories 
                                            on items.Cat_Id    = categories.CatId 

                                            inner join users  
                                            on items.Member_Id = users.UserId "  ) ;
        $stmt->execute() ;
        $items = $stmt->fetchAll() ;              
?>
       <h1 class= 'text-center'> Manage Items </h1>
       <div class= 'container'>
        <div class= 'table-responsive'>
            <table class= 'main-table table table-bordered'>
                <tr>
                    <td> #ID </td>
                    <td> Items </td>
                    <td> Description </td>
                    <td> price </td>
                    <td> Registerd Data </td>
                    <td> Country Made </td>
                    <td> Category Name </td>
                    <td> User Name </td>
                    <td> Control </td>
                </tr> 
<?php                   
                    foreach ($items as $item)
                    {
                        echo "<tr>" ; 
                                echo "<td>  $item[0]       </td>" ;
                                echo "<td>  $item[1]       </td>" ;
                                echo "<td>  $item[2]       </td>" ;
                                echo "<td>  $item[3]       </td>" ;
                                echo "<td>  $item[4]       </td>" ;
                                echo "<td>  $item[5]       </td>" ;
                                echo "<td>  $item[12]      </td>" ;
                                echo "<td>  $item[13]      </td>" ;
                                echo "<td>
                                        <a href= '?do=edit&id= $item[0]'  class = 'btn btn-success'> 
                                        <i class ='fa fa-edit'> </i> Edit </a>  
                                        <a href= '?do=delete&id= $item[0]'  class = 'btn btn-danger'> Delete 
                                        <i class ='fa fa-close'> </i> </a> " ;
                                        
                                        if($item['Approve'] == 0)
                                        {
                                            echo "<a href='items.php?do=approve&Id= $item[0]' class ='btn btn-info'> 
                                            <i class ='fa fa-check'> </i> Approve </a> " ;
                                        }
                                        
                                echo "</td>" ;
                        echo "</tr> " ;
                                       
                    }           
?>
           </table> 
        </div>
         <a href= '?do=add' class= 'btn btn-primary'> <i class= 'fa fa-plus'></i> Add New Item </a>
       </div> 
<?php

    }  
    elseif ($do == 'add')
    {
?>        <h1 class ='text-center'> Add New Item </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action ='?do=insert'  method = 'POST'>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Item Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'ItemName'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Descriping </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'Description'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Price </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'Price'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Country Made </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'C_Made'  class ='form-control'>
                    </div>                        
                </div>
                <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Item Status </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='sts' class ='form-control'>
                            <option value ='0' selected > ... </option>
                            <option value ='1'> Like New </option>
                            <option value ='2'> Used </option>
                            <option value ='3'> Very Old </option>
                        </select>
                    </div>
                </div>                
                <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Category </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='category' class ='form-control'>
                            <option value ='0'> ... </option>
<?php
                            $stm = $con->prepare ('select * from categories');
                            $stm ->execute () ;
                            $categories = $stm->fetchAll () ;
                            foreach ($categories as $cat)
                            {
                                echo "<option value ='".$cat ['CatId']."'>" .$cat ['CatName'] ."</option>" ;
                            }
?>
                        </select>
                    </div>
                </div>
                 <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Member </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='member' class ='form-control'>
                            <option value ='0'> ... </option>
<?php
                            $stm = $con->prepare('select * from users') ;
                            $stm ->execute() ;
                            $users = $stm->fetchAll() ;
                            foreach ($users as $user)
                            {
                                echo "<option value ='".$user ['UserId']."'> ". $user['UserName']."</option>" ;
                            }
?>
                        </select>
                    </div>
                </div>
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Add New Item'>
                    </div> 
                </div>
            </form>
        </div>
<?php
    }
    elseif ($do == 'insert')
    {
       if ($_SERVER['REQUEST_METHOD'] == "POST" )
        {
          echo "<h1 class ='text-center'> Insert Item </h1> " ;
          
          $itemName     = $_POST ['ItemName'] ;
          $desc         = $_POST ['Description'] ;   
          $priceItem    = $_POST ['Price'] ;
          $country      = $_POST ['C_Made'] ;
          $status       = $_POST ['sts'] ;
          $catId        = $_POST ['category'] ;
          $memId        = $_POST ['member'] ;
         
          
        echo  $itemName  . '<br>' . $desc . '<br>'. $priceItem . '<br>' . $country
              . '<br>' . $status .'<br>' .$memId . '<br>' . $catId ;
          
          $check = checkItem ("itemName" , "items" , $itemName) ;
              
            if($check == 1)
            {
              $cls = 'alert alert-danger' ;
              $msge = "Sorry You Cant Add This Item ( $itemName) Again" ;
              redirectHome ($msge ,'back', 4 ,$cls) ;
            }
            
            else
            {             
                $stmt = $con->prepare("INSERT INTO
                                             items (itemName ,Description ,Price ,Date ,countryMade ,Status ,Cat_Id ,Member_Id)
                                       VALUES (:itn ,:desc ,:price ,now() ,:country ,:status ,:ci ,:memi) ") ; 
                $stmt->execute(array(
                 
                         'itn'     => $itemName ,
                         'desc'    => $desc ,
                         'price'   => $priceItem ,
                         'country' => $country ,
                         'status'  => $status ,
                         'ci'      => $catId ,
                         'memi'    => $memId
                                                )) ;
                
                $msge ="<div>" . $stmt->rowCount() . " Item Added </div>" ;
                redirectHome($msge ,'B' ,4) ;
            }
        }

        else
        { 
           $msge = 'Sorry :: You Cant Enter To Insert Page Directly' ;

           redirectHome($msge ,'', 5) ;
        }
    }
    
    elseif($do == 'edit')
    {
        $itemid = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval($_GET['id']) : 0 ;
        
        $stmt  = $con->prepare("SELECT  * FROM  items  WHERE ItemId = ? LIMIT 1") ;
        $stmt ->execute(array ($itemid) ) ;
        $itemarray = $stmt->fetch() ;
        $count = $stmt->rowCount();
        
        if ($count > 0)
        {
?>               
              <h1 class ='text-center'> Edit Item </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action  ='?do=update'   method = 'POST'>
                        <input type = 'hidden' name ='ItemId' value = '<?php echo $itemarray ['0'] ?>' >
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Item Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'ItemName' value ='<?php echo $itemarray [1] ?>'
                               class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Description</label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'description' value ="<?php echo $itemarray[2]?>"
                               class ='form-control'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Price </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'Price' value = '<?php echo $itemarray [3]?>'
                               class ='form-control' required ='required'>
                    </div>                        
                </div>
                
                 <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Country Made </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'C_Made' value = '<?php echo $itemarray [5]?>'
                               class ='form-control' required ='required'>
                    </div>
                </div>
                 
                  <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Item Status </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='sts' class ='form-control'>
                            <option value ='0' <?php if($itemarray['Status'] == 0) {echo 'Selected' ; } ?> >...</option>
                            <option value ='1' <?php if($itemarray['Status'] == 1) {echo 'Selected' ; } ?> > Like New </option>
                            <option value ='2' <?php if($itemarray['Status'] == 2) {echo 'Selected' ; } ?> > Used </option>
                            <option value ='3' <?php if($itemarray['Status'] == 3) {echo 'Selected' ; } ?> > Very Old </option>
                        </select>
                    </div>
                </div>
                  
                 <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Category </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='category' class ='form-control'>
<?php
                            $stm = $con->prepare ('select * from categories');
                            $stm ->execute () ;
                            $categories = $stm->fetchAll () ;
                            foreach ($categories as $cat)
                            {
                                echo "<option value ='" .$cat['CatId'] ."' ";
                                if($itemarray['Cat_Id'] == $cat['CatId']) {echo 'Selected' ;}
                                echo ">" .$cat ['CatName'] ."</option>" ;
                            }
?>                      </select>
                    </div>
                </div>
                 <div class ='form-group form-group-lg'>
                    <label class ='col-sm-2 control-lable'> Member </label>
                    <div class ='col-sm-6 col-md-4'>
                        <select name ='member' class ='form-control'>     
<?php
                            $stm = $con->prepare('select * from users') ;
                            $stm ->execute() ;
                            $users = $stm->fetchAll() ;
                            foreach ($users as $user)
                            {
                                echo "<option value ='" . $user['UserId']."' " ;
                                if ($itemarray['Member_Id'] == $user['UserId']) { echo 'selected' ;}
                                echo ">" . $user['UserName'] ."</option>" ;
                            }
?>                      </select>
                    </div>
                </div>
                 
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Save Updates'  ">
                    </div> 
                </div>
                                  
            </form>
        
        </div>
<?php   }

        else
        {
             $msge =' Sorry This Id Not Found Here' ;
             redirectHome ($msge ,'Back' , 4) ;
        }    
    }
    elseif ($do == 'update')
    {
                   
        if ($_SERVER['REQUEST_METHOD'] == "POST" )
        {
                        echo "<h1 class ='text-center'> Update Member  </h1>" ;
                        
          $id          = $_POST ['ItemId'] ;
          $name        = $_POST ['ItemName'] ;
          $desc        = $_POST ['description'] ;
          $price       = $_POST ['Price'] ;
          $country     = $_POST ['C_Made'] ;
          $Status      = $_POST ['sts'] ;
          $catid       = $_POST ['category'] ;
          $memid       = $_POST ['member'] ;

               $stmt = $con->prepare("UPDATE  items SET  ItemName = ? , Description = ? , Price = ? ,
                                                CountryMade = ? ,Status = ? ,Cat_Id = ?  ,Member_Id = ? WHERE ItemId = ? ") ;
               
               $stmt->execute(array($name ,$desc ,$price ,$country ,$Status ,$catid ,$memid ,$id)) ;
               
               $msge = "<div>" . $stmt->rowCount() . " Record Updated </div>" ;
               $page = 'Edit' ;
               redirectHome($msge ,'back' ,5) ;
        }
            
        else
        {
            $msge = '<div class = "$cls"> You Cant Enter To Update Page Directly </div>' ;
            redirectHome($msge , '' , 6 ) ;
        }
    }
    
    elseif ($do == 'delete')
    {   
            $itemid = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval($_GET['id']) : 0  ;
       
            $check = checkItem ('ItemId' , 'items' , $itemid) ;

            if($check > 0)
            
            {
                $stmt = $con->prepare ('delete from items where ItemId = :zi') ;
                $stmt->bindParam('zi', $itemid) ;
                $stmt ->execute () ;
             
                $url = 'Back' ;
                $msge ="<div>" . $stmt->rowCount() . " Record Deleted </div>" ;
                redirectHome ($msge , $url ,5);
            }
            else
            {
                $url = 'Back' ;
                $msge = "<div> error !! There Is No User Id =  $itemid Here </div>" ;
                $cls = 'alert alert-danger' ;
               
                redirectHome ($msge , $url , 4 , $cls) ;
            }
    }
    
    elseif ($do = 'approve')
    {
        echo "<h1 class = 'text-center'> Approve Item </h1>" ;
        
        $itemid = (isset($_GET['Id']) && is_numeric($_GET['Id']) ) ? intval($_GET['Id']) : 0  ;
       
            $check = checkItem ('ItemId' , 'items' , $itemid) ;

            if($check > 0)
            
            {
                $stmt = $con->prepare ('Update items Set Approve = 1 where ItemId = ?') ;
                $stmt ->execute (array($itemid)) ;
                
                $url = 'Back' ;
                $msge ="<div>" . $stmt->rowCount() . " One Record Approved </div>" ;
                redirectHome ($msge ,$url ,5 );
            }
            else
            {
                $url = 'Back' ;
                $msge = "<div> error !! There Is No Item Id =  $itemid Here </div>" ;
                $cls = 'alert alert-danger' ;
               
                redirectHome ($msge , $url , 4 , $cls) ;
            }
    }
        
    
}
else
{
    header('location: Index.php') ;
    exit () ;
}
?>