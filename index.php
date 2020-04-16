<?php 
include('repository.php');
$animalRepository = new AnimalRepository();
include('upload.php');

//Error codes for wip
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$animals = array();

if(isset($_GET['animal-select'])){
  $animal = $animalRepository->getAnimalById($_GET['animal']);
  array_push($animals, $animal);
}

if(isset($_GET['search-animal'])){
  $animals = $animalRepository->getAnimalsByName($_GET['animal']);
}

if(isset($_GET['show-all'])){
  $animals = $animalRepository->getAllAnimals();
}

$selectAnimals = $animalRepository->getAllAnimals();
$resultAmount = count($animals);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>ZOO</title>
</head>
<body>
<!-- Header  -->
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-2">Animal search</h1>
    </div>
  </div>
  <!-- Forms -->
  <div class="container-fluid selectfield">
  <form action="index.php" method="get">
    <div class="form-group">
      <label for="search-animal">Search for an animal: </label>
      <input type="search" placeholder="Search..." name="animal" id="search-animal">
      <input type="submit" name="search-animal" value="Search">
    </div>
    </form>
    <form action="index.php" method="get">
    <div class="form-group">
      <label for="animal-select">Select animal: </label>
      <select name="animal" id="animal-select">
        <option value="">-- select --</option>
        <?php foreach($selectAnimals as $animal) { ?>
        <option value="<?php echo $animal['id']; ?>"><?php echo $animal['name'];?></option>
        <?php } ?>
      </select>
      <input type="submit" name="animal-select" value="Select">
    </div>
    </form>
    <form action="index.php" method="get">
    <div class="form-group">
      <label for="show-all">Show all animals: </label>
      <input type="hidden" name="show-all" value="1" id="show-all">
      <input type="submit" value="Show all">
      </div>
  </form>
  </div>
    <br>
    <!-- Search results -->
    <h2>Search results: <?php echo $resultAmount; ?> found </h2>
    <br>
    <div class="row">
      <?php
      foreach ($animals as $animal) { ?>
        <div class="col-sm-4">
          <!-- animal card -->
          <div class="card">
            <?php if(!empty($animal['image'])){ ?>
              <img src="uploads/<?php echo $animal['image']; ?>" class="card-img-top" alt="">
            <?php }else { ?>
             <img src="images/pre-image.png" class="card-img-top pre-image" alt="no image">
            <?php } ?>
            <div class="container">
              <h4>Name: <?php echo $animal['name']; ?> </h4>
              <p>Category: <?php echo $animal['category']; ?></p>
              <p>Birthdate: <?php echo $animal['birthday']; ?></p>
              <form action="index.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <br>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="hidden" name="animalId" value="<?php echo $animal['id']; ?>">
                <input type="submit" value="Upload Image" name="submit">
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <!-- Bootstrap script files -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>