<?php

require_once 'config/db.php';



if(isset($_POST['search-btn'])) {
    $search = $_POST['search'];
    //$search = preg_replace("#[^0-9a-z\s]#i","",$search);

    $words = explode(' ', $search);
    $regex = implode('|', $words);

    $query = "SELECT * FROM herbs WHERE herb_name = '". $search ."'";
    $result = $conn->query($query) or die($conn->error);
    $count = $result->num_rows;
    if($count == 0 || empty($search)){
        $output = 'There are zero results';
    } else{
        $table='';
        $hidden = '';
        while($row = $result->fetch_array()) {
            $_SESSION['herb_id'] = $row['herb_id'];
            $_SESSION['herb_name'] = $row['herb_name'];
            $_SESSION['symptoms'] = $row['symptoms'];
            $_SESSION['medical_use'] = $row['medical_use'];
            $_SESSION['herb_description'] = $row['herb_description'];
            $_SESSION['sample_formula'] = $row['sample_formula'];	
            $_SESSION['image_name'] = "<img src='images/".$row['image_name']."' width=480 height=270 >"; 
        }
    }
}

