<?php
    if(isset($_POST['submit'])){
        require 'includes/dbh.inc.php';
        $email=$_POST['email'];
        $token=$_POST['token'];
        $password=$_POST["password"];
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
        $confirm_password=$_POST["confirm_password"];
        //password length
        if(strlen($password)<8){
            header("Location:reset.php?email=".$email."&token=".$token."&error=smallpassword");
            exit();
        }
        //confirm passowrd
         else if($password!==$confirm_password){
            header("Location:reset.php?email=".$email."&token=".$token."&error=nomatch");
            exit();
        }
        else{
        $query2="UPDATE users SET password=? WHERE email=?";
        $stmt2=mysqli_prepare($conn, $query2);

        mysqli_stmt_bind_param($stmt2,"ss",$hashed_password,$email);
        mysqli_stmt_execute($stmt2);
        header("Location:index.php?result=changedpwd");
        exit();
        }
    }
    else{
        header("Location:reset.php?email=".$email."&token=".$token."");
        exit();
    }

    if (isset($_GET['email']) && isset($_GET['token'])) {
        require 'includes/dbh.inc.php';
        $email=$_GET['email'];
        $token=$_GET['token'];
        $date=date("Y-m-d h:i:s");

    $query="SELECT * FROM users WHERE email=?";
    $stmt=mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt,"s",$email);
    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);
    if($row=mysqli_fetch_assoc($result)){
        if($date<$row['tokenexpire']){
            echo'
                <form action="reset.php" method="POST">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password">
                <label>Repeat password</label>
                <input type="password" name="confirm_password" id="rptpwd" placeholder="Repeat password" >
                <input type="text" name="email" value='.$email.' hidden >
                <input type="text" name="token" value='.$token.' hidden>
                <input type="submit" name="submit" value="Submit">
                </form>';

        }
        else{
            echo'Time limit exceeded .Sorry your request cannot processed. Please try again';
        }


    }
}
else{
    echo'Not enough data to process please follow the instructions.';
}