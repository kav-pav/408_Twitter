<?php

class Tweet{
    
    public static function loadAllComments(mysqli $conn, $tweetId){
        $sql = "SELECT Comment.text, User.fullName, Comment.creation_date FROM Comment JOIN User ON Comment.user_id = User.id WHERE tweet_id = $tweetId ORDER BY Comment.creation_date";
        $result = $conn->query($sql);
        if($result->num_rows > 0 ){
            $arrayComments = [];
            while($row = $result -> fetch_assoc()){
                   $arrayComments[] = [$row['fullName'],$row['text'],$row['creation_date']];
                 
            }
            return $arrayComments;
        }
        return false;
    }
    
    public static function show(mysqli $conn, $id){
        $sql = "SELECT * FROM Tweet WHERE id = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            return $row;
        }
        return false;
            
    }
    
    private $id;
    private $user_id;
    private $text;
    
    public function __construct(){
        $this->id = '-1';
        $this->user_id = '';
        $this->text = '';
        
    }
    
    public function setText($newText){
        $this->text = is_string($newText) ? trim($newText) : $this->text;
    }
    
    public function getText(){
        return $this>text;
    }
    
    public function setUserId($newUserID){
        $this->user_id = is_numeric($newUserID) ? trim($newUserID) : $this->user_id;
    }
    
    public function getUserId(){
        return $this->user_id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    
   public function loadFromDB(mysqli $conn,$id){
        $sql = "SELECT * FROM Tweet WHERE id = $id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $rowUser = $result->fetch_assoc();
            $this->id = $rowUser['id'];
            $this->userId = $rowUser['id_user'];
            $this->text = $rowUser['text'];
            return $this;
           
        }
        return null;
    }
    
    public function saveTweetToDB(mysqli $conn){
        $sql = "INSERT INTO Tweet(id_user,text) VALUES ({$this->user_id},'{$this->text}')";
                
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                echo "Added tweet";
            }
            else{
                echo "Cannot add tweet";
            }   
    }
    //show ma pokauje twitta na podstawie id
    
}
 
