<?php   
    session_start();
    require 'dbh.inc.php';
    if(isset($_POST['star'])){  
        $username=$_SESSION['username'];
        $star=(int)1;
        $query="UPDATE mail SET star=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$star,$id);
        mysqli_stmt_execute($stmt);

    }?>