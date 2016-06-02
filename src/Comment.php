<?php

class Comment{
    
    private $id;
    private $tweetId;
    private $userId;
    private $creationDate;
    private $text;
    
    
    function __contruct(){
        $this->id = -1;
        $this->tweetId = 0;
        $this->userId = 0;
        $this->creationDate = 0;
        $this->$text = "";
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setTweetId($newTweetId){
        $this->tweetId = $newTweetId;
    }
    
    public function getTweetId(){
        return $this->tweetid;
    }
    
    public function setUserId($newUserId){
        $this->userId = $newUserId;
    }
    
    public function getUserId(){
        return $this->userId;
    }
    
    public function getCreationDate(){
        return $this->creationDate;;
    }
    
    public function setCreationDate($newCreationDate){
        $this->creationDate = $newCreationDate;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function setText($newText){
        $this->text = $newText;
    }
    
    public function create(){}
    
    public function loadFromDB(mysqli $conn,$id){
        $sql = "SELECT * FROM Comment WHERE tweet_id = $tweetId";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $rowComment = $result->fetch_assoc();
            $this->id = $rowComment['id'];
            $this->tweetId = $rowComment['tweet_id'];
            $this->userId = $rowComment['user_id'];
            $this->creationDate = $rowComment['creation_date'];
            $this->text = $rowComment['text'];
            return $this;
            }
        return null;
    }
    
    public function saveCommentToDB(mysqli $conn){
        $sql = "INSERT INTO Comment(tweet_id,user_id,creation_date,text) VALUES ('{$this->tweetId}','{$this->userId}','{$this->creationDate}','{$this->text}')";
                
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                echo "Added Comment";
            }
            else{
                echo "Cannot add comment";
            }   
    }
    
    
}

