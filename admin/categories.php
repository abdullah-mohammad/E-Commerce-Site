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
    = Categories Page
    ================================================
    */

    ob_start(); // Output buffering start

    session_start();

    if(isset($_SESSION['Username'])){
        
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        // Start Manage Page 
        if($do == 'Manage'){        // Manage page         ################################################################################
            
            $sort_array = array('ASC','DESC');
            
            $sort = isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)?$_GET['sort']:'ASC';
            // select all categories 
            $stmt = $con->prepare(" SELECT * FROM categories ORDER BY Ordering $sort");
            
            // Execute query
            $stmt->execute();
            
            // fetch the data
            $cats = $stmt->fetchAll();
            ?>
            
            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Manage Categories
                        <div class="option pull-right">
                            <a class="<?php echo $sort == 'ASC'?'active':''; ?>" href="?sort=ASC"><i class="fa fa-arrow-up"></i></a>
                            <a class="<?php echo $sort == 'DESC'?'active':''; ?>" href="?sort=DESC"><i class="fa fa-arrow-down"></i></a>
                              |  
                            <span class="active" data-view="full"><i class="fa fa-expand"></i></span>
                            <span  data-view="classic"><i class="fa fa-compress"></i></span>                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach($cats as $cat){
                            
                            echo '<div class="cat">';
                                echo '<div class="hidden-buttons">';
                                    echo '<a href="?do=Edit&catid='.$cat['ID'].'" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>';
                                    echo '<a href="?do=Delete&catid='.$cat['ID'].'" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> delete</a>';
                                echo '</div>';
                                echo '<h3>'.$cat['Name'].'</h3>';
                                echo '<div class="full-view">';
                                    echo '<p>';
                                    echo $cat['Description']==''?'No Description':$cat['Description'];
                                    echo '</p>';
                                    echo $cat['Visibility']==1?'<span class="visibility"><i class="fa fa-ban"></i> Visible</span>':'';
                                    echo $cat['Allow_Comment']==1?'<span class="commenting"><i class="fa fa-ban"></i> Comment</span>':'';
                                    echo $cat['Allow_Ads']==1?'<span class="advertises"><i class="fa fa-ban"></i> Ads</span>':'';
                                echo '</div>';
                            echo '</div>';
                            echo '<hr>';
                        }
                        ?>
                    </div>
                </div>
                <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New</a>
            </div>
            
            <?php
        }elseif($do == 'Add'){      // Add Page            ################################################################################
            ?>
            <h1 class="text-center">Add new Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="post">
                    <!-- Start Name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Name of the Category" autocomplete="off" />
                        </div>
                    </div>
                    <!-- End Name field -->
                    <!-- Start Description field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="description" class="form-control" placeholder="Describe the Category" />
                        </div>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Ordering field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="ordering" class="form-control" default="0" placeholder="Number to Arrange the Category" />
                        </div>
                    </div>
                    <!-- End Ordering field -->
                    <!-- Start Visibility field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10 col-sm-6">
                            <div>
                                <input id="visibility-yes" type="radio" name="visibility" value="0" checked />
                                <label for="visibility-yes">Yes</label>
                            </div>
                            <div>
                                <input id="visibility-no" type="radio" name="visibility" value="1" />
                                <label for="visibility-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visibility field -->
                    <!-- Start Commenting field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10 col-sm-6">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" />
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Commenting field -->
                    <!-- Start Ads field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10 col-sm-6">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads field -->
                    <!-- Start Submit field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>  
            <?php 
        }elseif($do == 'Insert'){   // Insert Page         ################################################################################
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                echo '<h1 class="text-center">Insert Category</h1>';
                echo '<div class="container">';
                
                // get the variabels from the form
                $name        = $_POST['name'];
                $desc        = $_POST['description'];
                $order       = $_POST['ordering']==null?0:$_POST['ordering'];
                $visible     = $_POST['visibility'];
                $comment     = $_POST['commenting'];
                $ads         = $_POST['ads'];
                    
                //check if Category exist in Database
                $check = checkItem("Name","categories",$name);

                if($check == 1){

                    $theMsg = '<div class="alert alert-danger">Sorry this Category is exist.</div>';
                    redirectHome($theMsg,'back');

                }else{

                    // Insert new category in the database with the info
                    $stmt = $con->prepare("INSERT INTO categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) VALUES(:zname,:zdesc,:zorder,:zvisible,:zcomment,:zads) ");

                    // Execute query
                    $stmt->execute(array(
                        'zname'=>$name,
                        'zdesc'=>$desc,
                        'zorder'=>$order,
                        'zvisible'=>$visible,
                        'zcomment'=>$comment,
                        'zads'=>$ads));

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Inserted</div>';
                    redirectHome($theMsg,'back');
                }
                
                
            }else{
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                redirectHome($theMsg);
            }
            echo '</div>';
        }elseif($do == 'Edit'){     // Edit Page           ################################################################################
            
            // check if get request is numeric and get the integer value of it
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
            
            // select all data debend on this ID
            $stmt = $con->prepare(" SELECT * FROM categories WHERE ID = ? LIMIT 1");
            
            // Execute query
            $stmt->execute(array($catid));
            
            // fetch the data
            $cat = $stmt->fetch();
            
            // the row count
            $count = $stmt->rowCount();
            
            // if there's such ID show the form
            if($stmt->rowCount() > 0){?>
                
                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="catid" value="<?php echo $catid ?>" autocomplete="off" />
                        <!-- Start Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="name" class="form-control" placeholder="Name of the Category" value="<?php echo $cat['Name']; ?>" required="required" autocomplete="off" />
                            </div>
                        </div>
                        <!-- End Name field -->
                        <!-- Start Description field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="description" class="form-control" placeholder="Describe the Category" value="<?php echo $cat['Description']; ?>" />
                            </div>
                        </div>
                        <!-- End Description field -->
                        <!-- Start Ordering field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="ordering" class="form-control" default="0" placeholder="Number to Arrange the Category" value="<?php echo $cat['Ordering']; ?>" />
                            </div>
                        </div>
                        <!-- End Ordering field -->
                        <!-- Start Visibility field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visible</label>
                            <div class="col-sm-10 col-sm-6">
                                <div>
                                    <input id="visibility-yes" type="radio" name="visibility" value="0" <?php echo $cat['Visibility']==0?'checked':''; ?>  />
                                    <label for="visibility-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="visibility-no" type="radio" name="visibility" value="1" <?php echo $cat['Visibility']==1?'checked':''; ?> />
                                    <label for="visibility-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Visibility field -->
                        <!-- Start Commenting field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10 col-sm-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php echo $cat['Allow_Comment']==0?'checked':''; ?> />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" <?php echo $cat['Allow_Comment']==1?'checked':''; ?> />
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Commenting field -->
                        <!-- Start Ads field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10 col-sm-6">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" <?php echo $cat['Allow_Ads']==0?'checked':''; ?> />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" <?php echo $cat['Allow_Ads']==1?'checked':''; ?> />
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Ads field -->
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
                echo '<h1 class="text-center">Edit Category</h1>
                      <div class="container">';
                $theMsg = '<div class="alert alert-danger">Ther\'s No such ID</div>';
                redirectHome($theMsg);
                echo '</div>';
            }
        }elseif($do == 'Update'){   // Update Page         ################################################################################
            
            echo '<h1 class="text-center">Update Category</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $id         = $_POST['catid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering']==null?0:$_POST['ordering'];
                $visible    = $_POST['visibility'];
                $comment    = $_POST['commenting'];
                $ads        = $_POST['ads'];
                
                // update the database with the info
                $stmt = $con->prepare(" UPDATE
                                            categories 
                                        SET 
                                            Name=?,
                                            Description=?,
                                            Ordering=?,
                                            Visibility=?,
                                            Allow_Comment=?,
                                            Allow_Ads=? 
                                        WHERE 
                                            ID = ?");

                $stmt->execute(array($name ,$desc ,$order ,$visible ,$comment ,$ads ,$id));

                // echo seccess message
                $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Update</div>';
                redirectHome($theMsg,'back');
                
                
            }else{
                
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                
                redirectHome($theMsg);
            }
            echo '</div>';
        }elseif($do == 'Delete'){ // Delete Page       ################################################################################
            
            echo '<h1 class="text-center">Delete Category</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']) : 0;
                
                //check if category exist in Database
                $check = checkItem("ID","categories",$catid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" DELETE FROM categories WHERE ID = :zcatid");

                    $stmt->bindParam('zcatid',$catid);

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
        }
        
        include $tpl.'footer.php';
        
    }else{
        header('Location: index.php'); // Redirect To Login Page
        
        exit();
    }

    ob_end_flush();

?>