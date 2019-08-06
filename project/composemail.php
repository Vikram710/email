<html>
<head><link href="style.css" rel="stylesheet"> </head>
    <body >
    <?php
        include 'dashboard.php';
    ?><div class="main">
        <div class="bar">New message</div>
        <form action="includes/compose.inc.php" method="POST" id="form" enctype='multipart/form-data'>
        <?php
        if(isset($_GET['repto'])){
            echo '<input type="text" name="to" placeholder="To" value='.$_GET['repto'].' ><br>';
        }
        else{
            echo'<input type="text" name="to" placeholder="To" required><br>';
        }
        ?>
            <input type="text" name="subject" placeholder="subject" required><br>
            <textarea  id="text" name="message"  placeholder="Enter text here"  ></textarea><br>
            <input type="color" name ="color" id= "color" style="height:50px;width:50px;padding:2.5px;margin:0px;margin-left:10px;" ><label>Choose color</label><br>
                        
            <label>Set mail expire time</label><input type="datetime-local" name="time" placeholder="Enter time">
            <input type="submit" name="send" value="Send"required>
            

    </form>
    
    <button id="changecolor" onclick="color()"style="width:150px;" >Change color</button>
    
</div>

    <div class="main">
    <div class="bar">Attach file</div>
    <form action="includes/attach.inc.php" method="POST" enctype='multipart/form-data'>
        <input type="text" name="to" placeholder="To" required>
        <input type="text" name="subject" placeholder="subject" required>
        <input type="file" name="file">
        <input type="submit" name="attach" value="Attach and send" class="q">
    </form>
</div>

<script src="button.js"></script>
</body>
</html>