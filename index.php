
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario FUEC - Jardín</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    input, select { width: 300px; padding: 5px; margin-bottom: 10px; }
    label { font-weight: bold; display: block; margin-top: 15px; }
  </style>
</head>
<body>
  <h1>Formulario FUEC</h1>
  <form method="POST" action="enviar_fuec.php">
    <label for="conductor">Conductor (F4)</label>
    <input list="conductores" name="conductor" id="conductor" autocomplete="off">
    <datalist id="conductores">
      <?php cargarCSV('TblEmpleados.csv', 1); ?>
    </datalist>

    <label for="cedula">Cédula</label>
    <input type="text" name="cedula" id="cedula">

    <label for="licencia">Licencia</label>
    <input type="text" name="licencia" id="licencia">

    <label for="vigencia">Vigencia Licencia</label>
    <input type="date" name="vigencia" id="vigencia">

    <label for="contratante">Contratante (F4)</label>
    <input list="contratantes" name="contratante" id="contratante">
    <datalist id="contratantes">
      <?php cargarCSV('TblEmpresas.csv', 0); ?>
    </datalist>

    <label for="nit">C.C/NIT</label>
    <input type="text" name="nit" id="nit">

    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" id="direccion">

    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" id="telefono">

    <label for="placa">Placa (F4)</label>
    <input list="placas" name="placa" id="placa">
    <datalist id="placas">
      <?php cargarCSV('TblCajas.csv', 0); ?>
    </datalist>

    <label for="ruta_origen">Origen</label>
    <input type="text" name="ruta_origen" id="ruta_origen">

    <label for="ruta_destino">Destino</label>
    <input type="text" name="ruta_destino" id="ruta_destino">

    <br><br>
    <button type="submit">Generar FUEC</button>
  </form>
</body>
</html>

<?php
function cargarCSV($archivo, $columnaClave) {
  $ruta = __DIR__ . "/data/" . $archivo;
  if (!file_exists($ruta)) return;
  if (($handle = fopen($ruta, "r")) !== FALSE) {
    $encabezado = fgetcsv($handle); // Saltar encabezado
    while (($data = fgetcsv($handle)) !== FALSE) {
      $valor = $data[$columnaClave];
      echo "<option value='" . htmlspecialchars($valor, ENT_QUOTES) . "'></option>";
    }
    fclose($handle);
  }
}
?>
