<html>
<head><link href="photo.css" rel="stylesheet"> </head>
    <body >
<?php
    include 'dashboard.php';
    ?>
   
    <form action="includes/gphotos.inc.php" method="POST" enctype='multipart/form-data'>
        <input type="file" name="file">
        <input type="submit" name="upload" value="upload" >
    </form>

<?php
        $user=$_SESSION['username']; 
        $query="SELECT * FROM photos  WHERE owner=? ORDER BY date DESC";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"s",$user);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $temp=9999-99-99;
        
        while($record=mysqli_fetch_assoc($result)){
            $time=strtotime($record["date"]);
            $time=date("d F Y ", $time);
            if($record['date']<$temp){
               
                echo'</div><div class="s">';
                echo $time.'<br>';
                $temp=$record['date'];
            }
            echo'<div class="img"><a href="gphotos/photo_'.$record['token'].'" download>
            <img src="gphotos/photo_'.$record['token'].'"></a></div>';

        }

        ?>
   

<script src="button.js"></script>
</body>
</html>