<?php
    
    include 'connect.php';

    // Routes

    $tpl    = 'includes/templates/';    // Template Directory
    $css    = 'layout/css/';            // CSS Directory
    $js     = 'layout/js/';             // Js Directory
    $lang   = 'includes/languages/';    // Language Directory


    // Include The Important Files

    include $lang.'english.php'; 
    include $tpl.'header.php';
    
    // Include Navbar On All Pages Expect The One With $noNavbar Vairable
    if(!isset($noNavbar)){
        include $tpl.'navbar.php';
    }