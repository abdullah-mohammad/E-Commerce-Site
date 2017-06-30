<?php
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
        if($do == 'Manage'){
            
            // Manage page
            
            echo 'You are in Manage';
            
        }elseif($do == 'Edit'){// Edit Page 
            
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
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" />
                            </div>
                        </div>
                        <!-- End username field -->
                        <!-- Start Password field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                            </div>
                        </div>
                        <!-- End Password field -->
                        <!-- Start Email field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" />
                            </div>
                        </div>
                        <!-- End Email field -->
                        <!-- Start Full Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>" />
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
                echo 'Theres No such ID';
            }
        }elseif($do == 'Update'){// Edit Page 
            echo '<h1 class="text-center">Update Member</h1>';
            
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
                
                if(strlen($user) < 8){
                    $formErrors[]='Username cant be less than 8 characters';
                }
                if(strlen($user) > 20){
                    $formErrors[]='Username cant be more than 20 characters';
                }
                if(empty($user)){
                    $formErrors[]='Username cant be empty';
                }
                if(empty($name)){
                    $formErrors[]='Full name cant be empty';
                }
                if(empty($email)){
                    $formErrors[]='Email cant be empty';
                }
                
                foreach($formErrors as $error){
                    
                    echo $error . '<br />';
                }
                
                // update the database with the info
                //$stmt = $con->prepare(" UPDATE users SET Username = ?,Email = ?,Fullname = ?,Password = ? WHERE UserID = ?");
                //$stmt->execute(array($user,$email,$name,$pass,$id));
                
                // echo seccess message
                //echo $stmt->rowCount().' Record Update';
                
            }else{
                echo 'Sorry you cant browse this page directly';
            }
        }
        
        include $tpl.'footer.php';
        
    }else{
        header('Location: index.php'); // Redirect To Login Page
        
        exit();
    }