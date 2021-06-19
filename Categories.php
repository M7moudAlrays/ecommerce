<?php

session_start();

//$noNavBar = '' ;

$pageTitle = 'Category Page' ;

// First We Do Check There Is Session For User Logined Here ?

if (isset($_SESSION['UserNameSe']))
{
    include 'init.php';
    
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if ($do == 'manage')
    {
        $sort ='' ;
        $sort_array =array('Asc' ,'Desc') ;
        
        if(isset ($_GET['sort']) && in_array ($_GET['sort'] , $sort_array))
        {
            $sort =$_GET['sort'] ;
        }
        
        $stmt =$con->prepare ("select * from categories order by Ordering $sort ") ;
        $stmt->execute() ;
        $rows = $stmt->fetchAll() ;              
?>
       <h1 class ='text-center'> Manage Categories </h1> 
       <div class ='container'>
        <div class ='panel panel-default' >
            <div class ='panel panel-heading'> Manage Categories
                <div class ='ordering pull-right'>
                    Ordering:
                    <a class ='<?php if($sort == 'Asc') {echo 'active' ;} ?>' href ='?sort=Asc'> Asc </a>
                    <a class ='<?php if($sort == 'Desc') {echo 'active' ;} ?> 'href ='?sort=Desc'> Desc </a>
                </div>     
            </div>
            <div class ='panel panel-body'>     
<?php
                foreach ($rows as $row)
                {
                    echo "<div class ='cat'>" ;
                        echo "<div class='hidden-buttons'>" ;
                            echo "<a href='?do=edit&id= $row[0]' class ='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit </a>" ;
                            echo "<a href='?do=delete&id=" .$row[0] . "' class ='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete </a>" ;
                        echo "</div>" ;
                    
                         echo '<h2> This Is (' .$row [1] .') Category </h2>' ;
                         echo "<p>" ;
                            if ($row[2]=='') { echo 'Ther Is No Description For This Category' ;} 
                            else { echo 'The Description For This Category Is ((' . $row[2] .'))' ;} 
                         echo  "</p>" ;
                          if($row[4]==0)  { echo '<span class ="visibility"><i class ="fa fa-eye"></i> Hidden </span>' ;}
                          if($row[5]==0)  { echo '<span class ="commenting"><i class ="fa fa-close"></i> Comment Disabled</span>' ;}
                          if($row[6]==0)  { echo '<span class ="advertising"><i class ="fa fa-close"></i> Advertisied Disabled</span>' ;}
                    echo "</div>" ;
                }
?>
            </div>
        </div>
        <a href ='?do=add' class ='btn btn-primary'> <i class ='fa fa-plus'></i>Add Category </a>
       </div>
        
<?php   }
    
    elseif ($do == 'add')
    {    
?>
        <h1 class ='text-center'> Add New Category </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action ='?do=insert'  method = 'POST'>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Category Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'CategoryName'  class ='form-control' autocomplete = 'off' required ='required'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Descriping Category </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'Description'  class ='form-control'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Ordering Category  </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'Ordering'  class ='form-control'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Visibility Category? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Visibility' value = '1' checked >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Visibility' value = '0' >
                            <label> No </label>
                        </div>
                    </div>                        
                </div>
                
                 <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Comment For Category? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Commenting' value = '1' checked >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Commenting' value = '0' >
                            <label> No </label>
                        </div>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Add Advertsment Or No ? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Advertsing' value = '1' checked >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Advertsing' value = '0' >
                            <label> No </label>
                        </div>
                    </div>                        
                </div>
                
                <div class='form-group'>
                    <div class = 'col-sm-offset-2 col-sm-6'>
                        <input type = 'submit' class = 'btn btn-primary btn-lg'   value = 'Add Category'  ">
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
          echo "<h1 class ='text-center'> Insert Category </h1> " ;
          
          $catName   = $_POST ['CategoryName'] ;
          $desc      = $_POST ['Description'] ;   
          $order     = $_POST ['Ordering'] ;
          $visable   = $_POST ['Visibility'] ;
          $comment   = $_POST ['Commenting'] ;
          $adverts   = $_POST ['Advertsing'] ;

       // echo  $catName  . '<br>' . $desc . '<br>'. $order . '<br>' . $visable  . '<br>'. $comment .'<br>' . $adverts ;
          
          $check = checkItem ("CatName" , "categories" , $catName) ;
              
            if($check == 1)
            {
              $cls = 'alert alert-danger' ;
              $msge = "Sorry You Cant Add This CategoryName ( $catName ) Again" ;
              redirectHome ($msge ,'back', 4 ,$cls) ;
            }
            
            else
            {             
                $stmt = $con->prepare("INSERT INTO
                                             categories (CatName ,Description ,Ordering ,Visibility ,Allow_Com ,Allow_Ads)
                                       VALUES (:can ,:desc ,:order ,:visible ,:comm ,:advs) ") ; 
                $stmt->execute(array(
                 
                         'can' => $catName ,
                         'desc' => $desc ,
                         'order' => $order ,
                         'visible' => $visable ,
                         'comm'=> $comment ,
                         'advs' => $adverts 
                                            )) ;
                
                $msge ="<div>" . $stmt->rowCount() . " Category Added </div>" ;
                redirectHome($msge , 'B' , 4) ;
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
        $catid = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval($_GET['id']) : 0 ;
        
        //echo $userid  . '<br>';
        
        $stmt  = $con->prepare("SELECT  * FROM  categories  WHERE CatId = ? LIMIT 1") ;
        $stmt ->execute(array ($catid) ) ;
        $row = $stmt->fetch() ;
        $count = $stmt->rowCount();
        
        if ($count > 0)
        {
?>               
              <h1 class ='text-center'> Edit Category </h1>
        
        <div class= 'container'>
            <form class ='form-horizontal' action ='?do=update'  method = 'POST'>
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Category Id </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type = 'text' name ='idcat' value = '<?php echo $row ['CatId'] ?>'  class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Category Name </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'catname' value ='<?php echo $row [1] ?>' class ='form-control' autocomplete = 'off' required ='required' >
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Description</label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'description' value ="<?php echo $row[2]?>"  class ='form-control'>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' > Ordering </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <input type ='text' name = 'ordering' value = '<?php echo $row [3]?>'  class ='form-control' required ='required'>
                    </div>                        
                </div>
                
                 <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Visibility Category? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Visibility'  value = '1' <?php if($row [4] == 1) {echo 'Checked' ;}?> >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Visibility' value = '0' <?php if($row [4] == 0) {echo 'Checked' ;}?> >
                            <label> No </label>
                        </div>
                    </div>                        
                </div>
                 
                 <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Comment For Category? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Commenting' value = '1' <?php if($row [5] == 1) {echo 'Checked' ;}?> >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Commenting' value = '0' <?php if($row [5] == 0) {echo 'Checked' ;}?> >
                            <label> No </label>
                        </div>
                    </div>                        
                </div>
                
                <div class='form-group form-group-lg'>
                    <label class = 'col-sm-2 control-lable' >Add Advertsment Or No ? </label>
                    <div class = 'col-sm-6 col-md-4'>
                        <div>
                            <input  type ='radio' name = 'Advertsing' value = '1' <?php if($row [6] == 1) {echo 'Checked' ;}?> >
                            <label> Yes </label>
                        </div>
                        <div>
                            <input  type ='radio' name = 'Advertsing' value = '0' <?php if($row [6] == 0) {echo 'Checked' ;}?> >
                            <label> No </label>
                        </div>
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
                        echo "<h1 class ='text-center'> Update Category  </h1>" ;
                        
          $id          = $_POST ['idcat'] ;
          $name        = $_POST ['catname'] ;
          $desc        = $_POST ['description'] ;
          $ordering    = $_POST ['ordering'] ;
          $visable     = $_POST ['Visibility'] ;
          $comment     = $_POST ['Commenting'] ;
          $adverts     = $_POST ['Advertsing'] ;

               $stmt = $con->prepare("UPDATE  categories SET  CatName = ? , Description = ? , Ordering = ? ,
                                      Visibility = ? ,Allow_Com = ?  ,Allow_Ads = ? WHERE CatId = ? ") ;
               
               $stmt->execute(array($name ,$desc ,$ordering ,$visable ,$comment ,$adverts ,$id)) ;
               
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
                            echo "<h1 class ='text-center'> Delete Category  </h1>" ;
        $catid = (isset($_GET['id']) && is_numeric($_GET['id']) ) ? intval($_GET['id']) : 0  ;
        $check = checkItem ('CatId' , 'categories' , $catid) ;
    
        if($check > 0)
        {
            $stmt = $con->prepare ('delete from categories where CatId = :zc') ;
            $stmt->bindParam('zc', $catid) ;
            $stmt ->execute () ;                                                            
             
            $url  = 'B' ;
            $msge = "<div>" . $stmt->rowCount() . " Record Deleted </div>" ;
            redirectHome ($msge , $url ,4);
        }
        else
        {
            $url = 'B' ;
            $msge = "<div> error !! There Is No Categoty Id =  $catid  Here </div>" ;
            $cls = 'alert alert-danger' ;
    
            redirectHome ($msge , $url , 5 , $cls) ;
        }
    }
            
    include $tmps . 'footer.php' ;
}

else
{
    header('location: Index.php') ;
    exit () ;
}

?>