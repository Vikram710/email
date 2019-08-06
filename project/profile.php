<html>
<head>
    <link href="profile.css" rel="stylesheet">
</head>
<body>
    <?php
        include 'dashboard.php';
    ?>
<?php

    require 'includes/dbh.inc.php';

    if(isset($_POST['submit'])){
        $username=$_SESSION['username'];
        $file= $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $filesError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];       
        $fileExt = explode('.',$_FILES['file']['name']);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)){
            $fileActualExt="jpg";
            if($_FILES['file']['error'] ===  0){
                if($_FILES['file']['size'] < 1000000){            
                    $fileNameNew = "profile_".$username.".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($_FILES['file']['tmp_name'],$fileDestination);
                    
                    $num=1;
                    $query="UPDATE users SET profileimg=?  WHERE username=?";
                    $stmt=mysqli_prepare($conn,$query);
                    mysqli_stmt_bind_param($stmt,"ds",$num,$username);
                    mysqli_stmt_execute($stmt);
   

                    header("Location: profile.php?uploadsucess");
                }else{
                    echo "Your file is too big!";
                }
            }else{
                echo "You have an error uploading your file!";
            }
        }else{
            echo "You cannot upload files of this type!";
        }
    
    }
?>

    
        <?php
            require 'includes/dbh.inc.php';
            $username=$_SESSION['username'];
    
            $query="SELECT * FROM users WHERE username=?";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);

            $record=mysqli_fetch_assoc($result);            
            if($record['profileimg']==1){
            //fileexists????
            echo'<img src="uploads/profile_'.$username.'.jpg">';} 
            else{
                echo'<img src="uploads/profilestd.jpg">';
            }
        ?>
        <form action="profile.php" method="POST" enctype='multipart/form-data'>  
        <input type="file" name="file">
        <input type="submit" name="submit">

        <?php
        require 'includes/dbh.inc.php';
        $username=$_SESSION['username'];
        $status="accept";
        $query="SELECT * FROM friends WHERE status=? AND (sender=? OR receiver=?)";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"sss",$status,$username,$username);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $a=0;
        echo'<div class="main"><div class="bar">My friends</div>';
        while($record=mysqli_fetch_assoc($result)){
            echo '<form action="includes/friends.inc.php" method="POST">';
            if($record['sender']==$username){
                echo $record['receiver'];
                $a=1;
                echo'<input type="username" value='.$record['receiver'].' name="receiver" hidden>';
            }
            else{
                echo $record['sender'];
                $a=1;
                echo'<input type="username" value='.$record['sender'].' name="receiver" hidden>';
            }
           
            echo'<input type="submit" name="unfriend" value="Unfriend">';
            
            echo'</form>';
            echo'<br>';
        }
        if($a==0){
            echo'Time to make friends';
        }
        echo'</div>';
        ?>

        
    </form>
    
</body>
</html>