<?php
session_start();
?>

<html>
    <head>
        <title>php</title>
        <link href="login.css" rel="stylesheet">
        <script src="index.js"></script>
    </head>
    <body>  <input type="password" name="confirm_password" id="rptpwd" placeholder="Repeat password" hidden >          
        <?php
                if(isset($_GET["userid"])){
                    echo '<div class="form"style="height:140px;"><div class="logo"><p><b>Gmail</b></p></div>
                    <form action="includes/logout.inc.php" method="post">
                             <input type="submit" name="logout" value="Log out">
                        </form></div>';}
                else{
                    $a="'";
                    echo'
                    <div class="form"><div class="logo"><p><b>Gmail</b></p></div>
                    <h1>Login Here</h1>
                    <form action="includes/login.inc.php" method="POST">
                        <label>Username</label>
                        <input type="username" name="username" placeholder="Enter Username">
                        <label>Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password">
                        <input type="checkbox" onclick="showpwd()"><p class="showpwd">Show Password</p>
                        <input type="submit" name="submit" value="Login">
                        <a href="forgot.php">Forgot password?</a><br>
                        <a href="signup.php">Don'.$a.'t have an account?</a>
                    </form>';
                }
        ?>    
         <?php
            $url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($url,"error=wrongpassword")==true){
                echo '<br><p class="error">Incorrect password.</p></div>';
                exit();
            }
            else if(strpos($url,"error=wrongusername")==true){
                echo '<br><p class="error">Incorrect username.</p>';
                exit();                    
            }
            else if(strpos($url,"result=changedpwd")==true){
                echo '<br><p class="result">Sucessfully changed your password.</p>';
                exit();                    
            }
            ?>




    </body>
</html>