<?php
session_start();

require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/Comment.php';
require_once './src/connection.php';

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if(isset($_GET) == 'GET'){
            $tweetId = $_GET['id'];
            $thisTweet = Tweet::show($conn, $tweetId);
            $userInfo = User::getUserById($conn, $thisTweet['id_user']);
            $userName = $userInfo['fullName'];
            echo"<h1>Tweet by $userName</h1>";
            echo"<div>{$thisTweet['text']}</div>";
            $tweetComments= Comment::loadAllComments($conn, $tweetId);
            echo "Comments:";
            echo "<dl>";
            for($i = 0; $i < count($tweetComments);$i++ ){
                echo "<dt> Name: <a href='user_page.php?id={$thisTweet['id_user']}'>{$tweetComments[$i][0]}</a>"
                . "<br> Date: {$tweetComments[$i][2]}</dt>";
                echo "<dl> Comment: {$tweetComments[$i][1]}</dl>";
            
        }
        
        
        }
        echo "</dl>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['comment'])){
                
                $newComment = new Comment();
                $newComment->setTweetId($_GET['id']);
                $newComment->setUserId($_SESSION['loggedUserId']);
                $newComment->setCreationDate(date('Y-m-d G:i'));
                $newComment->setText($_POST['comment']);
                $newComment->saveCommentToDB($conn);
            }
            
        
        }
        ?>
        
        <form method="POST">
            <textarea rows="4" cols="50" maxlength="100" name="comment">
            </textarea>
            <br>
            <input type="submit" value="Comment">
        </form>
        <?php
        echo "<a href='index.php'>Index</a>";
        echo "  <a href='user_page.php?id={$thisTweet['id_user']}'>User Page</a>";
        echo"<a href=''>"
        ?>
    </body>
</html>
