<?php 
require_once 'Controllers/authController.php';
require_once 'Controllers/SearchEngine.php';
require_once 'config/db.php';


if(isset($_POST['editherb-btn'])) {
    $herb_id = $_SESSION['herb_id'];
    $herb_name = $_POST['herb_name'];
    $symptoms = $_POST['symptoms'];
    $medicinal_uses = $_POST['medicinal_uses'];
    $botanical_description = $_POST['botanical_description'];
    $sample_formula = $_POST['sample_formula'];
    $image = $_POST['image'];

	  
  	// Get name of images
  	$Get_image_name = $_FILES['image']['name'];
  	
  	// image Path
  	$image_Path = "images/".basename($Get_image_name);

    //Validation
    if(empty($herb_name)) {
        $errors['herb_name'] = "herb Name required";
    }
    if(empty($symptoms)) {
        $errors['symptoms'] = "symptoms required";
    }

    if(empty($medicinal_uses)) {
        $errors['medicinal_uses'] = "medical uses required";
    }

    if(empty($botanical_description)) {
        $errors['botanical_description'] = "botanical description required";
    }    

    if(empty($sample_formula)) {
        $errors['sample_formula'] = "sample formula required";
    }   

    $editHerb = "UPDATE herbs SET 
            herb_name=?,
            symptoms=?,      
            medicinal_uses=?,      
            image=?,
            botanical_description=?,
            sample_formula=?        
            WHERE herb_id = ?";
    $stmt = $conn->prepare($editHerb);
    $stmt->bind_param('ssssssi', $herb_name, $symptoms, $medicinal_uses, $Get_image_name, $botanical_description, $sample_formula, $herb_id);
    $stmt->execute();
    $_SESSION['message'] = "Herb is updated successfully.";
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
            <form action="edit.php" method="post" enctype="multipart/form-data">
                <h3 class="text-center">Edit ticket</h3>
                
                <?php if(count($errors) > 0) : ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="HerbName">Herb Name: </label>
                    <input name="herb_name"  value="<?php echo $_SESSION['herb_name']; ?>" class="form-control form-control-lg" required> </textarea>
                </div>

                <div class="form-group">
                    <label for="symptoms">Symptoms: </label>
                    <textarea name="symptoms" row="10" cols="30" class="form-control form-control-lg" required><?php echo $_SESSION['symptoms']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="medicinal_uses">Medicinal Uses: </label>
                    <textarea name="medicinal_uses" row="10" cols="30" class="form-control form-control-lg" required><?php echo $_SESSION['medicinal_uses']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="botanical_description">Botanical Description: </label>
                    <textarea name="botanical_description" row="10" cols="30"  class="form-control form-control-lg" required><?php echo $_SESSION['botanical_description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="sample_formula">Sample Formula: </label>
                    <textarea name="sample_formula" row="10" cols="30" class="form-control form-control-lg" required><?php echo $_SESSION['sample_formula']; ?></textarea>
                </div>

				<div class=form-group>
                    <label for="image">Image: </label>
					<input type="file" name="image">  	
				</div>

                <div>
                    <button type="submit" name="editherb-btn" class="btn btn-primary btn-lg">Edit Herb</button>
                    <button type="submit" onclick="history.back()" class="btn btn-primary btn-lg">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
