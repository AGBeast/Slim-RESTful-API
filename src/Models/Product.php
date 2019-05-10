<?php
namespace App\Models;
use PDO;
class Product
{
    protected $database;
    private $table = 'products';
    public function __construct(\PDO $db)
    {
        $this->database = $db;
    }

    public function get_all_products()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function get_product($id)
    {
        $sql = "SELECT * FROM products WHERE id =:id";
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();
        return $product;
    }

    public function update_product($id, $data)
    {
        $sql ="UPDATE products SET 
            product_name = :product_name,
            product_price = :product_price,
            product_description = :product_description,
            product_instock = :product_instock,
            order_id = :order_id
            WHERE id=:id";

        $product_name  = isset($data['product_name']) ? $data['product_name'] : "Unknown";
        $product_price = isset($data['product_price']) ? $data['product_price'] : 0.00;
        $product_description = isset($data['product_description']) ? $data['product_description'] : "";
        $product_instock = isset($data['product_instock']) ? $data['product_instock'] : 1;
        $order_id  =      isset($data['order_id']) ? $data['order_id'] : 0;
        $id =   $id;

    try {
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(':product_name',$product_name, PDO::PARAM_STR);
        $stmt->bindParam(':product_price', $product_price, PDO::PARAM_STR);
        $stmt->bindParam(':product_description', $product_description, PDO::PARAM_STR);
        $stmt->bindParam(':product_instock', $product_instock, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

       if ($stmt->execute()){
           return true ;
       } else {
        return false;
       }

        } 
        catch(\PDOException $e){
            echo $e->getMessage();
        }
    }
}





?>