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
    = Manage Members Page
    = you can Add | Edit | Delete Members from here
    ================================================
    */
    session_start();
    if(isset($_SESSION['Username'])){
        
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        // Start Manage Page 
        if($do == 'Manage'){// Manage members page ##########################################################################################
            
            $query = isset($_GET['page'])&& $_GET['page']=='Pending'?'AND RegStatus = 0':'';
            
            // select all Users excapt Admins
            $stmt = $con->prepare(" SELECT * FROM users WHERE GroupID != 1 $query");
            
            // Execute query
            $stmt->execute();
            
            // fetch the data
            $rows = $stmt->fetchAll();
            
            ?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive"> 
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Username</td>
                            <td>E-Mail</td>
                            <td>Full Name</td>
                            <td>Registerd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php 
                        foreach($rows as $row){
                            echo "<tr>";
                                echo '<td>'.$row['UserID'].'</td>';
                                echo '<td>'.$row['Username'].'</td>';
                                echo '<td>'.$row['Email'].'</td>';
                                echo '<td>'.$row['FullName'].'</td>';
                                echo '<td>'.$row['Date'].'</td>';
                                echo '<td>
                                        <a href="members.php?do=Edit&userid='.$row['UserID'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="members.php?do=Delete&userid='.$row['UserID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                if($row['RegStatus']== 0){
                                    echo '<a href="members.php?do=Activate&userid='.$row['UserID'].'" class="btn btn-info activate"><i class="fa fa-check"></i> Activate</a>';
                                }
                                echo'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
            </div>
        <?php
        }elseif($do == 'Add'){// Add Members Page #########################################################################################
        ?>
            
                <h1 class="text-center">Add new Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="post">
                        <!-- Start username field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="username" class="form-control" required="required" placeholder="Username to login into shop" autocomplete="off" />
                            </div>
                        </div>
                        <!-- End username field -->
                        <!-- Start Password field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password must be hard and Complex" />
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!-- End Password field -->
                        <!-- Start Email field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="email" name="email" class="form-control" placeholder="E-Mail must be valid"  required="required" />
                            </div>
                        </div>
                        <!-- End Email field -->
                        <!-- Start Full Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="full" class="form-control" placeholder="Full Name appear in your profile page" required="required" />
                            </div>
                        </div>
                        <!-- End Full Name field -->
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
        }elseif($do == 'Insert'){// Insert members Page ################################################################################
            
            echo '<h1 class="text-center">Insert Member</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $user       = $_POST['username'];
                $pass       = $_POST['password'];
                $email      = $_POST['email'];
                $name       = $_POST['full'];
                
                $hashPass = sha1($_POST['password']);
                
                // validate the form
                $formErrors = array();
                
                if(strlen($user) < 4){
                    $formErrors[]='Username cant be less than <strong>4 characters</strong>';
                }
                if(strlen($user) > 20){
                    $formErrors[]='Username cant be more than <strong>20 characters</strong>';
                }
                if(empty($user)){
                    $formErrors[]='Username cant be <strong>empty</strong>';
                }
                if(empty($pass)){
                    $formErrors[]='Password cant be <strong>empty</strong>';
                }
                if(empty($name)){
                    $formErrors[]='Full name cant be <strong>empty</strong>';
                }
                if(empty($email)){
                    $formErrors[]='Email cant be <strong>empty</strong>';
                }
                
                // loop array and echo 
                foreach($formErrors as $error){
                    
                    echo '<div class="alert alert-danger">'.$error . '</div>';
                }
                
                // check if there's no error the update operation
                if(empty($formErrors)){
                    
                    //check if User exist in Database
                    $check = checkItem("Username","users",$user);
                    
                    if($check == 1){
                        
                        $theMsg = '<div class="alert alert-danger">Sorry this User is exist.</div>';
                        redirectHome($theMsg,'back');
                        
                    }else{
                        
                        // Insert new User in the database with the info
                        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date) VALUES(:zuser ,:zpass ,:zmail ,:zname,1 ,now()) ");

                        // Execute query
                        $stmt->execute(array('zuser'=>$user,'zpass'=>$hashPass,'zmail'=>$email,'zname'=>$name));

                        // echo seccess message
                        $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Inserted</div>';
                        redirectHome($theMsg,'back');
                    }
                }else{
                    redirectHome('','back');
                }
                
            }else{
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                redirectHome($theMsg);
            }
            echo '</div>';
            
        }elseif($do == 'Edit'){// Edit Page ###########################################################################################
            
            // check if get request is numeric and get the integer value of it
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
            
            // select all data debend on this ID
            $stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? LIMIT 1");
            
            // Execute query
            $stmt->execute(array($userid));
            
            // fetch the data
            $row = $stmt->fetch();
            
            // the row count
            $count = $stmt->rowCount();
            
            // if there's such ID show the form
            if($stmt->rowCount() > 0){?>
                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="userid" value="<?php echo $userid ?>" autocomplete="off" />
                        <!-- Start username field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" required="required" autocomplete="off" />
                            </div>
                        </div>
                        <!-- End username field -->
                        <!-- Start Password field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                                <input type="password" name="newpassword" class="password form-control" autocomplete="new-password" placeholder="leave blank if you dont want to change" />
                                <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!-- End Password field -->
                        <!-- Start Email field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="email" name="email" class="form-control" required="required" value="<?php echo $row['Email'] ?>" />
                            </div>
                        </div>
                        <!-- End Email field -->
                        <!-- Start Full Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="full" class="form-control" required="required" value="<?php echo $row['FullName'] ?>" />
                            </div>
                        </div>
                        <!-- End Full Name field -->
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
                echo '<h1 class="text-center">Edit Member</h1>
                      <div class="container">';
                $theMsg = '<div class="alert alert-danger">Ther\'s No such ID</div>';
                redirectHome($theMsg);
                echo '</div>';
            }
        }elseif($do == 'Update'){// Edit Page ###########################################################################################
            
            echo '<h1 class="text-center">Update Member</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $id         = $_POST['userid'];
                $user       = $_POST['username'];
                $email      = $_POST['email'];
                $name       = $_POST['full'];
                
                // password trick
                
                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
                
                // validate the form
                $formErrors = array();
                
                if(strlen($user) < 4){
                    $formErrors[]='Username cant be less than <strong>4 characters</strong>';
                }
                if(strlen($user) > 20){
                    $formErrors[]='Username cant be more than <strong>20 characters</strong>';
                }
                if(empty($user)){
                    $formErrors[]='Username cant be <strong>empty</strong>';
                }
                if(empty($name)){
                    $formErrors[]='Full name cant be <strong>empty</strong>';
                }
                if(empty($email)){
                    $formErrors[]='Email cant be <strong>empty</strong>';
                }
                
                // loop array and echo 
                foreach($formErrors as $error){
                    
                    echo '<div class="alert alert-danger">'.$error . '</div>';
                }
                
                // check if there's no error the update operation
                if(empty($formErrors)){
                    
                    // update the database with the info
                    $stmt = $con->prepare(" UPDATE users SET Username = ?,Email = ?,Fullname = ?,Password = ? WHERE UserID = ?");
                    $stmt->execute(array($user,$email,$name,$pass,$id));

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Update</div>';
                    redirectHome($theMsg,'back');
                    
                }else{
                    redirectHome('','back');
                }
                
            }else{
                
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                
                redirectHome($theMsg);
            }
            echo '</div>';
            
        }elseif($do == 'Delete'){// Delete Page ###########################################################################################
            
            echo '<h1 class="text-center">Delete Member</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
                
                //check if User exist in Database
                $check = checkItem("UserID","users",$userid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" DELETE FROM users WHERE UserID = :zuserid");

                    $stmt->bindParam(':zuserid',$userid);

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
            
        }elseif($do == 'Activate'){// Activate Page #########################################################################################
            
            echo '<h1 class="text-center">Activate Member</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']) : 0;
                
                //check if User exist in Database
                $check = checkItem("UserID","users",$userid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" UPDATE users SET RegStatus = 1 WHERE UserID = ?");

                    // Execute query
                    $stmt->execute(array($userid));

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Activated</div>';
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