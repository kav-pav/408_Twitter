<?php
session_start();
require_once './src/connection.php';
require_once './src/User.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
         if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $userId = $_GET['id'];
            $userData = User::getUserById($conn, $userId);
            $userTweets = User::loadAllTweets($conn, $userId);
    
            echo"<h1>Tweets user: {$userData['fullName']}</h1>";
            echo "<br>";
            echo"<h2>Email: {$userData['email']}</h2>";
            if($_SESSION['loggedUserId'] !== $userId){
            echo"<a href='create_message.php?id=$userId'>Create Message</a>";
            }
            echo "<ul>";//postylowac ten shit
            for($i = 0; $i < count($userTweets);$i++ ){
                echo "<li>".$userTweets[$i][1]."</li>";
            }
            echo "</ul>";  
         }
         echo "<a href='index.php'>Index</a>";
         echo "  <a href='users_page.php'>All Users</a>";
        ?>
    </body>
</html>
