<?php

    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //if the page is main page
    
    if($do == 'Manage'){
        
        echo 'You are in manage category page';
        echo '<a href="?do=Add">Add New Category +</a>';
        
    }elseif($do == 'Add'){
        
        echo 'You are in add page';
        
    }elseif($do == 'Insert'){
        
        echo 'You are in manage page';
        
    }else{
        
        echo 'Error no page';
        
    }