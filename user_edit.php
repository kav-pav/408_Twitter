<?php
session_start();
require_once('./src/User.php');
require_once('./src/Message.php');
require_once('./src/connection.php');
require_once('./src/Tweet.php');

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userId = $_SESSION['loggedUserId'];
            if(!empty($_POST['change'])){
                switch ($_POST['change']){
                    case 'changeFullName':
                        $newName = $_POST['newFullName'];
                        if(!empty($newName)){
                            $newUserData = new User();
                            $newUserData->loadFromDB($conn, $userId);
                            $newUserData->setFullName($newName);
                            $newUserData->saveToDB($conn);
                            echo"Your new Name was updated sucessfully";
                        }
                        else{
                            echo"New Name is empty";
                        }
                        break;
                        
                    case 'changeEmail':
                        $newEmail = $_POST['newEmail'];
                        $retypeNewEmail = $_POST['retypeNewEmail'];
                        if(!empty($newEmail)){
                                if(!empty($retypeNewEmail)){
                                    if($newEmail==$retypeNewEmail){
                                        $newUserData = new User();
                                        $newUserData->loadFromDB($conn, $userId);
                                        $newUserData->setEmail($newEmail);
                                        $newUserData->saveToDB($conn);
                                        echo"Your new email was updated sucessfully";
                                    }
                                    else{
                                        echo"New email and Retype new email are diffrent";
                                    }
                                }else{
                                    echo"Retyped new email is empty";
                                }
                        }
                        else{
                            echo"New email is empty";
                        }
                        break;
                    case 'changePassword':
                        $newPassword = $_POST['newPassword'];
                        $retypeNewPassword = $_POST['retypeNewPassword'];
                        $currentPassword = $_POST['oldPassword'];
                        if(!empty($currentPassword)){
                            if(!empty($newPassword)){
                                if(!empty($retypeNewPassword)){
                                    if($currentPassword!==$newPassword){
                                        if($newPassword==$retypeNewPassword){
                                            $newUserData = User::getUserById($conn, $userId);
                                            if(password_verify($currentPassword, $newUserData['password']) && $newUserData['active']==1){
                                                $newUserData = new User();
                                                $newUserData->loadFromDB($conn, $userId);
                                                $newUserData->setPassword($newPassword, $retypeNewPassword);
                                                $newUserData->saveToDB($conn);
                                                echo"Your new password was updated sucessfully";
                                            }
                                            else{
                                                echo"Incorrect current password";
                                            }

                                        }
                                        else{
                                            echo"New password and Retype new password are diffrent";
                                        }
                                    }
                                    else{
                                        echo"New password cannot be same as a current password";
                                    }
                                }
                                else{
                                    echo"Retyped new password is empty";
                                }
                            }
                            else{
                                echo"New password is empty";
                            }
                        }
                        else{
                            echo"Current password is empty";
                        }    
                        break;
                    default:
                        echo"Something goes wrong";
                        break;
                }
            }
        }
        
        ?>
        <h1>Change your data</h1>
        <form method="POST">
            <fieldset>
                <label>
                    New full name:
                    <input type="text" name="newFullName">
                </label>
                <br>
                <input type="submit" name="change" value="changeFullName">
            </fieldset>
        </form>
        <br>
        <form method="POST">
            <fieldset>
                <label>
                     New email:
                    <input type="text" name="newEmail">
                </label>
                <br>
                <label>
                     Retype new email:
                    <input type="text" name="retypeNewEmail">
                </label>
                <br>
                <input type="submit" name="change" value="changeEmail">
            </fieldset> 
        </form>
        <br>
        <form method="POST">
            <fieldset>
                <label>
                    Current password:
                    <input type="password" name="oldPassword">
                </label>
                <br>
                <label>
                    New password:
                    <input type="password" name="newPassword">
                </label>
                <br>
                <label>
                    Retype new password:
                    <input type="password" name="retypeNewPassword">
                </label>
                <br>
                <input type="submit" name="change" value="changePassword">
            </fieldset>
        </form>
        <a href="index.php">Index</a>    
    </body>
</html>
