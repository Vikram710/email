<?php
session_start();

    if(isset($_POST["submit"]) && isset($_SESSION["userid"])){
    }

    else{
        header("Location:../index.php");
        exit();
    }
