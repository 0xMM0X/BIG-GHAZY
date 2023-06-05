<?php

session_start();
if(empty($_SESSION['email']) || empty($_SESSION['notes_file']))
{
    die(header("Location:index.php")); 
}






// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if(empty($_FILES["fileToUpload"]["name"]))
    {
        die("<script>alert('There is no files');history.back()</script>"); 
    }

$target_dir = "up/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }



// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "up/".$_SESSION['uuid'].".jpg")) {

    echo "Sorry, there was an error uploading your file.";
  }
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Profile</title>
</head>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
img {
  width: 100%;
  height: 100%;
}

.bg-black {
  background: #000;
}

.skill-block {
  width: 30%;
}

@media (min-width: 991px) and (max-width:1200px) {
  .skill-block {
    padding: 32px !important;
  }
}

@media (min-width: 1200px) {
  .skill-block {
    padding: 56px !important;
  }
}

body {
  background-color: #eeeeee;
}
</style>
<body>
<div class="container mt-5 mb-5">
            <div class="row no-gutters">
                <div class="col-md-4 col-lg-4"><img src="up/<?=$_SESSION['uuid']?>.jpg" onerror="this.src='https://i.imgur.com/aCwpF7V.jpg';"></div>
                <div class="col-md-8 col-lg-8">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 bg-dark text-white">
                            <h3 class="display-5"><?=$_SESSION['name']?></h3>
                            <form action="profile.php" method="post" enctype="multipart/form-data">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form>   
                        </div>
                        <div class="p-3 bg-black text-white">
                            <h6><?=$_SESSION['email']?></h6>
                            <a href="notes.php">Go to your notes</a>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>

</body>
</html>
