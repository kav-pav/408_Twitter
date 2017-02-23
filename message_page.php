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
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $messageId = $_GET['id'];
            $messageInfo = Message::getMessageById($conn, $messageId);
            $userInfo = User::getUserById($conn, $messageInfo['author_id']);
            }
        echo "<h3>{$messageInfo['title']}</h3><br>"
            ."<p><b>Text:</b><br>{$messageInfo['text']}</p><br>"
            ."<p><b>Author:</b><br>{$userInfo['fullName']}</p>";       
        ?>
        <a href='index.php'>Index</a>
        
        
    </body>
</html>


