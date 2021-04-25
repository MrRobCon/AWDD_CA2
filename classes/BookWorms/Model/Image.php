<?php
//CREATING IMAGE CLASS
namespace BookWorms\Model;

use Exception;
use PDO;

class Image {
    public $id;
    public $path;

    public function __construct(){
        $this->id =null;
    }
//CREATING IMAGE SAVE FUNCTION
    public function save(){
        try{
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();

          $params = [
            ":path" => $this->path
          ];
          if ($this->id === null){
            $sql = "INSERT INTO images (path) VALUES (:path)";
          }
          else{
            $sql = "UPDATE images SET path = :path WHERE id = :id" ;
            $params[":id"] = $this->id;
          }
          $stmt = $conn->prepare($sql);
          $status = $stmt->execute($params);

          if (!$status){
            $error_info = $select_stmt->errorInfo();
            $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
            throw new Exception("Database error executing database query: " . $message);
          }

          if ($stmt->rowCount() !== 1){
            throw new Exception("Failed to save image.");
          }

          if ($this->id === null){
            $this->id = $conn->lastInsertId();
          }
        }
        finally{
          if ($db !== null && $db->is_open()){
            $db->close();
          }
        }
      }
    public function delete(){
        throw new Exception("Not yet implemented");
    }

    public static function findAll(){
        throw new Exception("Not yet implemented");
    }
//CREATING IMAGE FIND BY ID FUNCTION
    public static function findById($id){
        $image = null;

        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
    
          $select_sql = "SELECT * FROM images WHERE id = :id";
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
            $image = new Image();
            $image->id = $row['id'];
            $image->path = $row['path'];
          }
        }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $image;
    }
}
?>