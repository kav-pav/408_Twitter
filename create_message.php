<?php
session_start();

require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/Comment.php';
require_once './src/Message.php';
require_once './src/connection.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if(isset($_GET['id'])){
            $authorId = $_SESSION['loggedUserId'];
            $receiverId = $_GET['id'];
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['message']) && isset($_POST['title'])){
                    $messageText = $_POST['message'];
                    $messageTitle = $_POST['title'];
                    $newMessage = new Message();
                    
                    $newMessage->setAuthorId($authorId);
                    $newMessage->setReceiverId($receiverId);
                    $newMessage->setText($messageText);
                    $newMessage->setTitle($messageTitle);
                    $newMessage->saveMessageToDB($conn);
                }
            }
        }
        
        ?>
        <h1>Send Message!</h1>
        <form method="POST">
            <fieldset>
                <label>
                    Title:<br>
                    <input type="text" name="title">
                </label>
                <br><br>
                <label>
                    Text:<br>
                    <textarea rows="4" cols="50" maxlength="255" name="message">
                    </textarea>
                </label>
                <br>
                <input type="submit" value="Send">
            </fieldset>
        </form>
    </body>
</html>
