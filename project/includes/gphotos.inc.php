<?php
function token($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}
    echo 'a';
    session_start();
    if(isset($_SESSION['username']) && isset($_POST['upload'])){
        echo'hi';

        $date=date("Y-m-d");
        $currentDate = strtotime($date);
        $futureDate = $currentDate+(12600);
        $date = date("Y-m-d", $futureDate);
        $token=token(10);
        echo 'as';
       
        require 'dbh.inc.php';
        $username=$_SESSION['username'];
        $file= $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $filesError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];       
        $fileExt = explode('.',$_FILES['file']['name']);
        $fileActualExt = strtolower(end($fileExt));
        if($_FILES['file']['error'] ===  0){          
            $fileNameNew = "photo_".$token.".".$fileActualExt;
            $fileDestination = '../gphotos/'.$fileNameNew;
            move_uploaded_file($_FILES['file']['tmp_name'],$fileDestination);
            $token=$token.".".$fileActualExt;
    
            $query="INSERT INTO photos(owner,date,token) VALUES(?,?,?) ";
            $stmt=mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt,"sss",$username,$date,$token);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
    
            echo 'jii';
    
            header("Location:../gphotos.php");
            exit();
        }
            else{
                echo "You have an error uploading your file!";
            }
        } 
    