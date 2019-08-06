<?php
    session_start();
    $user=$_REQUEST['username'];
    require 'includes/dbh.inc.php';
    
    $query="SELECT * FROM mail WHERE to_user=? ORDER BY sent_time DESC";
    $stmt=mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"s",$user);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);

    $json_response = array();
    $json= new stdClass();
    $c=0;
    while($record=mysqli_fetch_assoc($result)){
        if($record['notification']=="unread"){
            $c++;
            $time=strtotime($record["sent_time"]);
            $time=date("d F Y H:i", $time);       
            $row_array = array();
            $row_array['from']=$record['from_user'];
            $row_array['subject']=$record['subject'];
            $row_array['sent']=$time;

            array_push($json_response, $row_array);
            
        
        }

    }
    $json->notifications=$json_response;

    echo json_encode($json) ;


        ?>
