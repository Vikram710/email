<html>
<head>
    <title>Document</title>
    <script src="index.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
        include 'dashboard.php';
    ?><div class="main "><div class="bar">Change password</div>
        <form action="includes/changepwd.inc.php" method="POST">
                <input type="password" name="password" id="password" placeholder="Enter password">
                <input type="password" name="confirm_password" id="rptpwd" placeholder="Repeat password" >
            <input type="checkbox" onclick="showpwd()"><label>Show Password</label>
            <input type="submit" name="submit" value="Change password" style="margin-left:280px;">
        </form>
</div>
    
</body>
</html>