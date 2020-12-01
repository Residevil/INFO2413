<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'constants.php'; //use to contain sensitive data
        

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS) or die ('Database error: ' . $conn->connect_error);
$db_selected = $conn->select_db( DB_NAME );
if(!$db_selected) {
    $db = "CREATE DATABASE IF NOT EXISTS INFO 2413";
    $conn->query($db);

    $conn->select_db( DB_NAME );

    if ($conn->query($db) === TRUE) {
    // sql to create table.
        $user_type = "CREATE TABLE `user_type` (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
            usertype VARCHAR(50) NOT NULL
        )";
        $conn->query($user_type);
        $userInsert = "INSERT INTO user_type (usertype) VALUES('Administrator'), ('Herbalist'), ('RegularUser')";
        $conn->query($userInsert);
        
        $users = "CREATE TABLE `users` (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(20) NOT NULL , 
            email VARCHAR(50) NOT NULL UNIQUE, 
            password VARCHAR(100) NOT NULL,
            usertype_id INT(11) NOT NULL,
            FOREIGN KEY (usertype_id) REFERENCES user_type (id)
        )";
        $conn->query($users);

        $herbs = "CREATE TABLE `herbs` (
            herb_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            herb_name VARCHAR(50) NOT NULL ,
            symptoms VARCHAR(100) NOT NULL ,
            medicinal_uses VARCHAR(500) NOT NULL,
            image VARCHAR(50) NOT NULL,
            botanical_description VARCHAR(500) NOT NULL,
            sample_formula VARCHAR (500) NOT NULL
        )";
        $conn->query($herbs);
    }
    else { echo "Error creating table: " . $conn->error;}
}
?>
