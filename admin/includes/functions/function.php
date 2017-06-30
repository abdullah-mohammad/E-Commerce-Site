<?php

    /*
    ** Title function that echo the page title in case the page
    ** has the variable $pageTitle and echo default title for other pages
    */

    function getTitle(){
        global $pageTitle;
        echo (isset($pageTitle)? $pageTitle : 'Default');
    }