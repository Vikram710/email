<?php
    session_start();

    if(isset($_POST['send'])){
        if(isset($_POST['time'])){
            $expire=$_POST['time'];
            $dat = strtotime($expire);
            $expire = date("Y-m-d H:i:s", $dat);
            $color=$_POST['color'];
            echo $color;
    
            require 'dbh.inc.php';
            $to=$_POST['to'];
            $subject=$_POST['subject'];
            $message=$_POST['message'];
            $from=$_SESSION['username'];
            date_default_timezone_set("Asia/Kolkata");
            $date=date("Y-m-d h:i:s");
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(0);
            $date = date("Y-m-d H:i:s", $futureDate);
            echo $date;
            $note="unread";
            $query="INSERT INTO mail(subject,to_user,from_user,message,sent_time,mail_expire,color,notification) VALUES(?,?,?,?,?,?,?,?) ";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"ssssssss",$subject,$to,$from,$message,$date,$expire,$color,$note);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location:../sent.php");
            exit();
        }
        else{
        require 'dbh.inc.php';
        $to=$_POST['to'];
        $subject=$_POST['subject'];
        $message=$_POST['message'];
        $from=$_SESSION['username'];
        $color=$_POST['color'];
        $date=date("Y-m-d h:i:s");
        echo $date;
        $note="unread";

        $query="INSERT INTO mail(subject,to_user,from_user,message,sent_time,color,notification) VALUES(?,?,?,?,?,?,?) ";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"sssssss",$subject,$to,$from,$message,$date,$color,$note);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location:../sent.php");
        exit();

    }}
    else{
        header("Location:../home.php");
        exit();
    }