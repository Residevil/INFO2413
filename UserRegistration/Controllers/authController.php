<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

require_once 'config/db.php';


//if user clicks on the register button

if (isset($_POST['register-btn'])) {
    $usertype = $_POST['usertype'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    
    
    //validation
    
    if(empty($usertype)) {
        $errors['usertype'] = "Usertype required";
    }

    $sql = "SELECT * FROM user_type WHERE usertype = '".$usertype."'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) {
        $usertype_id = $row['id'];
    }

    if(empty($username)) {
        $errors['username'] = "Username required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }

    if(empty($email)) {
        $errors['email'] = "Email required";
    }

    if(empty($password)) {
        $errors['password'] = "Password required";
    }

    if($password != $passwordConf) {
        $errors['password'] = "Two password do not match";
    }

    //unique email validation
    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    
    if($userCount > 0) {
        $errors['email'] = "Email already exists";
    }
    
    if(count($errors) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password, usertype_id)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $username, $email, $password, $usertype_id);
        
        if($stmt->execute()) {

            //adminstrator adding new user
            if(isset($_SESSION['id'])) {
                //flash message
                $_SESSION['message'] = "New user is added successful";
                $_SESSION['alert-class'] = "alert-success";
                $ShowIndex="";
                header('location: index.php');
                exit();           
            }
            else {
                //login user
                $user_id = $conn->insert_id;
                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['usertype'] = $usertype;
                $_SESSION['usertype_id'] = $usertype_id;


                
                //flash message
                $_SESSION['message'] = "Login successful";
                $_SESSION['alert-class'] = "alert-success";
                header('location: index.php');
                exit();   
            }        
        } else {
            $errors['db_error'] = "Database error: failed to register";
        }
        
    }

}

//if user clicks the login button

if (isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //validation
    if(empty($username)) {
        $errors['username'] = "Username required"; 
    }

    if(empty($password)) {
        $errors['password'] = "Password required";
    }

    if(count($errors) === 0) {
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_array();

        if(password_verify($password, $user['password'])) {
            // correct password, allow login
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['usertype_id'] = $user['usertype_id'];
            //flash message
            $_SESSION['message'] = "Login successful";
            $_SESSION['alert-class'] = "alert-success";
            header('location: index.php');
            exit();        
        } else {
            $errors['login_fail'] = "Wrong credentials";
        }        
    }
    
}

//logout user
if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['usertype']);    
    unset($_SESSION['usertype_id']); 
    header('location: login.php');
    exit(0);
}
