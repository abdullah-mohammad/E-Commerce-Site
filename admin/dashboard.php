<?php
    /*
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
    */

    ob_start(); // Output buffering start

    session_start();
    if(isset($_SESSION['Username'])){
        
        $pageTitle = 'Dashboard';
        
        include 'init.php';
        
        // Start dashboard page
        // members number  
        $numLatest = 50;
        
        // get latest 5 Members
        $theLatest = getLatest('*','users','UserID',$numLatest);
        ?>
        
        <div class="container home-stats text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total Members
                        <span><a href="members.php"><?php echo countItems('UserID','users'); ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending Members
                        <span><a href="members.php?do=Manage&page=Pending">
                            <?php echo checkItem('RegStatus','users',0) ?>
                        </a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        Total Items
                        <span>200</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        Total Comments
                        <span>200</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest <?php $numLatest ?> Users
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php
                            foreach($theLatest as $user){

                                echo '<li>
                                        <i class="fa fa-user"></i> '.$user['Username'].' 
                                        <a href="members.php?do=Edit&userid='.$user['UserID'].'">
                                            <span class="btn btn-success pull-right">
                                                <i class="fa fa-edit"></i> Edit';
                                if($user['RegStatus']== 0){
                                    echo '<a href="members.php?do=Activate&userid='.$user['UserID'].'" class="btn btn-info pull-right activate"><i class="fa fa-check"></i> Activate</a>';
                                }
                                    echo '</span>
                                        </a>
                                      </li>';
                            }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest Items
                        </div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        
        // End dashboard page
        
        include $tpl.'footer.php';
        
    }else{
        header('Location: index.php'); // Redirect To Login Page
        
        exit();
    }
    
    ob_end_flush();

?>