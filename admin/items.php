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
    = Items Page
    ================================================
    */
    ob_start(); // Output buffering start

    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle = 'Items';
        
        include 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        
        // Start Manage Page 
        if($do == 'Manage'){         // Manage page ###############################################################################
            
            //$query = isset($_GET['page'])&& $_GET['page']=='Pending'?'AND Approve = 0':'';

            // select all Items excapt Admins
            $stmt = $con->prepare("SELECT items.*,categories.Name AS Category_Name ,users.Username AS Member_Name FROM items
                                    INNER JOIN categories ON categories.ID = items.Cat_ID
                                    INNER JOIN users ON users.UserID = items.Member_ID
                                    ORDER BY Item_ID DESC");
            
            // Execute query
            $stmt->execute();
            
            // fetch the data
            $items = $stmt->fetchAll();
            
            ?>
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive"> 
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Username</td>
                            <td>Control</td>
                        </tr>
                        <?php 
                        foreach($items as $item){
                            echo "<tr>";
                                echo '<td>'.$item['Item_ID'].'</td>';
                                echo '<td>'.$item['Name'].'</td>';
                                echo '<td>'.$item['Description'].'</td>';
                                echo '<td>'.$item['Price'].'</td>';
                                echo '<td>'.$item['Add_Date'].'</td>';
                                echo '<td>'.$item['Category_Name'].'</td>';
                                echo '<td>'.$item['Member_Name'].'</td>';
                                echo '<td>
                                        <a href="items.php?do=Edit&itemid='.$item['Item_ID'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="items.php?do=Delete&itemid='.$item['Item_ID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                                    echo $item['Approve']== 0?'<a href="items.php?do=Approve&itemid='.$item['Item_ID'].'" class="btn btn-info activate"><i class="fa fa-check"></i> Approve</a>':'';
                                echo'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Item</a>
            </div>
        <?php
        }elseif($do == 'Add'){      // Add Page     ################################################################################
            ?>
            <h1 class="text-center">Add new Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="post">
                    <!-- Start Name field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Name of the Item" autocomplete="off" />
                        </div>
                    </div>
                    <!-- End Name field -->
                    <!-- Start Description field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="description" class="form-control" required="required" placeholder="Description of the Item" autocomplete="off" />
                        </div>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Price field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="price" class="form-control" required="required" placeholder="Price of the Item" autocomplete="off" />
                        </div>
                    </div>
                    <!-- End Price field -->
                    <!-- Start Country field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-sm-6">
                            <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made" autocomplete="off" />
                        </div>
                    </div>
                    <!-- End Country field -->
                    <!-- Start Status field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-sm-6">
                            <select name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status field -->
                    <!-- Start Member field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-sm-6">
                            <select name="member">
                                <option value="0">...</option>
                                <?php 
                                $stmt = $con->prepare("SELECT * FROM users ");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo '<option value="'.$user['UserID'].'">'.$user['Username'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Member field -->
                    <!-- Start Category field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-sm-6">
                            <select name="category">
                                <option value="0">...</option>
                                <?php 
                                $stmt = $con->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();
                                foreach ($cats as $cat) {
                                    echo '<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Category field -->
                    <!-- Start Submit field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                        </div>
                    </div>
                    <!-- End Submit field -->
                </form>
            </div>  
            <?php 
        }elseif($do == 'Insert'){   // Insert Page  ################################################################################
            echo '<h1 class="text-center">Insert Item</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $member     = $_POST['member'];
                $cat        = $_POST['category'];
                
                
                // validate the form
                $formErrors = array();
                
                if(empty($name)){
                    $formErrors[]='Name can\'t be <strong>empty</strong>';
                }
                if(empty($desc)){
                    $formErrors[]='Description can\'t be <strong>empty</strong>';
                }
                if(empty($price)){
                    $formErrors[]='Price can\'t be <strong>empty</strong>';
                }
                if(empty($country)){
                    $formErrors[]='Country can\'t be <strong>empty</strong>';
                }
                if($status == 0){
                    $formErrors[]='You must choose the <strong>Status</strong>';
                }
                if($member == 0){
                    $formErrors[]='You must choose the <strong>Member</strong>';
                }
                if($cat == 0){
                    $formErrors[]='You must choose the <strong>Category</strong>';
                }
                
                // loop array and echo 
                foreach($formErrors as $error){
                    
                    echo '<div class="alert alert-danger">'.$error . '</div>';
                }
                
                // check if there's no error the update operation
                if(empty($formErrors)){
                    //item_ID   Name    Description Price   Add_Date    Country_Made    Image   Status  Rating  Cat_ID  Member_ID
                    // Insert new User in the database with the info
                    $stmt = $con->prepare("INSERT INTO items (Name,Description,Price,Country_Made,Status,Add_Date,Cat_Id,Member_ID) VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus,now(),:zcat,:zmember) ");

                    // Execute query
                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $price,
                        'zcountry'  => $country,
                        'zstatus'   => $status,
                        'zcat'      => $cat,
                        'zmember'   => $member));

                    // echo seccess message
                    $theMsg = '<div class="alert alert-success">'.$stmt->rowCount().' Record Inserted</div>';
                    redirectHome($theMsg,'back');
                    
                }else{
                    redirectHome('','back');
                }
                
            }else{
                $theMsg = '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';
                redirectHome($theMsg);
            }
            echo '</div>';
        }elseif($do == 'Edit'){     // Edit Page    ################################################################################
            
            // check if get request is numeric and get the integer value of it
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
            
            // select all data debend on this ID
            $stmt = $con->prepare(" SELECT * FROM items WHERE Item_ID = ? LIMIT 1");
            
            // Execute query
            $stmt->execute(array($itemid));
            
            // fetch the data
            $item = $stmt->fetch();
            
            // the row count
            $count = $stmt->rowCount();
            
            // if there's such ID show the form
            if($stmt->rowCount() > 0){?>
                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="post">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>" autocomplete="off" />
                        <!-- Start Name field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="name" class="form-control" required="required" placeholder="Name of the Item" autocomplete="off" value="<?php echo $item['Name']; ?>" />
                            </div>
                        </div>
                        <!-- End Name field -->
                        <!-- Start Description field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="description" class="form-control" required="required" placeholder="Description of the Item" autocomplete="off"  value="<?php echo $item['Description']; ?>" />
                            </div>
                        </div>
                        <!-- End Description field -->
                        <!-- Start Price field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="price" class="form-control" required="required" placeholder="Price of the Item" autocomplete="off"  value="<?php echo $item['Price']; ?>" />
                            </div>
                        </div>
                        <!-- End Price field -->
                        <!-- Start Country field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-sm-6">
                                <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made" autocomplete="off"  value="<?php echo $item['Country_Made']; ?>" />
                            </div>
                        </div>
                        <!-- End Country field -->
                        <!-- Start Status field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-sm-6">
                                <select name="status">
                                    <option value="1" <?php echo $item['Status']==1?"selected":''; ?> >New</option>
                                    <option value="2" <?php echo $item['Status']==2?"selected":''; ?> >Like New</option>
                                    <option value="3" <?php echo $item['Status']==3?"selected":''; ?> >Used</option>
                                    <option value="4" <?php echo $item['Status']==4?"selected":''; ?> >Very Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status field -->
                        <!-- Start Member field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-sm-6">
                                <select name="member">
                                    <?php 
                                    $stmt = $con->prepare("SELECT * FROM users ");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                        echo '<option value="'.$user['UserID'].'"';
                                        if($item['Member_ID']==$user['UserID']){echo 'selected';}
                                        echo '>'.$user['Username'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Member field -->
                        <!-- Start Category field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-sm-6">
                                <select name="category">
                                    <?php 
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $cats = $stmt->fetchAll();
                                    foreach ($cats as $cat) {
                                        echo '<option value="'.$cat['ID'].'"';
                                        if($item['Cat_ID']==$cat['ID']){echo 'selected';}
                                        echo '>'.$cat['Name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Category field -->
                        <!-- Start Submit field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                        <!-- End Submit field -->
                    </form>
                    <?php
                    // select all Comments
                    $stmt = $con->prepare("SELECT comments.*,users.Username AS Member_Name FROM comments
                                            INNER JOIN users ON users.UserID = comments.user_id
                                            WHERE item_id = ?");
                    
                    // Execute query
                    $stmt->execute(array($itemid));
                    
                    // fetch the data
                    $rows = $stmt->fetchAll();
                    
                    if(!empty($rows)){
                        ?>
                        <h1 class="text-center"><?php echo $item['Name']; ?> Comments</h1>
                        <div class="container">
                            <div class="table-responsive"> 
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>Comment</td>
                                        <td>User Name</td>
                                        <td>Added Date</td>
                                        <td>Control</td>
                                    </tr>
                                    <?php 
                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo '<td>'.getShortText($row['comment'],50).'</td>';
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
                    <?php } ?>
                </div>  
            <?php 
            // if there's no such ID show error message
            }else{
                echo '<h1 class="text-center">Edit Item</h1>
                      <div class="container">';
                $theMsg = '<div class="alert alert-danger">Ther\'s No such ID</div>';
                redirectHome($theMsg);
                echo '</div>';
            }
        }elseif($do == 'Update'){   // Update Page  ################################################################################
            echo '<h1 class="text-center">Update Item</h1>';
            echo '<div class="container">';

            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                // get the variabels from the form
                $id         = $_POST['itemid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['status'];
                $cat        = $_POST['category'];
                $member     = $_POST['member'];
                
                // validate the form
                $formErrors = array();
                
                if(empty($name)){
                    $formErrors[]='Name can\'t be <strong>empty</strong>';
                }
                if(empty($desc)){
                    $formErrors[]='Description can\'t be <strong>empty</strong>';
                }
                if(empty($price)){
                    $formErrors[]='Price can\'t be <strong>empty</strong>';
                }
                if(empty($country)){
                    $formErrors[]='Country can\'t be <strong>empty</strong>';
                }
                if($status == 0){
                    $formErrors[]='You must choose the <strong>Status</strong>';
                }
                if($member == 0){
                    $formErrors[]='You must choose the <strong>Member</strong>';
                }
                if($cat == 0){
                    $formErrors[]='You must choose the <strong>Category</strong>';
                }
                
                // loop array and echo 
                foreach($formErrors as $error){
                    
                    echo '<div class="alert alert-danger">'.$error . '</div>';
                }
                
                // check if there's no error the update operation
                if(empty($formErrors)){
                    
                    // update the database with the info 
                    $stmt = $con->prepare(" UPDATE 
                                                items 
                                            SET 
                                                Name = ?,
                                                Description = ?,
                                                Price = ?,
                                                Country_Made = ?,
                                                Status = ?,
                                                Cat_Id = ?,
                                                Member_ID = ? 
                                            WHERE 
                                                Item_ID = ?");

                    $stmt->execute(array($name,$desc,$price,$country,$status,$cat,$member,$id));

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
        }elseif($do == 'Delete'){ // Activate Page################################################################################
            echo '<h1 class="text-center">Delete Item</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
                
                //check if User exist in Database
                $check = checkItem("Item_ID","items",$itemid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" DELETE FROM items WHERE Item_ID = :zitemid");

                    $stmt->bindParam('zitemid',$itemid);

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
        }elseif($do == 'Approve'){ // Activate Page################################################################################
            echo '<h1 class="text-center">Approve Item</h1>';
            echo '<div class="container">';
            
                // check if get request is numeric and get the integer value of it
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
                
                //check if Item exist in Database
                $check = checkItem("Item_ID","items",$itemid);

                // if there's such ID show the form
                if($check > 0){

                    // select all data debend on this ID
                    $stmt = $con->prepare(" UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                    // Execute query
                    $stmt->execute(array($itemid));

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