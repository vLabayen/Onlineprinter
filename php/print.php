<?php
  $command="lp -d Deskjet_3520";
  $output="Imprimiendo: </br>";

  //Check for file
  if ($_FILES["file"]["size"] == 0) die("No se ha enviado ningun fichero");
  else $output.= " - Archivo : ".$_FILES["file"]["name"]."</br>";

  //Check for colormode
  if (!in_array($_POST["colormode"], ["RGB", "CMYGray", "KGray"])) die("Tipo de color incorrecto");
  else {
    $output.= " - Tipo de color : ".(
      $_POST["colormode"] == "RGB" ? "Color (RGB)" : (
      $_POST["colormode"] == "CMYGray" ? "Color real (CMYGray)" : "Blanco y negro (KGray)"
    ))."</br>";
    $command.= " -o ColorMode=".$_POST["colormode"];
  }

  //Check for print quality
  if (!in_array($_POST["printq"], ["Normal", "FastDraft", "Best", "Photo"])) die("Calidad de impresión incorrecta");
  else {
    $output.= " - Calidad de impresión : ".(
      $_POST["printq"] == "Normal" ? "Normal" : (
      $_POST["printq"] == "FastDraft" ? "Impresión rápida" : (
      $_POST["printq"] == "Best" ? "Mejor calidad" : "Fotografía"
    )))."</br>";
    $command.= " -o OutputMode=".$_POST["printq"];
  }

  //Check for rotation
  if (!in_array($_POST["rotation"], [3,4,5,6])) die("Rotación incorrecta");
  else {
    $output.= " - Rotación : ".(
      $_POST["rotation"] == 3 ? "0º" : (
      $_POST["rotation"] == 4 ? "90º" : (
      $_POST["rotation"] == 5 ? "270º" : "180º"
    )))."</br>";
    $command.= " -o orientation-requested=".$_POST["rotation"];
  }

  //Check for scale
  if (isset($_POST["scale"])) {
    $output.= " - Escalado : Si </br>";
    $command.= " -o fit-to-page";
  } else $output.=" - Escalado : No </br>";

  //Check for sides
  if (!in_array($_POST["sides"], ["one-sided", "two-sided-long-edge", "two-sided-short-edge"])) die("Configuración incorrecta de caras por hoja");
  else {
    $output.= " - Caras por hoja : ".(
      $_POST["sides"] == "one-sided" ? "1" : (
      $_POST["sides"] == "two-sided-long-edge" ? "2 (Eje largo)" : "2 (Eje corto)"
    ))."</br>";
    $command.= " -o sides=".$_POST["sides"];
  }

  //Check for page ranges
  if (strlen($_POST["pageranges"]) != 0) {
    $_POST["pageranges"] = str_replace(" ", "", $_POST["pageranges"]);
    $frags = explode(",", $_POST["pageranges"]);
    foreach ($frags as $v) {
      if (ctype_digit($v)) continue;
      $frags2 = explode("-", $v);
      if (count($frags2) != 2) die("Formato de páginas incorrecto en ".$v);
      if (!(ctype_digit($frags2[0]) && ctype_digit($frags2[1]))) die("Formato de páginas incorrecto en ".$v);
      if (intval($frags2[0]) > intval($frags2[1])) die("Formato de páginas incorrecto en ".$v);
    }
    $output.= " - Páginas seleccionadas : ".$_POST["pageranges"]."</br>";
    $command.= " -o page-ranges=".$_POST["pageranges"];
  } else $output.= " - Páginas seleccionadas : Todas </br>";

  //Check for multiples pages
  if (!in_array($_POST["numberup"], [1,2,4,6,9,16])) die("Configuración de páginas por hoja incorrecta");
  else {
    $output.= " - Páginas por hoja : ".$_POST["numberup"]."</br>";
    $command.= " -o number-up=".$_POST["numberup"];
  }

  print($output);

  $command.= " ".$_FILES["file"]["tmp_name"];
  print("</br></br>Command : $command");

  $a = system($command);
?>
