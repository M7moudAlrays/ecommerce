<?php
 
   function lang ($phrase)
   
   {
    
    static $lang = array (
      
     'Home_Admin'  => 'Home' ,
     'Sections'    => 'Categories' ,
     'Ite'         => 'items' ,
     'Mem'         => 'Members' ,
     'Com'         => 'Comments' ,
     'stat'        => 'Statices' ,
     'Lo'          => 'Logs'      ,
     'Edit'        => 'Update Member' 
     
      );
  
      return $lang[$phrase] ;
   }

      







?>