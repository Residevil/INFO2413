<?php 

require_once 'Controllers/authController.php'; 
require_once 'config/db.php';


if($t = "register") {
    $title = "User Registration";
}

if($b = "register") {
    $button = "Register";
}

if($t = "add") {
    $title = "Add New User"; 
    $hide = "hidden";
    $ShowIndex = "";
}

if($t = "register") {
    $title = "Add User";
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
            <a href="index.php"><button name="index" style="float: right;" class="btn btn-primary btn-lg" <?php echo $ShowIndex ?>>Homepage</button></a>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form-div">
                <form action="registration.php" method="post">
                    <h3 class="text-center"><?php echo $title;?></h3>
                    
                    <?php if(count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="usertype">User type</label>
                        <select name="usertype">
                            <option value=""></option>
                            <option value="Administrator"> Administrator </option>
                            <option value="Herbalist"> Herbalist </option>
                            <option value="RegularUser"> Regular User </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label for="passwordConf">Confirm Password</label>
                        <input type="password" name="passwordConf" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control form-control-lg">
                    </div>
                    <div>
                        <button type="submit" name="register-btn" class="btn btn-primary btn-block btn-lg"><?php echo $button;?></button>
                    </div>
                    <p class="text-center" <?php echo $hide;?>>Already a member?<a href="login.php" <?php echo $hide;?>>Login here</a></p>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>
