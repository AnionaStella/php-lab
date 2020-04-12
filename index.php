<?php 
/*Skapa sedan en enkel, dynamisk webbsida som använder PHP, MySQL och PDO. 
Du behöver ha ett formulär för att göra urval ur databasen. Detta ska innhålla en select, en textinput, och en möjlighet till filuppladdning. 
Dessutom ska din webbsida ha en resultat-del, där data presenteras. 
  • En användare ska kunna lista alla djur, och välja ett djur både utifrån en select/dropdown som från ett input-fält (text, exempelvis söka på namn). 
  • Bildfiler på söta djur ska kunna laddas upp till en katalog på din localhost-server.  */
  
include("upload.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbconnection = new PDO('mysql:host=localhost;dbname=zoo', "zoo", "zoo");
$animals = array();
$selectAnimals = array();
$query = "SELECT * FROM animals";

foreach ($dbconnection->query($query) as $animal) {
  array_push($selectAnimals, $animal);
}

if(isset($_GET["animal-select"])){
  $selectQuery = "SELECT * FROM animals WHERE id = :id";
  $statement = $dbconnection->prepare($selectQuery, array(PDO::FETCH_ASSOC)); 
  $statement->execute(array(':id' => $_GET["animal"] )); 
  $animals = $statement->fetchAll(); 
}

if(isset($_GET["search-animal"])){
  $searchQuery = "SELECT * FROM animals WHERE name = :name";
  $statement = $dbconnection->prepare($searchQuery, array(PDO::FETCH_ASSOC)); 
  $statement->execute(array(':name' => $_GET["animal"] )); 
  $animals = $statement->fetchAll(); 
}

if(isset($_GET["show-all"])){
  $animals = $selectAnimals;
}


//basename( $_FILES["fileToUpload"]["name"]) -- filnamn

$resultAmount = count($animals);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>ZOO</title>
</head>
<body>
<!-- Header - välkommen till zoo sidan, hitta djur i sökfält, resultat nedan -->
  <form action="index.php" method="get">
    <input type="hidden" name="show-all" value="1">
    <input type="submit" value="Show all">
  </form>
  <form action="index.php" method="get">
    <label for="animal-select">Select animal</label>
    <select name="animal" id="animal-select">
      <option value="">--select animal--</option>
      <?php foreach($selectAnimals as $animal) { ?>
      <option value="<?php echo $animal["id"]; ?>"><?php echo $animal["name"];?></option>
      <?php } ?>
    </select>
    <input type="submit" name="animal-select" value="submit">
  </form>
  <form action="index.php" method="get">
    <label for="search-animal">Search for animal</label>
    <input type="search" name="animal" id="search-animal">
    <input type="submit" name="search-animal" value="submit">
  </form>
  
  <h2>Search results: <?php echo $resultAmount; ?> found </h2>
  <br>
  <!-- animal card? -->
  <?php
   foreach ($animals as $animal) { ?>
    <div class="card">
      <img src="uploads/<?php echo $animal['image']; ?>" alt="">
      <div class="container">
        <h4>Name:<?php echo $animal['name']; ?> </h4>
        <p>Category: <?php echo $animal['category']; ?></p>
        <p>Birthdate: <?php echo $animal['birthday']; ?></p>
        <form action="index.php" method="post" enctype="multipart/form-data">
          Select image to upload:
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="hidden" name="animalId" value="<?php echo $animal['id']; ?>">
          <input type="submit" value="Upload Image" name="submit">
        </form>
      </div>
    </div>
  <?php } ?>
</body>
</html>