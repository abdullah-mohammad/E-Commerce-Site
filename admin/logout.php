<?php
    /*
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
    */

    session_start();    // Start the Session

    session_unset();    // Unset the Data

    session_destroy();  // Destroy the Session

    header('Location: index.php');

    exit();