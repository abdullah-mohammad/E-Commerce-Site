<?php
    /*
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
    */
    
    include 'admin/connect.php';

    // Routes

    $tpl    = 'includes/templates/';    // Template Directory
    $lang   = 'includes/languages/';    // Language Directory
    $func   = 'includes/functions/';    // functions Directory
    $css    = 'layout/css/';            // CSS Directory
    $js     = 'layout/js/';             // Js Directory
    


    // Include The Important Files

    include $func.'function.php';
    include $lang.'english.php'; 
    include $tpl.'header.php';
    