<html>
<head>
    <title>Document</title>
    <link href="style.css" rel="stylesheet">

</head>
<body>
<?php
        include 'dashboard.php';
    ?>

    <form action="friends.php" method="POST">
        <input type="username" name="username" placeholder="search username">
        <input type="submit" name="search" value="Search">
    </form>
    <?php
        if(isset($_POST['search'])){
            require 'includes/dbh.inc.php';
            $username=$_POST['username'];
            $query="SELECT * from users WHERE username=?";
            $stmt=mysqli_prepare($conn,$query);
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck=mysqli_stmt_num_rows($stmt);
            if($resultcheck >0){
                $query="SELECT * from users WHERE username=?";
                $stmt=mysqli_prepare($conn,$query);
                mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                echo'<div class="main"><div class="bar">Search results</div>';
                while($record=mysqli_fetch_assoc($result)){
                    
                    echo '<form action="includes/friends.inc.php" method="POST">';
                    echo$record['username'];
                    echo'<input type="username" value='.$record['username'].' name="username" hidden>';
                    echo '<input type="submit" value="Add friend" name="add">';
                    echo '</form>';
                    
                }
            }
            echo'</div>';

        }
    ?>
    <?php
        require 'includes/dbh.inc.php';
        $receiver=$_SESSION['username'];
        $query='SELECT * FROM friends WHERE receiver=?';
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"s",$receiver);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">New friend requests</div>';
        $e=0;
        while($record=mysqli_fetch_assoc($result)){
            if($record['status']=="requested"){
                $e++;
            echo '<form action="includes/friends.inc.php" method="POST">';
            echo $record['sender'];
            echo'<input type="username" value='.$record['sender'].' name="sender" hidden>';
            echo '<input type="submit" value="Accept as friend" name="accept">';
            echo '<input type="submit" value="Decline" name="decline">';
            echo '</form><br> ';
            }
        }
        if($e==0){
            echo'No new friend requests';
        }
        echo'</div>';

    ?>

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

        
    <?php
        $sender=$_SESSION['username'];
        $query='SELECT * FROM friends WHERE sender=?';
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"s",$sender);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        echo'<div class="main"><div class="bar">Requests yet to be accepted</div>';
        $x=0;
        while($record=mysqli_fetch_assoc($result)){
            if($record['status']=="requested"){
            $x++;
            echo '<form action="includes/friends.inc.php" method="POST">';
            echo$record['receiver'];
            echo'<input type="username" value='.$record['receiver'].' name="receiver" hidden>';
            echo '<input type="submit" value="Cancel request" name="cancel">';
            echo '</form><br>';
            }
        
        }
        if($x==0){
            echo'No pending requests';
        }
        echo '</div>';
        
    ?>
</body>
</html>




