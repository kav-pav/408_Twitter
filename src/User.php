<?php

class User {
    
    public static function getUserByEmail(mysqli $conn,$email){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            return $row;
            
        }
        else{
            return false;
        }
    }
    
    public static function getUserById(mysqli $conn,$id){
        $sql = "SELECT * FROM User WHERE id = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            return $row;
            
        }
        else{
            return false;
        }
    }
    
    public static function login(mysqli $conn, $email, $password){
        $sql = "SELECT * FROM User WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
           $rowUser = $result->fetch_assoc();
            if(password_verify($password, $rowUser['password']) && $rowUser['active'] == 1){
                return $rowUser['id'];
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    
    public static function loadAllTweets(mysqli $conn, $userId){
        $sql = "SELECT * FROM Tweet WHERE id_user = $userId";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $arrayTweets = [];
            while($row = $result -> fetch_assoc()){
                   $arrayTweets[] = [$row['id'],$row['text']];
                 
            }
            return $arrayTweets;
        }
        return false;
    }
    
    public static function loadAllMessagesSent(mysqli $conn, $userId){
        $sql = "SELECT Message.id, Message.receiver_id, User.fullName, Message.title, Message.text FROM Message "
                . "JOIN User ON Message.receiver_id = User.id "
                . "WHERE author_id = $userId";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $arrayMessagesSent = [];
            while($row = $result -> fetch_assoc()){
                   $arrayMessagesSent[] = [$row['id'],$row['receiver_id'],$row['fullName'],$row['title'],$row['text']];
                 
            }
            return $arrayMessagesSent;
        }
        return false;
    }
    
    public static function loadAllMessagesReceiver(mysqli $conn, $userId){
        $sql = "SELECT Message.id, Message.author_id, User.fullName, Message.title, Message.text FROM Message "
                . "JOIN User ON Message.receiver_id = User.id "
                . "WHERE receiver_id = $userId";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $arrayMessagesReceiver = [];
            while($row = $result -> fetch_assoc()){
                   $arrayMessagesReceiver[] = [$row['id'],$row['author_id'],$row['fullName'],$row['title'],$row['text']];
                 
            }
            return $arrayMessagesReceiver;
        }
        return false;
    }
    
    private $id;
    private $email;
    private $password;
    private $fullName;
    private $active;
    
    public function __construct(){
        $this->id = -1;
        $this->email = '';
        $this->password = '';
        $this->fullName = '';
        $this->active = 0;
    }
    
    public function setEmail($email){
        $this->email = is_string($email) ? trim($email) : $this->email;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setPassword($password, $retypedPassword){
        if ($password != $retypedPassword){
            return false;
        }
        
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return true;
    }
    
    public function setFullName($fullName){
        $this->fullName = is_string($fullName) ? trim($fullName) : $this->fullName;
    }
    
    public function getFullName(){
        return $this->fullName;
    }
    
    public function activate(){
        $this->active = 1;
    }
    
    public function deactivate(){
        $this->activate =0;
    }
    
    public function getActive(){
        return $this->active;
    }
    
    public function loadFromDB(mysqli $conn,$id){
        $sql = "SELECT * FROM User WHERE id = $id";
        $result = $conn->query($id);
        if($result->num_rows == 1){
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->email = $rowUser['email'];
            $this->password = $rowUser['password'];
            $this->fullName = $rowUser['fullName'];
            $this->active = $rowUser['active'];
        }
        return null;
    }
    
    public function saveToDB(mysqli $conn){
        if($this->id == -1){
            $sql = "INSERT INTO User(email, password, fullName, active)
            VALUES ('{$this->email}', '{$this->password}', '{$this->fullName}', {$this->active})";
                    
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $sql = "UPDATE User SET 
                email='{$this->emaail}, 
                fullName = '{$this->fullName}', 
                active = {$this->active},
                password = {$this->password}
                WHERE id = {$this->id}";
                
            if($conn->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }    
     
    }
    
   
    
}

