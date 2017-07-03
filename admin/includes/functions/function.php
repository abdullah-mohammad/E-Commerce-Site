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
    ** Title function v 1.0
    ** Title function that echo the page title in case the page
    ** has the variable $pageTitle and echo default title for other pages
    */

    function getTitle(){
        global $pageTitle;
        echo (isset($pageTitle)? $pageTitle : 'Default');
    }

    /*
    ** Home Redirect function v 2.0
    ** Home Redirect function [this function accept Parameters]
    ** $theMsg  : echo the Error Message [Error , Seccess , Warning]
    ** $url     : the link you want redirect to
    ** §seconds : Seconds before redirecting
    */

    function redirectHome($theMsg,$url= null,$seconds = 3){
        
        if($url == null){
            
            $url = 'index.php';
            
            $link = 'home page';
            
        }else{
            $url = isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''? $_SERVER['HTTP_REFERER']:'index.php';
            
            $link = isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!==''?'previous page':'home page';
        }
        echo $theMsg;
        
        echo "<div class='alert alert-info'>You will be directed to $link after $seconds Seconds.</div>";
        
        header("refresh:$seconds;url=$url");
        
        exit();
    }

    /*
    ** check Items function v 1.0
    ** Function to check Itm in database [the function accept parameters]
    ** $select : the item to select         [Example: user , item , category]
    ** $from   : the table to select from   [Example: users , items , categories]
    ** $value  : the value of select        [Example: Abdullah , Box , Electronics]
    */

    function checkItem($select,$from,$value){
        
        global $con;
        
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        
        $statement->execute(array($value));
        
        $count = $statement->rowCount();
        
        return $count;
    }



    /*
    ** Count number of Items function v 1.0 
    ** Function to count number of items rows
    ** $item  : the item to count
    ** $table : the table to choose from
    */

    function countItems($item,$table){
        
        global $con;
        
        $stmt2 = $con->prepare(" SELECT COUNT($item) FROM $table");

        // Execute query
        $stmt2->execute();

        // fetch the data
        return $stmt2->fetchColumn();
    }


    /*
    **  Get latest Records function v 1.0
    ** function to get latest Items from database [Users , Items , Comments]
    ** $select : the item to select         [Example: * , user , item , category]
    ** $table  : the table to select from   [Example: users , items , categories]
    ** $limit  : numbers of records to get  [Example: 1 , 2 , 3 , 4 ..........]
    */

    function getLatest($select,$table,$order,$limit = 5){
        
        global $con;
        
        $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        
        $getStmt->execute();
        
        $rows = $getStmt->fetchAll();
        
        return $rows;
    }