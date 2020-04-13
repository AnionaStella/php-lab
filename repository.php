<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AnimalRepository {

  public $dbconnection;

  function __construct() {
    $this->dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
  }

  function getAllAnimals() {
    $animals = array();
    $query = "SELECT * FROM animals";
    foreach ($this->dbconnection->query($query) as $animal) {
      array_push($animals, $animal);
    }
    return $animals;
  }

  function getAnimalById($id) {
    $selectQuery = "SELECT * FROM animals WHERE id = :id";
    $statement = $this->dbconnection->prepare($selectQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':id' => $id )); 
    $animals = $statement->fetchAll();
    return $animals[0];
  }

  function getAnimalsbyName($name) {
    $searchQuery = "SELECT * FROM animals WHERE name = :name";
    $statement = $this->dbconnection->prepare($searchQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':name' => $name )); 
    return $statement->fetchAll(); 
  }

  function setImageById($image, $id) {
    $updateImageQuery = "UPDATE animals set image = :image where id = :id";
    $statement = $this->dbconnection->prepare($updateImageQuery, array(PDO::FETCH_ASSOC)); 
    $statement->execute(array(':image' => $image, ':id' =>  $id));
  }
}
?>