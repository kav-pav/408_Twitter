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
        <h1>Message box</h1>
        <?php
        $userId = $_SESSION['loggedUserId'];
        $userMessagesSent = User::loadAllMessagesSent($conn, $userId);
        $userMessageReceiver = User::loadAllMessagesReceiver($conn, $userId);
        echo"<ul>Outbox: <br>";
        for($i = 0; $i < count($userMessagesSent); $i++){
            echo "<a href='user_page.php?id={$userMessagesSent[$i][1]}'>{$userMessagesSent[$i][2]}</a>"
            . "<br><li>Title: {$userMessagesSent[$i][3]}<br>Message: {$userMessagesSent[$i][4]}</li><br>";
        }
        echo"</ul>";
        echo"<ul>Inbox: <br>";
        for($i = 0; $i < count($userMessageReceiver); $i++){
            echo "<a href='user_page.php?id={$userMessageReceiver[$i][1]}'>{$userMessageReceiver[$i][2]}</a>"
                . "<br><li>Title: <a href='message_page.php?id={$userMessageReceiver[$i][0]}'>{$userMessageReceiver[$i][3]}</a><br>Message: {$userMessageReceiver[$i][4]}</li>";
        }
        echo"</ul>";
        ?>
    </body>
</html>
