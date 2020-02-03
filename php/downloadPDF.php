<?php
  session_start();

  if (!isset($_SESSION['dir'])) die();
  $path = "../outscan/".$_SESSION["dir"];

  system("tiffcp $path/*.tiff $path/hop.tiff");
  system("tiff2pdf -o $path/hop.pdf $path/hop.tiff");

  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=scan.pdf");
  readfile("$path/hop.pdf");

  system("rm $path/hop*");
?>
