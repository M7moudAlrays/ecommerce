<?php

// This Functipon Userd To echo 'Page Tittle'
// This Function Don't Take Any Prameters 

function getTitle()
{
    global $pageTitle ;
    
    if (isset($pageTitle))  { echo $pageTitle ;  }
    else {  echo 'Default' ; }
}
    
// This Function User To Echo 'Message' [Success , Error , Warning]
// Accept 5 Parameters [$page , $msg , $url , $seconds , $class]
// first Parameter [$page] Userd To echo Page Name That YOu Will Be Redirected To It
// Second Parameter [$msg] Userd To echo Message Content
//Third Parameter [$url] Userd To Store Page Link That You Will Redirected To It
//Fourth Parameter [$seconds] Userd To Store After How Much Second That You Want To Redirected To Next Page
//Fivth Parameter [$class] Userd To Store Type Div Class That You Will Use From Bootstrap

function redirectHome($msg , $url , $seconds = 8 , $class = 'alert alert-success')
{
    if  ($url == null)  { $url = 'Index.php'; }
    
    else { $url = (isset ($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : 'Index.php'; }
    
    echo "<div class ='$class'> $msg </div>" ;
    echo "<div class='$class'> You Will Be Redirectd To Home Page After $seconds Seconds </div>" ;
    header("refresh: $seconds ; url= $url") ;
    exit() ;
}

// This Function Used To Execute Select Query 
// Accept 3 Parameters [$colName , $tabName , $value]
// first Parameter [$colName] Userd To Store Column Name That You Want Select
// second Parameter [$tabName] Userd To Store Table Name That You Want Select From It
//fThird Parameter [$value] Userd To Store Column Value That You Want Select 

function checkItem($colName , $tabName , $value)
{
    global $con ;
    $stme = $con->prepare ("select $colName from $tabName where $colName = ?") ;
    $stme->execute(array ($value)) ;
    $count = $stme->rowCount() ;
    return $count ;
}

// This Function Used To Count Number Of Users 
// Accept 3 Parameters [$colName , $tabName , $value]
// first Parameter [$colName] Userd To Store Column Name That You Want Select
// second Parameter [$tabName] Userd To Store Table Name That You Want Select From It
//fThird Parameter [$value] Userd To Store Column Value That You Want Select 

function CountNumberOfUsers($colName , $tabName)
{
    global $con ;
    $stme =$con->prepare("select count($colName) from $tabName") ;
    $stme->execute() ;
    return $stme->fetchColumn() ; 
}


// This Function Used To Get Latest Users
// Accept 3 Parameters [$colN ,$tabN ,$orderCol ,$limit]
// first Parameter [$colN] Userd To Store Column Name That You Want Select
// second Parameter [$tabN] Userd To Store Table Name That You Want Select From It
// Third Parameter [$orderCol] Userd To Store Column Value That You Want Ordered By It 
// Forth Parameter [$limit] Userd To Store Number Of Recordes That You Want Select Its 

function getlatest($colN ,$tabN ,$orderCol ,$limit =3)
{
    global $con ;
    $st = $con->prepare ("select $colN  from $tabN order by $orderCol asc  Limit $limit") ;
    $st->execute() ;
    $colValue = $st->fetchAll() ;
    return $colValue ;
}

?>
