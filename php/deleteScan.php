<?php
  session_start();

  if (!isset($_SESSION['dir']) || !isset($_POST["file"])) {
    $response["success"] = false;
    die(json_encode($response));
  }

  $path = "../outscan/".$_SESSION["dir"];
  $file = explode(".", $_POST["file"])[0];
  system("rm $path/$file.png $path/$file.tiff");

  $response["success"] = true;
  print(json_encode($response));
?>
