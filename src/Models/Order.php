<?php

namespace App\Models;

class Order
{
    protected $database;

    public function __construct(\PDO $db)
    {   
        $this->database = $db;
    }


    public function find_all()
    {
        $sql = "SELECT * FROM orders";
        try {
            $stmt = $this->database->prepare($sql);
           if($stmt->execute()){
               $result = $stmt->fetchAll();
               return $result;
           }
        
        } catch(\PDOException $e){
            return $e->getMessage();
        }
    }

    public function find_order($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        try {
            $stmt = $this->database->prepare($sql);
            if($stmt->rowCount() > 0){
                $result = $stmt->fetch();
                return $result;
            } else {
                
            }
        } catch(\PDOException $e){
            return $e->getMessage();
        }
    }


}