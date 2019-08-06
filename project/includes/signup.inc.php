<?php

    if(isset($_POST["submit"])){
        require "dbh.inc.php";

        $username=$_POST["username"];
        $email=$_POST["email"];
        $password=$_POST["password"];
        $confirm_password=$_POST["confirm_password"];
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
        $username_exists=0;

        //error handlers

        //emty fields
        if(empty($username)||empty($email)|| empty($password)|| empty($confirm_password)){
            header("Location:../signup.php?error=emptyfields&username=".$username."&email=".$email);
            exit();
        }
        //not email
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header("Location:../signup.php?error=invalidemail&username=".$username."");
            exit();
        } 
        //username char
        else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
            header("Location:../signup.php?error=invalidusername&email=".$email."");
            exit();
        }
        //password length
        else if(strlen($password)<8){
            header("Location:../signup.php?error=smallpassowrd&username=".$username."&email=".$email);
            exit();
        }
        //confirm passowrd
         else if($password!==$confirm_password){
            header("Location:../signup.php?error=passwordnotmatch&username=".$username."&email=".$email);
            exit();
        }

        //username exists??
        $query1="SELECT username FROM users WHERE username=?";
        $stmt1=mysqli_prepare($conn, $query1);
    
        mysqli_stmt_bind_param($stmt1,"s",$username);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_store_result($stmt1);
        $resultcheck=mysqli_stmt_num_rows($stmt1);
        if($resultcheck >0){
             $username_exists=1;
        }
        mysqli_stmt_close($stmt1);

        if( $username_exists==1){
            header("Location:../signup.php?error=invalidusername&email=".$email."");
            exit();
        }
        else{
                    $query="INSERT INTO users(username,email,password) VALUES(?,?,?) ";
                    $stmt=mysqli_prepare($conn, $query);
        
                    mysqli_stmt_bind_param($stmt,"sss",$username,$email,$hashed_password);
                    mysqli_stmt_execute($stmt);


                    $receiver='admin';
                    $status='accept';
                    $query="INSERT INTO friends(sender,receiver,status) VALUES(?,?,?)";
                    $stmt=mysqli_prepare($conn,$query);
                    mysqli_stmt_bind_param($stmt,"sss",$username,$receiver,$status);
                    mysqli_stmt_execute($stmt);

                    header("Location:../index.php?result=".$resultcheck."");
        exit();

        }
    }

    else{
        header("Location:../signup.php");
        exit();
    }





  