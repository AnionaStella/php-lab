<?php 

function getAllAnimals(){
  $dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
  $animals = array();
  $query = "SELECT * FROM animals";
  foreach ($dbconnection->query($query) as $animal) {
    array_push($animals, $animal);
  }
  return $animals;
}

function getAnimalById($id) {
  $dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
  $selectQuery = "SELECT * FROM animals WHERE id = :id";
  $statement = $dbconnection->prepare($selectQuery, array(PDO::FETCH_ASSOC)); 
  $statement->execute(array(':id' => $id )); 
  $animals = $statement->fetchAll();
  return $animals[0];
  
}

function getAnimalsbyName($name) {
  $dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
  $searchQuery = "SELECT * FROM animals WHERE name = :name";
  $statement = $dbconnection->prepare($searchQuery, array(PDO::FETCH_ASSOC)); 
  $statement->execute(array(':name' => $name )); 
  return $statement->fetchAll(); 
}

function setImageById($image, $id) {
  $dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
  $updateImageQuery = "UPDATE animals set image = :image where id = :id";
  $statement = $dbconnection->prepare($updateImageQuery, array(PDO::FETCH_ASSOC)); 
  $statement->execute(array(':image' => $image, ':id' =>  $id));
}

?>