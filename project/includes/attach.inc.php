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
if(isset($_POST['attach'])){
    $date=date("Y-m-d h:i:s");
    $currentDate = strtotime($date);
    $futureDate = $currentDate+(12600);
    $date = date("Y-m-d H:i:s", $futureDate);
    session_start();
    $token=token(10);
    $to=$_POST['to'];
    $sub=$_POST['subject'];
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
        $fileNameNew = "doc_".$token.".".$fileActualExt;
        $fileDestination = '../uploads/'.$fileNameNew;
        move_uploaded_file($_FILES['file']['tmp_name'],$fileDestination);
        $token=$token.".".$fileActualExt;

        $query="INSERT INTO attach(to_user,from_user,name,subject,sent_time) VALUES(?,?,?,?,?) ";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt,"sssss",$to,$username,$token,$sub,$date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);



        header("Location:../composemail.php");
        exit();
        }
        else{
            echo "You have an error uploading your file!";
        }
    }