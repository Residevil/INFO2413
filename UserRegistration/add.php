<?php 
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);
require_once 'Controllers/authController.php';
require_once 'Controllers/SearchEngine.php';
require_once 'config/db.php';




if(isset($_POST['addherb-btn'])) {
    $herb_name = $_POST['herb_name'];
    $symptoms = $_POST['symptoms'];
    $medicinal_uses = $_POST['medicinal_uses'];
    $botanical_description = $_POST['botanical_description'];
    $sample_formula = $_POST['sample_formula'];
    // Get name of images
    $Get_image_name = $_FILES['image']['name'];
  	
    // image Path
    $image_Path = "images/".basename($Get_image_name);


//Search herbs table to check if the input herb name is new or not
    $query = "SELECT * FROM herbs WHERE herb_name = '". $herb_name ."' LIMIT 1";
    $result = $conn->query($query) or die($conn->error);
    $count = $result->num_rows;
    // if cannot find the input herb name in the herbs table
    // that means its a new herb, so add it into the herbs table
    if($count == 0) {
        $addHerb = "INSERT INTO herbs (herb_name, symptoms, medicinal_uses, image , botanical_description, sample_formula)
                    VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($addHerb) or die($conn->error);
        $stmt->bind_param('ssssss', $herb_name, $symptoms, $medicinal_uses, $Get_image_name, $botanical_description, $sample_formula);

        $stmt->execute();
        move_uploaded_file($_FILES['image']['tmp_name'], $image_Path);
        
        $herb_id = $conn->insert_id;
        $stmt->close();
        $result->close();

        //flash message
        $_SESSION['message'] = "Herb is successfully added.";
        $_SESSION['alert-class'] = "alert-success";        
        header('location: index.php');
        exit();
    } else {
        $errors['herb'] = "Herb name already exists.";
        $result->close();
    }

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
            <form action="add.php" method="post" enctype="multipart/form-data">
                <h3 class="text-center">Add Herb</h3>
                
                <?php if(count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="HerbName">Herb Name: </label>
                    <input type="text" name="herb_name" value="<?php echo $herb_name; ?>" class="form-control form-control-lg" required>
                </div>

                <div class="form-group">
                    <label for="symptoms">Symptoms: </label>
                    <textarea name="symptoms" row="10" cols="30" value="<?php echo $symptoms; ?>" class="form-control form-control-lg" required></textarea>
                </div>

                <div class="form-group">
                    <label for="medicinal_uses">Medicinal Uses: </label>
                    <textarea name="medicinal_uses" row="10" cols="30"  value="<?php echo $medicinal_uses; ?>" class="form-control form-control-lg" required></textarea>
                </div>

                <div class="form-group">
                    <label for="botanical_description">Botanical Description: </label>
                    <textarea name="botanical_description" row="10" cols="30"  value="<?php echo $botanical_description; ?>" class="form-control form-control-lg" required></textarea>
                </div>

                <div class="form-group">
                    <label for="sample_formula">Sample Formula: </label>
                    <textarea name="sample_formula" row="10" cols="30" value="<?php echo $sample_formula; ?>" class="form-control form-control-lg" required></textarea>
                </div>

				<div class=form-group>
                    <label for="image">Image: </label>
                    <input type="file" name="image">
                </div>

                <div>
                    <button type="submit" name="addherb-btn" class="btn btn-primary btn-lg">Add Herb</button>
                    <button type="submit" onclick="history.back()" class="btn btn-primary btn-lg">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
