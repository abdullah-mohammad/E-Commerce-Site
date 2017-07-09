<?php
    /*
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
    */
    /*
    ================================================
    = Template Page
    ================================================
    */
    ob_start(); // Output buffering start

    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle = 'Template';
        
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        // Start Manage Page 
        if($do == 'Manage'){        // Manage page         ################################################################################
            
        }elseif($do == 'Add'){      // Add Page            ################################################################################
            
        }elseif($do == 'Insert'){   // Insert Page         ################################################################################
            
        }elseif($do == 'Edit'){     // Edit Page           ################################################################################
            
        }elseif($do == 'Update'){   // Update Page         ################################################################################
            
        }elseif($do == 'Activate'){ // Activate Page       ################################################################################
            
        }
        
        include $tpl.'footer.php';
        
    }else{
        header('Location: index.php'); // Redirect To Login Page
        
        exit();
    }

    ob_end_flush();

?>