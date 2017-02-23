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
        $sql = "SELECT * FROM User";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo "<ul>";
            while($row = $result->fetch_assoc()){
                echo "<li><a href='./user_page.php?id={$row['id']}'>name: {$row['fullName']} email: {$row['email']}</a></li>";
            }
            echo"</ul>";
            //wyswietlanie wszystkich uzytkownikow
        }
        
        echo "<a href='index.php'>Index</a>";
        ?>
    </body>
</html>
