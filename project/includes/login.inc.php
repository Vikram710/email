<?php

    if(isset($_POST["submit"])){
    require "dbh.inc.php";

    $username=$_POST["username"];
    $password=$_POST["password"];
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
    if($username_exists==1){


    $query="SELECT * FROM users WHERE username=?";
    $stmt=mysqli_stmt_init($query);
    $stmt=mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);

    if($row=mysqli_fetch_assoc($result)){
        $password_check=password_verify($password,$row["password"]);
        if($password_check==true){
            session_start();
            $_SESSION[userid]=$row["userid"];
            $_SESSION[username]=$row["username"];
            $_SESSION[email]=$row["email"];

            header("Location:../home.php?login=success");
            exit();
        }
        else {
            header("Location:../index.php?error=wrongpassword");
            exit();
        }
    }}
    else {
        header("Location:../index.php?error=wrongusername");
        exit();
    }


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
    
else{
    header("Location:../index.php");
    exit();
}

