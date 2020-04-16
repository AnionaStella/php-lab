<?php 

// Error codes for wip
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AnimalRepository {

  private $dbconnection;

  public function __construct() {
    $this->dbconnection = new PDO('mysql:host=localhost;dbname=zoo', 'zoo', 'zoo');
  }

  public function getAllAnimals() {
    $query = 'SELECT * FROM animals';
    $statement = $this->dbconnection->prepare($query, array(PDO::FETCH_ASSOC)); 
    $statement->execute(); 
    return $statement->fetchAll();
  }

  public function getAnimalById($id) {
    $selectQuery = 'SELECT * FROM animals WHERE id = :id';
    $statement = $this->dbconnection->prepare($selectQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':id' => $id)); 
    return $statement->fetch();
  }

  public function getAnimalsByName($name) {
    $searchQuery = 'SELECT * FROM animals WHERE name = :name';
    $statement = $this->dbconnection->prepare($searchQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':name' => $name)); 
    return $statement->fetchAll(); 
  }

  public function setImageById($image, $id) {
    $updateImageQuery = 'UPDATE animals set image = :image where id = :id';
    $statement = $this->dbconnection->prepare($updateImageQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':image' => $image, ':id' =>  $id));
  } 
}
