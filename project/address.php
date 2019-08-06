<html>
    <head>
        <link href="style.css"rel="stylesheet">
    </head>
    <body>
        <?php
            include_once("dashboard.php");
        ?>
        <div class="main"><div class="bar">Details</div>
        <form action="includes/address.inc.php" method="POST">
            <input type="text" name="first" placeholder="Enter first name" required>
            <input type="text" name="last" placeholder="Enter last name"required>
            <input type="text" name="username" placeholder="Enter username"required>
            <input type="text" name="email" placeholder="Enter email id"required>
            <input type="number" name="phone" placeholder="Enter phone number"required>
            <input type="date" name="dob"required>
            <input type="radio" name="radio" value="business"required><label>Business</label>
            <input type="radio" name="radio" value="personal"required><label>Personal</label>
            <input type="submit" name="submit" value="Submit" style="margin-left:180px">
        </form>
        </div>
        <?php
            require 'includes/dbh.inc.php';
            $owner=$_SESSION['username'];
            $query="SELECT * FROM addressbook WHERE owner=?";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"s",$owner);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            echo'personal<br>';
            while($record=mysqli_fetch_assoc($result)){
                
                if($record['type']=="personal"){
                echo'<div>';
                echo $record['first'].'<br>';
                echo $record['last'].'<br>';
                echo $record['username'].'<br>';
                echo $record['email'].'<br>';
                echo $record['phno'].'<br>';
                $dat = strtotime($record['dob']);
                $dob = date("d-m-Y", $dat);
                echo $dob.'<br>';
                echo'</div>';
                }
            }
            
            echo'business<br>';
            $query="SELECT * FROM addressbook WHERE owner=?";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"s",$owner);
            mysqli_stmt_execute($stmt); 
            $result=mysqli_stmt_get_result($stmt);
            while($record=mysqli_fetch_assoc($result)){
                
                if($record['type']=="business"){
                echo'<div>';
                echo $record['first'].'<br>';
                echo $record['last'].'<br>';
                echo $record['username'].'<br>';
                echo $record['email'].'<br>';
                echo $record['phno'].'<br>';
                $dat = strtotime($record['dob']);
                $dob = date("d-m-Y", $dat);
                echo $dob.'<br>';
                echo'</div>';
                }
            }
        ?>
            

    </body>
</html>