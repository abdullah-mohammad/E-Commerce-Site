<?php

    function lang( $phrase ){
        
        static $lang = array(
            
            //Navbar Links
            
            'HOME_ADMIN'    =>'Home',
            'CATEGORIES'    =>'Categories',
            'ITEMS'         =>'Items',
            'MEMBERS'       =>'Members',
            'STATISTICS'    =>'Statistics',
            'LOGS'          =>'Logs',
            'EDIT_PROFILE'  =>'Edit Profile',
            'SETTINGS'      =>'Settings',
            'LOGOUT'        =>'Logout',
        );
        
        return $lang[$phrase];
    }