<?php

require_once 'config/db.php';



if(isset($_POST['search-btn'])) {
    $search = $_POST['search'];
    $search = preg_replace("#[^0-9a-z\s]#i","",$search);

    $words = explode(' ', $search);
    $regex = implode('|', $words);

    $query = "SELECT * FROM herbs WHERE herb_name REGEXP '{$regex}' OR symptoms REGEXP '{$regex}' OR medicinal_uses REGEXP '{$regex}' OR botanical_description  REGEXP '{$regex}' OR sample_formula REGEXP '{$regex}'";
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
            $_SESSION['medicinal_uses'] = $row['medicinal_uses'];
            $_SESSION['botanical_description'] = $row['botanical_description'];
            $_SESSION['sample_formula'] = $row['sample_formula'];	
            $_SESSION['image'] = "<img src='images/".$row['image']."' width=480 height=270 >"; 
        }
    }
}

if(isset($_POST['user-btn'])) {
    $search = $_POST['search'];

    $query = "SELECT * FROM users WHERE username='".$search."' OR email='".$search."' ";
    $result = $conn->query($query) or die($conn->error);
    $count = $result->num_rows;
    if($count == 0 || empty($search)){
        $output = 'There are zero results';
    } else{
        $table='';
        $hidden = '';
        while($row = $result->fetch_array()) {
            $_SESSION['edit_id'] = $row['id'];
            $_SESSION['edit_username'] = $row['username']; 
            $_SESSION['edit_email'] = $row['email'];
            $_SESSION['edit_usertype_id'] = $row['usertype_id'];
        }
        $sql = "SELECT * FROM user_type WHERE id ='".$usertype_id."'";
        $result = $conn->query($sql);
        while ($row = $result->fetch_array()) {
            $_SESSION['edit_usertype'] = $row['usertype'];
        }
    }
}
