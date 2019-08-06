<html>
    <head>
        <link href="openmsg.css"  rel="stylesheet">
    </head>
    <body>
    <?php   
    require 'includes/dbh.inc.php';
    include 'dashboard.php';


    if(isset($_POST['star'])){  
        $username=$_SESSION['username'];
        $id=$_POST['id'];
        $star=(int)1;
        $query="UPDATE mail SET star=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$star,$id);
        mysqli_stmt_execute($stmt);
        echo'starred';
        header("Location:inbox.php");
        exit();
    }

    if(isset($_POST['unstar'])){  
        $username=$_SESSION['username'];
        $id=$_POST['id'];
        $star=(int)0;
        $query="UPDATE mail SET star=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$star,$id);
        mysqli_stmt_execute($stmt);
        echo'unstarred';
        header("Location:inbox.php");
        exit();
    }

    if(isset($_POST['reply'])){     
        $to=$_POST['repto'];
        header("Location:composemail.php?repto=".$to);
        exit();

    }
    if(isset($_POST['forward'])){  
        $username=$_SESSION['username'];
        $id=$_POST['id'];
        $query="UPDATE mail SET deletemail=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$delete,$id);
        mysqli_stmt_execute($stmt);
         $query="SELECT * FROM mail WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$id);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while($record=mysqli_fetch_assoc($result)){
            $to=$_POST['fto'];
            $from=$_SESSION['username'];
            $subject=$record['subject'];
            $message=$record['message'];
            $color=$record['color'];
            $date=date("Y-m-d h:i:s");
            echo $date;
            $note="unread";
    
            $query="INSERT INTO mail(subject,to_user,from_user,message,sent_time,color,notification) VALUES(?,?,?,?,?,?,?) ";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"sssssss",$subject,$to,$from,$message,$date,$color,$note);
            mysqli_stmt_execute($stmt);
            header("Location:sent.php");
            exit();
        }
 
    }

    if(isset($_POST['delete'])){  
        $username=$_SESSION['username'];
        $id=$_POST['id'];
        $delete=(int)1;
        $query="UPDATE mail SET deletemail=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$delete,$id);
        mysqli_stmt_execute($stmt);
        header("Location:inbox.php");
        exit();
    }
    if(isset($_POST['restore'])){  
        $username=$_SESSION['username'];
        $id=$_POST['id'];
        $delete=(int)0;
        $query="UPDATE mail SET deletemail=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"dd",$delete,$id);
        mysqli_stmt_execute($stmt);
        header("Location:inbox.php");
        exit();
    }

    if(isset($_SESSION['username'])){
        $user=$_SESSION['username'];
        $id=$_POST['id'];
        $note='read';
        

        $query="SELECT * FROM mail WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$id);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while($record=mysqli_fetch_assoc($result)){
        if($record['to_user']==$user){
                
        $query="UPDATE mail SET notification=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt,"sd",$note,$id);
        mysqli_stmt_execute($stmt);
            }
            echo'<div class="main">';
            echo'<p>From: '.$record["from_user"].'</p> 
            <p>To: '.$record["to_user"].'</p>
            <p>Subject: '.$record["subject"].' </p>
            <p><span style="color:'.$record['color'].'">Message: '.$record['message'].'</span> </p>
            <p>Time: '.$record['sent_time'].'</p>';


            $temp_del= $record['deletemail'];
            $temp_to=$record['to_user'];
            $temp_msg=$record['message'];
            $temp_sub=$record['subject'];
            $temp_from=$record['from_user'];
        }
        

        if($temp_del==1 && $temp_to==$user){
            echo'<form action="openmsg.php" method="POST">';
            echo'<input type="submit" name="restore" value="Restore message">';
            echo'<input type="number" name="id" value='.$id.' hidden>';
            echo '</form>';
        }
        else{
        echo'<form action="openmsg.php" method="POST">';
        echo'<input type="submit" name="star" value="Mark as important">';
        echo'<input type="submit" name="unstar" value="Mark as not important">';
        echo'<input type="submit" name="delete" value="Delete message">';
        echo'<input type="text" name="repto" hidden value="'.$temp_from.'">'; 
        echo'<input type="submit" name="reply" value="Reply">';
        echo'<input type="text" name="fto" placeholder="Forward to">'; 
        echo'<input type="submit" name="forward" value="Forward message">';
        echo'<input type="number" name="id" value='.$id.' hidden>'; 
        echo'</form>';
        echo '</div>';
    }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else{
        header("Location:index.php");
        exit();
    }?>
    </body>
    </htmL>