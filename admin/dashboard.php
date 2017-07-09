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
        $numUsers = 6;
        
        // get latest Members
        $latestUsers = getLatest('*','users','UserID',$numUsers);

        // items number  
        $numItems = 6;
        
        // get latest items
        $latestItems = getLatest('*','items','Item_ID',$numItems);

        // comments number  
        $numComments = 6;
        

        ?>
        
        <div class="container home-stats text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span><a href="members.php"><?php echo countItems('UserID','users'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Pending Members
                            <span><a href="members.php?do=Manage&page=Pending">
                                <?php echo checkItem('RegStatus','users',0) ?>
                            </a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tags"></i>
                        <div class="info">
                            Total Items
                            <span><a href="items.php"><?php echo countItems('Item_ID','items'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Comments
                            <span><a href="comments.php"><?php echo countItems('c_id','comments'); ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php
                            foreach($latestUsers as $user){

                                echo '<li>
                                        <i class="fa fa-user"></i> '.$user['Username'].' 
                                        <a href="members.php?do=Edit&userid='.$user['UserID'].'">
                                            <span class="btn btn-success pull-right">
                                                <i class="fa fa-edit"></i> Edit</a>';
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
                            <i class="fa fa-tags"></i> Latest <?php echo $numItems ?> Items
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php
                            foreach($latestItems as $item){

                                echo '<li>
                                        <i class="fa fa-tag"></i> '.$item['Name'].' 
                                        <a href="items.php?do=Edit&itemid='.$item['Item_ID'].'">
                                            <span class="btn btn-success pull-right">
                                                <i class="fa fa-edit"></i> Edit</a>';
                                if($item['Approve']== 0){
                                    echo '<a href="items.php?do=Approve&itemid='.$item['Item_ID'].'" class="btn btn-info pull-right activate"><i class="fa fa-check"></i> Approve</a>';
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
                
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments-o"></i> Latest <?php echo $numComments ?> Comments
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                            <?php
                            // select all Comments
                            $stmt = $con->prepare("SELECT comments.*,users.Username AS Member_Name FROM comments
                                                    INNER JOIN users ON users.UserID = comments.user_id 
                                                    ORDER BY c_id DESC 
                                                    LIMIT $numComments");
                            
                            // Execute query
                            $stmt->execute();
                            
                            // fetch the data
                            $comments = $stmt->fetchAll();
                            
                            if(!empty($comments)){
                                foreach($comments as $comment){
                                    echo '<div class="comment-box">';
                                        echo '<span class="member-n">'.$comment['Member_Name'].'</span>';
                                        echo '<p class="member-c">'.$comment['comment'].'</p>';
                                    echo '</div>';
                                    
                                }
                            }

                            ?>
                            </ul>
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