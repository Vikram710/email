<html>
    <head><link href="style.css" rel="stylesheet"> </head>
    <body>
    <?php
        include 'dashboard.php';
        require 'includes/spam.inc.php';
    ?>

<?php   
    $username=$_SESSION['username'];
     $status="accept";
     $query="SELECT * FROM friends WHERE status=? AND (sender=? OR receiver=?)";
     $stmt=mysqli_prepare($conn,$query);
     mysqli_stmt_bind_param($stmt,"sss",$status,$username,$username);
     mysqli_stmt_execute($stmt);
     $result=mysqli_stmt_get_result($stmt);
     $c=0;
     while($record=mysqli_fetch_assoc($result)){
        if($record['sender']==$username){
             $friends[$c]=$record['receiver'];
        }
        else{
             $friends[$c]=$record['sender'];
        }
        $c++;
    }
    
    require 'includes/dbh.inc.php';
    if($_SESSION['username']){
        $user=$_SESSION['username'];

        $query="SELECT * FROM mail WHERE to_user=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">Primary mails</div>';
        echo'<form action="openmsg.php" method="POST">';
        while($record=mysqli_fetch_assoc($result)){
            date_default_timezone_set("Asia/Kolkata");
            $date=date("Y-m-d H:i:s");
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(0);
            $date = date("Y-m-d H:i:s", $futureDate);

            $time=strtotime($record["sent_time"]);
            $time=date("d F Y H:i", $time);
            
            if(in_array($record['from_user'],$friends)&& isspam($record['message'])=='spam' && $record['deletemail']!=1){
                if($date<$record['mail_expire'] || $record['mail_expire']=="0000-00-00 00:00:00" || $record['mail_expire']=="1970-01-01 01:00:00")
            echo'<button type="submit" name="id" value='.$record["id"].'>From: '.$record["from_user"].' Subject: '.$record["subject"].' <span>'.$time.'</span></button><br>';
                
            }

        }

        echo'</form></div>';

        
        $query="SELECT * FROM mail WHERE to_user=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">Secondary mails</div>';
        echo'<form action="openmsg.php" method="POST">';
        while($record=mysqli_fetch_assoc($result)){
            date_default_timezone_set("Asia/Kolkata");
            $date=date("Y-m-d H:i:s");
            $currentDate = strtotime($date);
            $futureDate = $currentDate+(0);
            $date = date("Y-m-d H:i:s", $futureDate);

            $time=strtotime($record["sent_time"]);
            $time=date("d F Y H:i", $time);
            
            if(!in_array($record['from_user'],$friends)&& isspam($record['message'])=='spam' && $record['deletemail']!=1){
                if($date<$record['mail_expire'] || $record['mail_expire']=="0000-00-00 00:00:00" || $record['mail_expire']=="1970-01-01 01:00:00")
            echo'<button type="submit" name="id" value='.$record["id"].'>From: '.$record["from_user"].' Subject: '.$record["subject"].' <span>'.$time.'</span></button><br>';
                
            }

        }

        echo'</form></div>';


    }
    else{
        header("Location:index.php");
        exit();
    }

    ?>
    </body>
    </html>