<?php 
include("repository.php");
include("upload.php");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$animals = array();

if(isset($_GET["animal-select"])){
  $animal = getAnimalById($_GET["animal"]);
  array_push($animals, $animal);
}

if(isset($_GET["search-animal"])){
  $animals = getAnimalsByName($_GET["animal"]);
}

if(isset($_GET["show-all"])){
  $animals = getAllAnimals();
}

$selectAnimals = getAllAnimals();
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
<!-- Header  -->
<!-- Forms -->
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
  <!-- Search results -->
  <h2>Search results: <?php echo $resultAmount; ?> found </h2>
  <br>
  <!-- animal card -->
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