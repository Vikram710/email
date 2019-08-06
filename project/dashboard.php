<?php
session_start();
?>

<html>
    <head>
        <title>php</title>
        <link href="dashboard.css" rel="stylesheet">
        <script src="index.js"></script>
        <script src="note.js"></script>
    </head>
    <body onload="changetheme()" ><?php
    echo'<input id="user" value="'.$_SESSION['username'].'"hidden>';
    ?>
        <nav id="nav">
            <div class="logo">Gmail</div>
            <div class="home"><a href="home.php">Home</a></div>
            <div class="home"><a href="news.php">News</a></div>
            <div class="home"><a href="address.php">Address book</a></div>
            <div class="home"><a href="gphotos.php">Photos</a></div>
            <div class="note" onclick="opennote()">Notifications</div>
            
            
            <div class="profile" id="profile" onclick="openNav()"> 
        <?php
        
            require 'includes/dbh.inc.php';
            $username=$_SESSION['username'];
            echo '<span class="hey"> '.$username.'</span>';
            $query="SELECT * FROM users WHERE username=?";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);

            $record=mysqli_fetch_assoc($result);            
            if($record['profileimg']==1){
            echo'<img src="uploads/profile_'.$username.'.jpg" class="p">';} 
            else{
                echo'<img src="uploads/profilestd.jpg" class="p">';
            }
        ?>
            <br>
            
            <div class="drop" id="drop"> 
            <a href="profile.php" class="pwd">My profile</a>
            <a href="changepwd.php" class="pwd">Change password</a>    
            <form action="includes/logout.inc.php" method="post">
            <button type="submit" name="logout" class="logout" >Log out</button>
            </form>
            </div>

        </div>

        </nav><br><br><br><br><br>
 
    <div class="side">
        <a href="composemail.php">Compose</a>
        <a href="inbox.php">Inbox</a>

        <a href="starred.php">Starred</a>
        <a href="sent.php">Sent</a>
        <a href="spam.php">Spam</a>
        <a href="trash.php">Trash</a>
        <a href="friends.php">Friends</a>
        <?php
         require 'includes/dbh.inc.php';
         $receiver=$_SESSION['username'];
         $query='SELECT * FROM friends WHERE receiver=?';
         $stmt=mysqli_prepare($conn,$query);
         mysqli_stmt_bind_param($stmt,"s",$receiver);
         mysqli_stmt_execute($stmt);
         $result=mysqli_stmt_get_result($stmt);
         $e=0;
         while($record=mysqli_fetch_assoc($result)){
             if($record['status']=="requested"){
                 $e++;
             
        }
    
    }
    echo '<div class="vik">'.$e.'</div>';
   
    ?>
    
    </div>
    
    <div class="opennote" id="opennote">
            
    </div>
    <script src="index.js"></script>
    </body>
</html>


