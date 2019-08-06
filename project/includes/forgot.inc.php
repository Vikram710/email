<?php
    function token($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    } 

    if(isset($_POST['submit'])){
    require 'dbh.inc.php';

    $email=$_POST['email'];
    $token=token(15);
    $date=date("Y-m-d h:i:s");
    $currentDate = strtotime($date);
    $futureDate = $currentDate+(60*5);
    $tokenexpire = date("Y-m-d H:i:s", $futureDate);

    $query1="SELECT username FROM users WHERE email=?";
    $stmt1=mysqli_prepare($conn, $query1);

    mysqli_stmt_bind_param($stmt1,"s",$email);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_store_result($stmt1);
    $resultcheck=mysqli_stmt_num_rows($stmt1);
    if($resultcheck >0){
        $query2="UPDATE users SET token=?,tokenexpire=? WHERE email=?";
        $stmt2=mysqli_prepare($conn, $query2);

        mysqli_stmt_bind_param($stmt2,"sss",$token,$tokenexpire,$email);
        mysqli_stmt_execute($stmt2);
    }

        $to      = $email;
        $subject = 'password recovery';
        
        $url="http://localhost/project/reset.php?email=".$email."&token=".$token."";

        $message = '<h1>Hi,to reset yout password please click the link below:<h1><br>';
        $message .= '<h3>'.$url.'</h3><p>The link expires within 5 minutes of creation please complete the process before 5 minutes.';
        $message .= '<p>If you did not request for password recovery please ignore this.</p>';


        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: vikramthebest1@gmail.com' . "\r\n" .
            'Reply-To: customercare@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        $test=mail($to, $subject, $message, $headers);
        if($test){
            echo'Sucess,please login to your email account and click the link given to continue with the process.';
        };
    }
    else{
        header("Location:../forgot.php");
        exit();
    }
