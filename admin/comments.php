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
    = Comments Page
    ================================================
    */

    ob_start(); // Output buffering start

    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle = 'Comments';
        
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        // Start Manage Page 
        if($do == 'Manage'){// Manage page ##########################################################################################
            
            // select all Comments
            $stmt = $con->prepare("SELECT comments.*,items.Name AS Item_Name ,users.Username AS Member_Name FROM comments
                                    INNER JOIN items ON items.Item_ID = comments.item_id
                                    INNER JOIN users ON users.UserID = comments.user_id
                                    ORDER BY c_id DESC");
            
            // Execute query
            $stmt->execute();
            
            // fetch the data
            $rows = $stmt->fetchAll();
            
            ?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive"> 
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php 
                        foreach($rows as $row){
                            echo "<tr>";
                                echo '<td>'.getShortText($row['comment'],50).'</td>';
                                echo '<td>'.$row['Item_Name'].'</td>';
                                echo '<td>'.$row['Member_Name'].'</td>';
                                echo '<td>'.$row['comment_date'].'</td>';
                                echo '<td>
                                        <a href="comments.php?do=Edit&comid='.$row['c_id'].'" class="btn btn-success">
                                            <i class="fa fa-edit"></i> Edit 
                                        </a>
                                        <a href="comments.php?do=Delete&comid='.$row['c_id'].'" class="btn btn-danger confirm">
                                            <i class="fa fa-close"></i> Delete
                                        </a>';
                                if($row['status']== 0){
                                    echo '<a href="comments.php?do=Approve&comid='.$row['c_id'].'" class="btn btn-info activate">
                                            <i class="fa fa-check"></i>Approve
                                        </a>';
                                }
                                echo'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        <?php
        }elseif($do == 'Edit'){// Edit Page ###########################################################################################
            
            // check if get request is numeric and get the integer value of it
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']) : 0;
            
            // select all data debend on this ID
            $stmt = $con->prepare(" SELECT * FROM comments WHERE c_id = ? LIMIT 1");
            
            // Execute query
            $stmt->execute(array($comid));
            
            // fetch the data
            $row = $stmt->fetch();
            
            // the row count
            $count = $stmt->rowCount();
            
            // if there's such ID show the form
            if($stmt->rowCount() > 0){?>
                <h1 class="text-center">Edit Comment</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="comid" value="<?php echo $comid ?>" autocomplete="off" />
                        <!-- Start Comment field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10 col-sm-6">
                                <textarea class="form-control" rows="6" name="comment"><?php echo $row['comment'] ?></textarea>
                            </div>
                        </div>
                        <!-- End Comment field -->
                        <!-- Start Submit field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                            </div>
                        </div>
                        <!-- End Submit field -->
                    </form>
                </div>
            <?php 
            // if there's no such ID show error message
            }else{
                echo '<h1 class="text-center">Edit Commenr</h1>
                      <div class="container">';
                $theMsg = '<div class="alert alert-danger">Ther\'s No such ID</div>';
                redirectHome($theMsg);
                echo '</div>';
            }
        }elseif($do == 'Update'){// Edit Page ###########################################################################################
            
            echo '<h1 class="text-center">Update Comment</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $id         = $_POST['comid'];
                $comment       = $_POST['comment'];
                    
                // update the database with the info
                $stmt = $con->prepare(" UPDATE comments SET comment = ? WHERE c_id = ?");
                $stmt->execute(array($comment,$id));

                // echo seccess message
                $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Update</div>';
                redirectHome($theMsg,'back');
                    
                
            }else{
                
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                
                redirectHome($theMsg);
            }
            echo '</div>';
            
        }elseif($do == 'Delete'){// Delete Page ###########################################################################################
            
            echo '<h1 class="text-center">Delete Comment</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']) : 0;
                
                //check if User exist in Database
                $check = checkItem("c_id","comments",$comid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" DELETE FROM comments WHERE c_id = :zcomid");

                    $stmt->bindParam('zcomid',$comid);

                    // Execute query
                    $stmt->execute();

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Deleted</div>';
                    redirectHome($theMsg,'back');
                    
                }else{
                    
                    $theMsg = '<div class="alert alert-danger">This ID is not exist</div>';
                    
                    redirectHome($theMsg);
                }
            echo '</div>';
            
        }elseif($do == 'Approve'){// Approve Page #####################################################################################
            
            echo '<h1 class="text-center">Approve Comment</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']) : 0;
                
                //check if User exist in Database
                $check = checkItem("c_id","comments",$comid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" UPDATE comments SET status = 1 WHERE c_id = ?");

                    // Execute query
                    $stmt->execute(array($comid));

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Approved</div>';
                    redirectHome($theMsg,'back');
                    
                }else{
                    
                    $theMsg = '<div class="alert alert-danger">This ID is not exist</div>';
                    
                    redirectHome($theMsg);
                }
            echo '</div>';
            
        }
        
        include $tpl.'footer.php';
        
    }else{
        header('Location: index.php'); // Redirect To Login Page
        
        exit();
    }

    ob_end_flush();

?>