<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para cargar CSV en array
function cargar_csv($nombre_archivo) {
    $ruta = __DIR__ . "/data/" . $nombre_archivo;
    return file_exists($ruta) ? array_map("str_getcsv", file($ruta)) : [];
}

$conductores = cargar_csv("conductores.csv");
$contratantes = cargar_csv("contratantes.csv");
$vehiculos = cargar_csv("vehiculos.csv");
$rutas = cargar_csv("rutas.csv");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario FUEC</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    label { display: block; margin-top: 10px; }
    select, input { width: 300px; padding: 5px; }
  </style>
</head>
<body>
  <h1>Formulario FUEC</h1>
  <form method="POST" action="enviar_fuec.php">
    <!-- Conductor -->
    <label>Conductor</label>
    <select name="conductor">
      <?php foreach ($conductores as $c): ?>
        <option value="<?= $c[0] ?>"><?= $c[1] ?> - <?= $c[0] ?></option>
      <?php endforeach; ?>
    </select>

    <label>Licencia</label>
    <input type="text" name="licencia" value="<?= $conductores[0][2] ?? '' ?>">

    <label>Vigencia Licencia</label>
    <input type="date" name="vigencia" value="<?= $conductores[0][3] ?? '' ?>">

    <!-- Contratante -->
    <label>Contratante</label>
    <select name="contratante">
      <?php foreach ($contratantes as $e): ?>
        <option value="<?= $e[1] ?>"><?= $e[0] ?></option>
      <?php endforeach; ?>
    </select>

    <label>NIT</label>
    <input type="text" name="nit" value="<?= $contratantes[0][1] ?? '' ?>">

    <label>Dirección</label>
    <input type="text" name="direccion" value="<?= $contratantes[0][2] ?? '' ?>">

    <label>Teléfono</label>
    <input type="text" name="telefono" value="<?= $contratantes[0][3] ?? '' ?>">

    <!-- Vehículo -->
    <label>Vehículo (Placa)</label>
    <select name="placa">
      <?php foreach ($vehiculos as $v): ?>
        <option value="<?= $v[0] ?>"><?= $v[0] ?> - <?= $v[1] ?></option>
      <?php endforeach; ?>
    </select>

    <label>Marca</label>
    <input type="text" name="marca" value="<?= $vehiculos[0][1] ?? '' ?>">

    <label>Clase</label>
    <input type="text" name="clase" value="<?= $vehiculos[0][2] ?? '' ?>">

    <label>Modelo</label>
    <input type="text" name="modelo" value="<?= $vehiculos[0][3] ?? '' ?>">

    <label>Número Interno</label>
    <input type="text" name="interno" value="<?= $vehiculos[0][4] ?? '' ?>">

    <label>Tarjeta Operación</label>
    <input type="text" name="tarjeta" value="<?= $vehiculos[0][5] ?? '' ?>">

    <!-- Ruta -->
    <label>Origen</label>
    <input type="text" name="origen" value="<?= $rutas[0][0] ?? '' ?>">

    <label>Destino</label>
    <input type="text" name="destino" value="<?= $rutas[0][1] ?? '' ?>">

    <!-- Botón -->
    <br><br>
    <button type="submit">Generar FUEC</button>
  </form>
</body>
</html>