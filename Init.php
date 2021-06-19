<?php

include 'ConnectDB.php' ;

$tmps = "include/templets/" ;
$langs = "include/languages/" ;
$func = "include/Functions/" ;
$css  = "layout/css/" ;
$js  = "layout/js/" ;

include $langs . 'english.php' ;
include $func . 'Func.php' ;
include $tmps . 'head.php' ;
include $tmps . 'footer.php' ;


if(!isset ($noNavBar))  { include $tmps . 'navbar.php' ; }

?>