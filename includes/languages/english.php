<?php

    /*
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
    */

    function lang( $phrase ){
        
        static $lang = array(
            
            //Navbar Links
            
            'HOME_ADMIN'    =>'Home',
            'CATEGORIES'    =>'Categories',
            'ITEMS'         =>'Items',
            'MEMBERS'       =>'Members',
            'COMMENTS'      =>'Comments',
            'STATISTICS'    =>'Statistics',
            'LOGS'          =>'Logs',
            'EDIT_PROFILE'  =>'Edit Profile',
            'SETTINGS'      =>'Settings',
            'LOGOUT'        =>'Logout',
        );
        
        return $lang[$phrase];
    }