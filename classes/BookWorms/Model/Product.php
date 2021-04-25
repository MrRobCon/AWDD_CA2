<?php
//CREATING product CLASS

namespace BookWorms\Model;

use Exception;
use PDO;

class Product {
  public $id;
  public $name;
  public $description;
  public $price;
  public $category;
  public $color;
  public $image_id;


  public function __construct() {
    $this->id = null;
  }
//CREATING SAVE FUNCTION
  public function save() {
    try{
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();
      $params = [
        ":name" => $this->name,
        ":description" => $this->description,
        ":price" => $this->price,
        ":category" => $this->category,
        ":color" => $this->color,
        ":image_id" => $this->image_id
      ];
      if($this->id === null){
        $sql = "INSERT INTO products (" .
      "name, description, price, category, color, image_id" . ") 
      VALUES (" .
      ":name, :description, :price, :category, :color, :image_id" . ")";
      }
      else{
        $sql = "UPDATE products SET " . 
        "name = :name, " .
        "description = :description, " .
        "price = :price, " .
        "category = :category, " .
        "color = :color, " .
        "image_id = :image_id, " .
        "WHERE id = :id" ;
        $params[":id"] = $this->id;

      }
      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status){
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception ("Database error executing database query: " . $message);
      }
      if ($stmt->rowCount() !== 1) {
        throw new Exception ("Failed to save product");
      }
    
      if ($this->id === null){
        $this->id = $conn->lastInsertid();
      }
    }
    finally{
      if ($db !== null && $db->is_open()){
        $db->close();
      }
    }
  }
//CREATING DELETE FUNCTION
  public function delete() {
    try{
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();


        $sql = "DELETE FROM products WHERE id = :id" ;
        $params = [
          ":id" => $this->id
        ];
      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status){
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception ("Database error executing database query: " . $message);
      }
      if ($stmt->rowCount() !== 1) {
        throw new Exception ("Failed to delete product");
      }
    }
    finally{
      if ($db !== null && $db->is_open()){
        $db->close();
      }
    }
  }
//CREATING FIND ALL FUNCTION
  public static function findAll() {
    $products = array();

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM products";
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute();

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          $product = new product();
          $product->id = $row['id'];
          $product->name = $row['name'];
          $product->description = $row['description'];
          $product->price = $row['price'];
          $product->category = $row['category'];
          $product->color = $row['color'];
          $product->image_id = $row['image_id'];
          $products[] = $product;

          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $products;
  }
//CREATING FIND BY ID FUNCTION
  public static function findByID($id) {
    $product = null;

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM products WHERE id = :id";
      $select_params = [
        ":id" => $id
      ];
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($select_params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $product = new product();
        $product->id = $row['id'];
        $product->name = $row['name'];
        $product->description = $row['description'];
        $product->price = $row['price'];
        $product->category = $row['category'];
        $product->color = $row['color'];
        $product->image_id = $row['image_id'];

      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $product;
  }

}
?>
