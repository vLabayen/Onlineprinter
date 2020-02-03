<?php
  session_start();
  $command="scanimage -d hpaio:/net/Deskjet_3520_series?zc=HP2C44FD75EF80 --format=tiff";

  if (!isset($_SESSION['dir'])) {
    $_SESSION['dir'] = time();
    $_SESSION['files'] = [];
    $_SESSION['files_index'] = 1;

    system("mkdir ../outscan/".$_SESSION["dir"]);
  }

  function returnError($text) {
    $response["Error"] = true;
    $response["Msg"] = $text;
    die(json_encode($response));
  }

  //Check for colormode
  if (!in_array($_POST["scolormode"], ["Lineart", "Gray", "Color"])) returnError("Tipo de color incorrecto");
  else $command.=" --mode ".$_POST["scolormode"];

  //Check for resolution
  if (!in_array($_POST["scanres"], [75, 100, 200, 300, 600, 1200])) returnError("Tipo de resolucion incorrecta");
  else $command.=" --resolution ".$_POST["scanres"];

  //Check for brightness
  if (!(0 <= $_POST["brightness"]) && ($_POST["brightness"] <= 2000)) returnError("Tipo de brillo incorrecto");
  else $command.=" --brightness ".$_POST["brightness"];

  //Check for contrast
  if (!(0 <= $_POST["contrast"]) && ($_POST["contrast"] <= 2000)) returnError("Tipo de contraste incorrecto");
  else $command.=" --contrast ".$_POST["contrast"];

  //Check for width
  if (!(0 <= floatval($_POST["width"])) && (floatval($_POST["width"]) <= 215.9)) returnError("Tipo de ancho incorrecto");
  else $command.=" -x ".floatval($_POST["width"]);

  //Check for height
  if (!(0 <= floatval($_POST["height"])) && (floatval($_POST["height"]) <= 297.01)) returnError("Tipo de alto incorrecto");
  else $command.=" -y ".floatval($_POST["height"]);


  $scanfile = "scan_".str_pad($_SESSION["files_index"], 5, "0", STR_PAD_LEFT);
  $scanpath = "../outscan/".$_SESSION["dir"];
  $command.=" > $scanpath/$scanfile.tiff";
  system($command, $retval);
  if ($retval === 0) {
    $response["success"] = true;
    system("convert $scanpath/$scanfile.tiff $scanpath/$scanfile.png");

    $response["newfile"] = "$scanfile.png";
    $response["url"] = "$scanpath/$scanfile.png";
    array_push($_SESSION["files"], $scanfile);
    $_SESSION["files_index"] = $_SESSION["files_index"] + 1;
  } else $response["success"] = false;

  print(json_encode($response));
?>
