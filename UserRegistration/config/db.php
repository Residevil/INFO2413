<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'constants.php'; //use to contain sensitive data
        

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ('Database error: ' . $conn->connect_error);

// sql to create table
$users = "CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR20) NOT NULL , 
    email VARCHAR(50) NOT NULL UNIQUE, 
    verified TINYINT(255) NOT NULL, 
    token VARCHAR(100) NOT NULL, 
    password VARCHAR(100) NOT NULL,
    usertype_id INT(11) NOT NULL FOREIGN KEY REFERENCE employee_type (id)
)";

$user_type = "CREATE TABLE user_type (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
    usertype VARCHAT(50) NOT NULL
)";

$herbs = "CREATE TABLE herbs (
    herb_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    herb_name INT(20) NOT NULL ,
    Image BIN(10) NOT NULL, 
    herb_description VARCHAT(100) NOT NULL,
    medical_use VARCHAR (255) NOT NULL,
    sample_formula VARCHAR (100) NOT NULL
)";







if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

?>