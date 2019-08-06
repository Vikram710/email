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

        $query="SELECT * FROM mail WHERE from_user=? ORDER BY sent_time DESC";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<form action="openmsg.php" method="POST">';
        echo'<div class="main"><div class="bar">Mails</div>';
        while($record=mysqli_fetch_assoc($result)){
            echo'<button type="submit" name="id" value='.$record["id"].'>To: '.$record["to_user"].' Subject: '.$record["subject"].'<span>'.$record['sent_time'].'</span></button><br>';
        }
        echo'<br></div></form>';
    }
    else{
        header("Location:index.php");
        exit();
    }?>



        <?php
        $user=$_SESSION['username'];
        $query="SELECT * FROM attach WHERE from_user=? ORDER BY sent_time DESC";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">Files</div>';
        while($record=mysqli_fetch_assoc($result)){
            $time=strtotime($record["sent_time"]);
            $time=date("d F Y H:i", $time);
        echo'<a href="uploads/doc_'.$record['name'].'" download><button>From: '.$record['to_user'].' Subject: '.$record['subject'].'<span>'.$time.'</span></button></a>';
        }
        echo'<br><br></div>';

        ?>
    </body>
    </html>