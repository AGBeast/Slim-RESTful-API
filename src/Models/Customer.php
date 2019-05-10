<?php
namespace App\Models;
use PDO;

class Customer
{
    protected $database;

    public function __construct(\PDO $db)
    {
        $this->database = $db;
    }

    public function find_all()
    {
        $query = "SELECT * FROM customers";
        $customers = '';
        $stmt = $this->database->prepare($query);
        if($stmt->execute())
        {
            $customers = $stmt->fetchAll();
            return $customers;
        }

    }

    public function number_of_customers()
    {
        $query = "SELECT COUNT(*) FROM customers";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $num_records = $stmt->fetch();
        return $num_records;
    }

    public function update_customer($id, $data)
    {
        $id = $id;
        $first_name = isset($data["first_name"]) ? $data["first_name"] : "Unknown";
        $last_name  = $data['last_name'];
        $address    = $data['address'];
        $city       = $data['city'];
        $state      = $data['state'];
        $zipcode    = $data['zipcode'];

        $query = 'UPDATE customers SET 
                first_name = :first_name, 
                last_name = :last_name,
                address =   :address, 
                city =      :city,
                state =     :state,
                zipcode =   :zipcode
                WHERE id =  :id';
        try {
        $stmt = $this->database->prepare($query);

        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name',  $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':address',    $address, PDO::PARAM_STR);
        $stmt->bindParam(':city',       $city, PDO::PARAM_STR);
        $stmt->bindParam(':state',      $state, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode',    $zipcode, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();
        if($result){
            return true;
        } else {
            return false;
            }

        } catch (\PDOException $e){
           return $e->getMessage();
        }

        


    }

    public function get_customer($id)
    {

        $query = "SELECT * FROM customers WHERE id= ".$id;
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $customer = $stmt->fetch();
        return $customer;
    }

    public function delete_customer($id)
    {
        $query = "DELETE FROM customers WHERE id= ".$id;
        $stmt  = $this->database->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count === 1){
            return true;
        }else {
            return false;
        }
    }

    public function create_customer($data)
    {
        $query = "INSERT INTO customers (first_name, last_name, address, city, state, zipcode)
                VALUES (:first_name, :last_name, :address, :city, :state, :zipcode)";
        $stmt = $this->database->prepare($query);

        try{
            $stmt->bindParam(':first_name',$data['first_name'],PDO::PARAM_STR);
            $stmt->bindParam(':last_name',$data['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
            $stmt->bindParam(':city', $data['city'], PDO::PARAM_STR);
            $stmt->bindParam(':state', $data['state'], PDO::PARAM_STR);
            $stmt->bindParam(':zipcode', $data['zipcode'], PDO::PARAM_INT);
           if($stmt->execute()){
               return true;
           } else {
               false;
           }

        } catch(\PDOException $e){
            return $e->getMessage();
        }
    }

    
}




?>