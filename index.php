<?php
session_start();
if (isset($_SESSION["dir"])) system("rm -r outscan/".$_SESSION["dir"]);
unset($_SESSION["dir"]);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script src="js/sliders.js"></script>
  <script src="js/scan.js"></script>
  <script src="js/download.js"></script>
</head>
<body style="padding: 15px;">
  <div class="row">
    <div class="column">
      <h4>Selecciona el archivo a imprimir y las opciones deseadas</h2>
      <form enctype="multipart/form-data" method="post" action="php/print.php">
        <label for="file">Archivo a imprimir</label></br>
        <input id="file" name="file" type="file"/></br></br>

        <label for="colormode">Tipo de color</label></br>
        <select id="colormode" name="colormode">
          <option value="RGB">A color (RGB)</option>
          <option value="CMYGray">A color real (CMYGray)</option>
          <option value="KGray">Blanco y negro (KGray)</option>
        </select></br></br>

        <label for="printq">Calidad de impresión</label></br>
        <select id="printq" name="printq">
          <option value="Normal">Normal</option>
          <option value="FastDraft">Impresión rápida</option>
          <option value="Best">Mejor calidad</option>
          <option value="Photo">Fotografía</option>
        </select></br></br>

        <label for="rotation">Rotación</label></br>
        <select id="rotation" name="rotation">
          <option value=3>No rotar (0º)</option>
          <option value=4>Apaisado (90º)</option>
          <option value=6>invertido (180º)</option>
          <option value=5>Apaisado invertido (270º)</option>
        </select></br></br>

        <label for="scale">Escalar documento</label></br>
        <input id="scale" type="checkbox" name="scale" value="fit-to-page"></br></br>

        <label for="sides">Caras por hoja</label></br>
        <select id="sides" name="sides">
          <option value="one-sided">A una cara</option>
          <option value="two-sided-long-edge">Dos caras por el lado largo</option>
          <option value="two-sided-short-edge">Dos caras por el lado corto</option>
        </select></br></br>

        <label for="pageranges">Páginas a imprimir</label></br>
        <input id="pageranges" type="text" placeholder="1-4,7,9-12" name="pageranges"></br></br>

        <label for="numberup">Paginas por hoja</label></br>
        <select id="numberup" name="numberup">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="4">4</option>
          <option value="6">6</option>
          <option value="9">9</option>
          <option value="16">16</option>
        </select></br></br>

        <input id="print" type="submit" value="Imprimir"/>
      </form>
    </div>

    <div class="column">
      <h4>Selecciona la configuración para escanear</h2>
      <form enctype="multipart/form-data" id="scanform" method="post" action="php/scan.php">
        <label for="scolormode">Tipo de color</label></br>
        <select id="scolormode" name="scolormode">
          <option value="Color">A color (RGB)</option>
          <option value="Gray">Escala de grises</option>
          <option value="Lineart">Blanco y negro</option>
        </select></br></br>

        <label for="scanres">Resolución en dpi</label></br>
        <select id="scanres" name="scanres">
          <option value=75>75</option>
          <option value=100>100</option>
          <option value=200>200</option>
          <option value=300>300</option>
          <option value=600>600</option>
          <option value=1200>1200</option>
        </select></br></br>

        <label for="brightness">Nivel de brillo : </label> <span id="selected_brightness">1000</span></br>
	<input type="button" value="-" onClick="subtract_one('brightness')">
	0 <input type="range" min="0" max="2000" step="1" id="brightness" name="brightness" value=1000 onchange="show_value('brightness')"> 2000
	<input type="button" value="+" onClick="add_one('brightness')"></br></br>

	<label for="contrast">Nivel de contraste : </label> <span id="selected_contrast">1000</span></br>
	<input type="button" value="-" onClick="subtract_one('contrast')">
	0 <input type="range" min="0" max="2000" step="1" id="contrast" name="contrast" value=1000 onchange="show_value('contrast')"> 2000
	<input type="button" value="+" onClick="add_one('contrast')"></br></br>

	<label for="width">Anchura del escaner : </label> <span id="selected_width">215.9</span></br>
	<input type="button" value="-" onClick="subtract_one('width', scale=0.1)">
	0 <input type="range" min="0.0" max="215.9" step="0.1" id="width" name="width" value=215.9 onchange="show_value('width')"> 215.9
	<input type="button" value="+" onClick="add_one('width', scale=0.1)"></br></br>

	<label for="height">Altura del escaner : </label> <span id="selected_height">297.01</span></br>
	<input type="button" value="-" onClick="subtract_one('height', scale=0.01)">
	0 <input type="range" min="0.0" max="297.01" step="0.01" id="height" name="height" value=297.01 onchange="show_value('height')"> 297.01
	<input type="button" value="+" onClick="add_one('height', scale=0.01)"></br></br>

        <input id="scan" type="button" value="Escanear" onClick="postForm('scanform', 'php/scan.php')"/> <img id="scanning" src="src/loading.gif" style="visibility : hidden"/>
      </form> </br>
      <div id="scan_table"></div>
      <input type="button" id="download" onClick="downloadPDF()" value="Descargar PDF" disabled/>
    </div>
  </div>
</body>
</html>
