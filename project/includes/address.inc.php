<?php
    require 'dbh.inc.php';
    session_start();
    if(isset($_POST['submit'])){
        $first=$_POST['first'];
        $last=$_POST['last'];
        $username=$_POST['username'];
        $email=$_POST['email'];
        $phno=$_POST['phone'];
        $dob=$_POST['dob'];
        $type=$_POST['radio'];
        $owner=$_SESSION['username'];

        $query="INSERT INTO addressbook(owner,first,last,username,email,phno,dob,type) VALUES(?,?,?,?,?,?,?,?) ";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ssssssss",$owner,$first,$last,$username,$email,$phno,$dob,$type);
        mysqli_stmt_execute($stmt);

        echo $phno;
        header("Location:../address.php");
        exit();

    }
    //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