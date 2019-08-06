<html>
<head><link href="style.css" rel="stylesheet"> </head>
    <body>
    <?php
        include 'dashboard.php';
    ?>
    <?php   
    
    require 'includes/dbh.inc.php';
    if($_SESSION['username']){

        $user=$_SESSION['username'];

        $query="SELECT * FROM mail WHERE to_user=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">Mails</div>';
        echo'<form action="openmsg.php" method="POST">';
        while($record=mysqli_fetch_assoc($result)){
            if($record['star']==1){
            echo'<button type="submit" name="id" value='.$record["id"].'>To: '.$record["to_user"].' Subject: '.$record["subject"].'</button><br>';
            }
        }
        echo'</div></form>';
    }
    else{
        header("Location:index.php");
        exit();
    }?>


    </body>
    </html>