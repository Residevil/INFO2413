<?php 
require_once 'Controllers/authController.php';
require_once 'Controllers/SearchEngine.php';
require_once 'config/db.php';

if(isset($_POST['ManageUser'])) {
    $H = 'hidden';
    header('location: edit_delete.php');
}

if($_SESSION['usertype'] == "RegularUser") {
    $editH= 'hidden';
} else {
    $editH = "visible";
}

if($_SESSION['usertype'] == "Administrator") {
    $editU = 'visible';
} else {
    $editU = 'hidden';
}

if(isset($_POST['add'])) {
    header('location: add.php');
}

if(isset($_POST['edit_delete'])) {
    $U = 'hidden';
    header('location: edit_delete.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
    <title>Homepage</title>
</head>
<body>
    <div>
        <button name="ManageUser" style="float: left; visibility: <?php echo $editH; ?>;" class="btn btn-primary btn-lg">Manager User</button>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 form-div login">
            
            <?php if(isset($_SESSION['message'])) : ?>
                <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                    <?php 
                        echo $_SESSION['message']; 
                        unset($_SESSION['message']);
                        unset($_SESSION['alert-class']);
                    ?>
                </div>
            <?php endif ?>
            
            <h3> Welcome <?php echo $_SESSION['username']; ?></h3>

            <form action="index.php" method="post">
                <div>
                    <button name="edit_delete" style="float: right; visibility: <?php echo $editH; ?>;">Edit/Delete Herb</button>
                    <button name="add" style="float: right; visibility: <?php echo $editH; ?>;">Add Herb</button>          
                </div>
            </form>
  
            <a href="index.php?logout=1" class="logout">logout</a>
            
            <div class="alert alert-warning">
                Search for Herb:
            </div>
                
            <form action="index.php" method="post">
                <div>
                    <input type="text" name="search" class="form-control form-control-lg">
                    <button type="search" name="search-btn">Search</button>
                </div>
            </form>
            <div>
                <?php if(!empty($output)) {
                    echo $output;
                } ?>
                <?php if((empty($hidden))) : ?>
                    <h3>Herb Name: </h3>
                    <p><?php echo $_SESSION['herb_name']; ?>
                    <h3>Symptoms: </h3>
                    <p><?php echo $_SESSION['symptoms']; ?></p>
                    <h3>Medicinal Uses: </h3>
                    <p><?php echo $_SESSION['medicinal_uses']; ?></p>
                    <h3>Botanical Description: </h3>
                    <p><?php echo $_SESSION['botanical_description']; ?></p> 
                    <h3>Sample Formula: </h3>		   
                    <p><?php echo $_SESSION['sample_formula']; ?></p>  
                    <h3>Image: </h3> 
                    <p><?php echo $_SESSION['image']; ?></p>   
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
