<?php

class content {
    
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
    
    public function writePost($uID, $title, $content) {
        $sql = "INSERT INTO Post (author, title, content) VALUES (:author, :title, :content)";
        $query = $this->db->prepare($sql);
        $parameters = array(':author' => $uID, ':title' => $title, ':content' => $content);
        $query->execute($parameters);
    }
    
    
    
}