<?php

    $do ='' ;
    
    $do = isset($_GET['do']) ?  $_GET['do'] :  'manage' ;
    

     
    if ($do == 'manage')
    
    {
        echo 'Welcome You Are In Manage Page <br>' ;
        echo '<a href="Page.php ? do=add"> Add New Category <a> <br>' ;
        
    }
    
    elseif ($do == 'add')
    
    {
        echo 'Welcome You Are In Add Category Page ' ;
    }
    
    elseif ($do == 'insert')
    {
        echo 'Welcome You Are In Insert Page ' ;
        echo '<a href="Page.php ? do=insert"> Insert New Category <a>' ;
    }
    
    else
    {
        echo 'Error :: You Enter Page Name Not Founded ' ;
    }

?>