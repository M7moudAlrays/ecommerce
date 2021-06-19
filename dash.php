<?php

session_start();
//$noNavBar = '' ;
$pageTitle = 'DashBoard' ;

if (isset($_SESSION['UserNameSe']))
{
    include 'init.php';
    
    $check = checkItem("RegStatus" ,"users" , '0')  ;
    
    $latestUsers = 2 ;
    $latest = getlatest('UserName' ,'users' ,'UserId' ,$latestUsers) ;
?>
<div class='container home text-center'>
    <h1> DashBoard </h1>
    <div class='row'>
        <div class='col-md-3'>
            <div class='stat st-members'> Total Members
                <a href='members.php' target='_blank'> <span class='fa fa-users'>
                <?php echo CountNumberOfUsers('UserId' , 'users') ; ?> </span> </a>
            </div>
        </div>
        
        <div class='col-md-3'>  
            <div class='stat st-pending'> Pending Members
                <a href='members.php?page=pending' target='_blank'> <span> <?php echo $check ; ?> </span> </a>
            </div>
        </div> 
        
        <div class='col-md-3'>
            <div class='stat st-items'> Total Items
                <a href ='items.php' target='_blank'> <span class='fa fa-tag' >
                <?php echo CountNumberOfUsers('ItemId' , 'items') ; ?> </span> </a>
            </div>
        </div>
        
        <div class='col-md-3'>
            <div class='stat st-comments'> Total Comments <span class="glyphicon glyphicon-comment"> 0
            </span> </div>
        </div>
    </div>
</div>

<div class='container latest'>
    <div class='row'> 
            <div class='col-sm-6'>
                <div class='panel panel-default'>
                        <div class='panel panel-heading'> <i class='fa fa-users'> </i>
                        Leatest Rigester Users Is (<?php echo $latestUsers ; ?>)
                        </div>
                        <div class='panel panel-body'>
                            <ul class ='list-unstyled'>
<?php
                                foreach ($latest as $last)
                                {
                                    echo "<li>" . $last['UserName'] ;
                                    echo "<a href='Members.php?do=edit&Id= $last[0] '> " ;
                                        echo "<span class='btn btn-success pull-right'> <i class ='fa fa-edit'></i> " ;
                                    echo "Edit </a></span></li>" ;    
                                }
?>
                            </ul>
                        </div>
                </div> 
            </div>
            <div class='col-sm-6'>
                    <div class='panel panel-default'>
                        <div class='panel panel-heading'> <i class='fa fa-tag'> </i> Leatest Items </div>
                        <div class='panel panel-body'> test </div>
                    </div>
            </div>
    </div>
</div>        
<?php      
    include $tmps . 'footer.php' ;
}
else
{
    header('location: Index.php') ;
    exit () ;
}
?>