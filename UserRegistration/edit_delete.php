<?php 
require_once 'config/db.php';
require_once 'Controllers/authController.php';
require_once 'Controllers/SearchEngine.php';

if(isset($_POST['add'])) {
    header('location: add.php');
}

if(isset($_POST['edit-btn'])) {
    header('location: edit.php');

}

if(isset($_POST['delete-btn'])) {
    $herb_id = $_SESSION['herb_id'];
    $delete = "DELETE FROM herbs WHERE herb_id=?";
    $stmt=$conn->prepare($delete);
    $stmt->bind_param('i', $herb_id);
    $stmt->execute();
    $_SESSION['message'] = "Herb is deleted successfully.";
    $_SESSION['alert-class'] = "alert-success";
    header('location: index.php');
    exit();
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
    <title>edit_delete violation</title>
</head>
<body>
    <div>
        <a href="index.php"><button name="index" style="float: right;" class="btn btn-primary btn-lg">Homepage</button></a>
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
            
            <form action="edit_delete.php" method="post">
                <div>
                    <button name="add" style="float: right; visibility: <?php echo $edit; ?>;">Add Herb</button>          
                </div>
            </form>
  
            <a href="index.php?logout=1" class="logout">logout</a>
            
            <div class="alert alert-warning">
                Search for the Herb you wish to edit or delete:
            </div>
                
            <form action="edit_delete.php" method="post">

                <div>
                    <input type="text" name="search" class="form-control form-control-lg">
                    <button type="search" name="search-btn">Search</button>
                </div>

            <table class="table table-striped" <?php echo $table; ?>>
                <th>
                    <tr>
                        <th>Herb Name</th>
                        <th style="text-align: center;">Botanical Description</th>
                        <th></th>
                    </tr>
                </th>
                <?php if(!empty($table)) {
                    echo $output;
                } ?>
                <?php if(empty($hidden)) : ?>
                <tbody> 
                        <tr id="<?php echo $_SESSION['herb_id']; ?>">
                        <td><?php echo $_SESSION['herb_name']; ?></td>
                        <td><?php echo $_SESSION['botanical_description']; ?></td>
                        <td>
                            <button type="submit" name="edit-btn">Edit</button>
                            <button type="submit" name="delete-btn"  onclick="return confirm('Are you sure you want to delete this item?');"> Delete</button></td>   
                        </td>   
                        </tr>
                </tbody>
                <?php endif ?>
            </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>
