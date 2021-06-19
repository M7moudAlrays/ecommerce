<?php
 
   function lang ($phrase)
   
   {
    
     static $lang = array (
      
     'Message'  => 'مرحبا' ,
     'Admin'    => 'بالمدير'
     
      );
  
      return $lang[$phrase] ;
   }

   
   

?>