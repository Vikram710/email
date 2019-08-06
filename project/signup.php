<?php
session_start();
?>

<html>
    <head>
        <title>php</title>
        <link href="login.css" rel="stylesheet">
        <script src="index.js"></script>
    </head>
    <body>
        <div class="form" style="height:550px;">
        <div class="logo"><p><b>Gmail</b></p></div><h1>Register Here</h1>
        
            <form action="includes/signup.inc.php" method="post">

            <?php   

                if(isset($_GET['username'])){
                    $username=$_GET['username'];
                    echo' <label>Username</label><input type="username" name="username" placeholder="Enter username" value='.$username.' >';

                }
                else{
                    echo'<label>Username</label><input type="username" name="username" placeholder="Enter username" >';
                }

                if(isset($_GET['email'])){
                    $email=$_GET['email'];
                    echo'<label>Email</label><input type="email" name="email" placeholder="Enter email" value='.$email.'>';
                }
                else{
                    echo'<label>Email</label><input type="email" name="email" placeholder="Enter email">';
                }
                ?>
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password">
                <label>Repeat password</label>
                <input type="password" name="confirm_password" id="rptpwd" placeholder="Repeat password" >
                <input type="checkbox" onclick="showpwd()"><p class="showpwd">Show Password</p>
                <input type="submit" value="Sign up" name="submit">
            </form>

            <?php
                $url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                if(strpos($url,"error=emptyfields")==true){
                    echo '<p class="error">Fill up all fields.</p>';
                    exit();
                }
                else if(strpos($url,"error=invalidemail")==true){
                    echo '<p class="error">Invalid email id.</p>';
                    exit();                    
                }
                else if(strpos($url,"error=invalidemail")==true){
                    echo '<p class="error">Invalid email id.</p>';
                    exit();}
                else if(strpos($url,"error=invalidusername")==true){
                    echo '<p class="error">Username already taken.</p>';
                    exit();}
                else if(strpos($url,"error=smallpassowrd")==true){
                    echo '<p class="error">Password is too short.</p>';
                    exit();}
                else if(strpos($url,"error=passwordnotmatch")==true){
                    echo '<p class="error">Password did not match.</p>';
                    exit();}

                ?>
                
        </div>
    </body>
</html>