<?php

session_start();

require_once './src/User.php';
require_once './src/connection.php';
require_once './src/Tweet.php';


if(!isset($_SESSION['loggedUserId'])){
    header("Locaton: login.php");
}

?>

<html>  
    <head> 
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Hey Logged user id = <?php echo $_SESSION['loggedUserId']?></h1><br>
        <h2>Add your tweet</h2>
        
        
        <form method="POST">
            <textarea rows="4" cols="50" maxlength="140" name="tweet">
            </textarea>
            <br>
            <input type="submit" value="Send"></input>
        </form>
        <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!empty($_POST['tweet'])){
                $tweetText = $_POST['tweet'];
                $idUser = $_SESSION['loggedUserId'];
                $newTweet = new Tweet();
                $newTweet->setUserId($idUser);
                $newTweet->setText($tweetText);
                $newTweet->saveTweetToDB($conn);
            }
            else{
                echo("Cannot add empty tweet");
            }
        }
        ?>
        <h2>Tweets</h2> <?php 
      
        
        $allTweets = User::loadAllTweets($conn, $_SESSION['loggedUserId']);
        
        echo "<ul>";
        for($i = 0; $i < count($allTweets);$i++ ){
        echo "<li>{$allTweets[$i][1]}<br><a href='tweet_page.php?id={$allTweets[$i][0]}'>Show tweet</a></li>";
        }
        echo "</ul>"; 
        
        echo "<a href='user_edit.php'>Edit Data</a>";
        echo "  <a href='messages_page.php'>All Messages</a>";
        echo "  <a href='users_page.php'>All Users</a>";
        echo "  <a href='logout.php'>Logout</a>";
        ?>
        
        
    </body>
</html>
