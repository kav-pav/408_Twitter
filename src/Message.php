<?php

class Message{
    
    public static function getMessageById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Message WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    }
    
    private $id;
    private $authorId;
    private $receiverId;
    private $title;
    private $text;
    private $status;
    
    function __construct() {
        $this->id = -1;
        $this->authorId = 0;
        $this->receiverId = 0;
        $this->title = "";
        $this->text = "";
        $this->status = 0;
    }

    public function getId(){
        return $this->id;
    }
    
    public function setAuthorId($newAuthorId){
        $this->authorId = $newAuthorId;
    }
    
    public function getAuthorId(){
        return $this->authorId;
    }
    
    public function setReceiverId($newReceiverId){
        $this->receiverId = $newReceiverId;
    }
    
    public function getReceiverId(){
        return $this->receiverId;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($newTitle) {
        $this->title = $newTitle;
    }

    
    public function setText($newText){
        $this->text = $newText;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($newStatus) {
        $this->status = $newStatus;
    }
    
    public function statusRead(){
        $this->status = 1;
    }
    
    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Message WHERE id = $id";
        $result = $conn->query($id);
        if($result->num_rows == 1){
            $rowMessage = $result->fetch_assoc();
            $this->id = $rowMessage['id'];
            $this->authorId = $rowMessage['author_id'];
            $this->receiverId = $rowMessage['receiver_id'];
            $this->title = $rowMessage['title'];
            $this->text = $rowMessage['text'];
            $this->status = $rowMessage['status'];
            return $this;
        }
        return null;
    }
    
    
    public function saveMessageToDB(mysqli $conn){
        $sql = "INSERT INTO Message(author_id,receiver_id,title,text,status) VALUES "
                . "({$this->authorId},{$this->receiverId},'{$this->title}','{$this->text}',{$this->status})";
                
            if($conn->query($sql)) {
                $this->id = $conn->insert_id;
                echo "Message was sent successfully";
            }
            else{
                echo "Cannot send message ";
            }   
    }
    
    
   
}

