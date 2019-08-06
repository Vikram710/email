<?php
    session_start();
    require 'dbh.inc.php';
    if(isset($_POST['add'] )&& isset($_SESSION['username'])){
        
        $sender=$_SESSION['username'];
        $receiver=$_POST['username'];
        $status="requested";

        $query="SELECT * FROM friends WHERE sender=? AND receiver=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ss",$sender,$receiver);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultcheck=mysqli_stmt_num_rows($stmt);

        $query1="SELECT * FROM friends WHERE sender=? AND receiver=?";
        $stmt1=mysqli_prepare($conn,$query1);
        mysqli_stmt_bind_param($stmt1,"ss",$receiver,$sender);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_store_result($stmt1);
        $resultcheck1=mysqli_stmt_num_rows($stmt1);

        if($resultcheck >0){
            echo'Already sent';
            
        }
        else if($receiver==$sender){
            echo'Cannot send request to yourself';
        }
        
        else if ($resultcheck1>0) {
            echo'Already sent';
        }
        else{
        $query="INSERT INTO friends(sender,receiver,status) VALUES(?,?,?)";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"sss",$sender,$receiver,$status);
        mysqli_stmt_execute($stmt);
        }
    }

    if(isset($_POST['accept'] )&& isset($_SESSION['username'])){
        $receiver=$_SESSION['username'];
        $sender=$_POST['sender'];
        $status="accept";
        echo $sender.$receiver.$status;
        $query="UPDATE friends SET status =? WHERE sender=? AND receiver=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"sss",$status,$sender,$receiver);
        mysqli_stmt_execute($stmt);
    }
    if(isset($_POST['cancel'] )&& isset($_SESSION['username'])){
        $sender=$_SESSION['username'];
        $receiver=$_POST['receiver'];
        $query="DELETE from friends WHERE sender=? AND receiver=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ss",$sender,$receiver);
        mysqli_stmt_execute($stmt);
        

    }
    if(isset($_POST['decline'] )&& isset($_SESSION['username'])){
        $receiver=$_SESSION['username'];
        $sender=$_POST['sender'];
        $query="DELETE from friends WHERE sender=? AND receiver=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ss",$sender,$receiver);
        mysqli_stmt_execute($stmt);
        

    }
    if(isset($_POST['unfriend'] )&& isset($_SESSION['username'])){
        $sender=$_SESSION['username'];
        $receiver=$_POST['receiver'];
        if($receiver!='admin'){
        $query="DELETE from friends WHERE (sender=? AND receiver=?) OR (sender=? AND receiver=?)";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ssss",$sender,$receiver,$receiver,$sender);
        mysqli_stmt_execute($stmt);
        }

    }