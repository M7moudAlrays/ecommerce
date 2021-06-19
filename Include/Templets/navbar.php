 <nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class= "navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false" >
              <span class="sr-only">Toggle Navigation</span> 
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="dash.php"  target='_blank'> <?php echo lang('Home_Admin') ;?> </a>-->
        </div>
        
        <div class=" collapse navbar-collapse" id ="app-nav">
            <ul class="nav navbar-nav">
                <li> <a href="Categories.php"> <?php echo lang ('Sections') ; ?> </a> </li>
                <li> <a href="Items.php" target='_blank'> <?php echo lang ('Ite') ; ?> </a> </li>
                <li> <a href="members.php?do=manage"  target='_blank'> <?php echo lang ('Mem') ; ?> </a> </li>
                 <li> <a href="comments.php" target='_blank'><?php echo lang ('Com') ; ?> </a> </li>
                <li> <a href="#"><?php echo lang ('stat') ; ?> </a> </li>
                <li> <a href="#"><?php echo lang ('Lo') ; ?> </a> </li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false"> DropDown <span class="caret"></span> </a>
                 <ul class="dropdown-menu">
                    <li> <a href="Members.php?do=edit&UserId = <?php echo  $_SESSION['ID'] ?>"> Edit Profil </a> <li>
                    <li> <a href="#"> Settings </a> </li>
                    <li> <a href="LogOut.php"> Log Out </a> </li>
                 </ul>
               </li>
            </ul>
        </div>  
    </div>
 </nav>
 
 