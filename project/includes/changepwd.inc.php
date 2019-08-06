<?php
session_start();
    if(isset($_POST['submit'])){
        require 'dbh.inc.php';
        $username=$_SESSION['username'];
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm_password'];
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
         //password length
        if(strlen($password)<8){
            header("Location:../dashboard.php?error=smallpassword");
            exit();
        }
        //confirm passowrd
         else if($password!==$confirm_password){
            header("Location:../dashboard.php?error=nomatch");
            exit();
        }
        else{
        $query2="UPDATE users SET password=? WHERE username=?";
        $stmt2=mysqli_prepare($conn, $query2);

        mysqli_stmt_bind_param($stmt2,"ss",$hashed_password,$username);
        mysqli_stmt_execute($stmt2);
        header("Location:../home.php?result=changedpwd");
        exit();
        }
    }
    else{
        header("Location:../home.php?");
        exit();
    }
    