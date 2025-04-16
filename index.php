<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$archivo = __DIR__ . "/data/conductores.csv";
if (!file_exists($archivo)) {
    die("No se encontró conductores.csv");
}
$datos = array_map("str_getcsv", file($archivo));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario FUEC</title>
</head>
<body>
  <h1>Conductores (Prueba CSV)</h1>
  <table border="1">
  <?php foreach ($datos as $fila): ?>
    <tr>
    <?php foreach ($fila as $celda): ?>
      <td><?= htmlspecialchars($celda) ?></td>
    <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
  </table>
</body>
</html>