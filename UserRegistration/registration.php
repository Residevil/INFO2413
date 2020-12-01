<?php require_once 'Controllers/authController.php'; ?>
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
    <div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div">
            <form action="registration.php" method="post">
                <h3 class="text-center">Register</h3>
                
                <?php if(count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="usertype_id">User type</label>
                    <select name="usertype_id">
                        <option value=""></option>
                        <option value="1"> Administrator </option>
                        <option value="2"> Herbalist </option>
                        <option value="3"> Regular User </option>
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
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label for="passwordConf">Confirm Password</label>
                    <input type="password" name="passwordConf" class="form-control form-control-lg">
                </div>
                <div>
                    <button type="submit" name="register-btn" class="btn btn-primary btn-block btn-lg">Register</button>
                </div>
                <p class="text-center">Already a member?<a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
