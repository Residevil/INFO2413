<?php 
require_once 'Controllers/authController.php';
require_once 'Controllers/SearchEngine.php';
require_once 'config/db.php';


if(isset($_POST['editUser-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    
    //Validation
    if(empty($username)) {
        $errors['username'] = "Username required";
    }
    if(empty($email)) {
        $errors['email'] = "Email required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }

    if(empty($usertype)) {
        $errors['usertype'] = "User type required";
    }  

    $sql = "SELECT id, username FROM users WHERE username = '".$username."'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) {
        $id = $row['id'];
    }
    $result->free_result();

    $sql1 = "SELECT * FROM user_type WHERE usertype ='".$usertype."'";
    $result = $conn->query($sql1);
    while ($row = $result->fetch_array()) {
        $usertype_id = $row['id'];
    }
    $result->free_result();
    

    $editUser = "UPDATE users SET 
            username=?,
            email=?,      
            usertype_id=?       
            WHERE id = ?";
    $stmt = $conn->prepare($editUser);
    $stmt->bind_param('ssii', $username, $email, $usertype_id, $id);
    $stmt->execute();
    $_SESSION['message'] = "User is updated successfully.";
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
    <title>Register</title>
</head>
<body>
    <div>
        <a href="index.php"><button name="index" style="float: right;" class="btn btn-primary btn-lg">Homepage</button></a>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div">
            <form action="editUser.php" method="post" enctype="multipart/form-data">
                <h3 class="text-center">Edit User</h3>
                
                <?php if(count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="username">Username </label>
                    <input name="username"  value="<?php echo $_SESSION['edit_username']; ?>" class="form-control form-control-lg" required> </textarea>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email"  value="<?php echo $_SESSION['edit_email']; ?>" class="form-control form-control-lg" required> </textarea>
                </div>

                <div class="form-group">
                    <label for="usertype">User type</label>
                    <select name="usertype">
                        <option value=""></option>
                        <option value="Administrator"> Administrator </option>
                        <option value="Herbalist"> Herbalist </option>
                        <option value="RegularUser"> Regular User </option>
                    </select>
                </div>

                <div>
                    <button type="submit" name="editUser-btn" class="btn btn-primary btn-lg">Edit User</button>
                    <button type="submit" onclick="history.back()" class="btn btn-primary btn-lg">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>