<?php
$data = array_map('str_getcsv', file('TblExtracto.csv'));
$headers = array_map('trim', array_shift($data));
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario FUEC con selección dinámica</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    label { display: block; margin-top: 10px; }
    input, select { width: 100%; padding: 8px; }
    button { margin-top: 20px; padding: 10px 20px; }
    .form-container { max-width: 800px; margin: auto; }
  </style>
  <script>
    const headers = <?php echo json_encode($headers); ?>;
    const registros = <?php echo json_encode($data); ?>;

    function cargarRegistro(index) {
      const fila = registros[index];
      headers.forEach((campo, i) => {
        const input = document.getElementsByName(campo)[0];
        if (input) input.value = fila[i];
      });
    }

    window.onload = () => {
      cargarRegistro(0); // cargar el primer registro al iniciar
    }
  </script>
</head>
<body>

<div class="form-container">
  <h2>Selecciona un contrato</h2>
  <select onchange="cargarRegistro(this.value)">
    <?php foreach ($data as $i => $row): ?>
      <option value="<?php echo $i; ?>">
        <?php echo "Contrato: " . htmlspecialchars($row[0]) . " - " . htmlspecialchars($row[1]); ?>
      </option>
    <?php endforeach; ?>
  </select>

  <h2>Formulario FUEC</h2>
  <form action="enviar_fuec.php" method="post">
    <?php foreach ($headers as $campo): ?>
      <label for="<?php echo $campo; ?>"><?php echo $campo; ?></label>
      <input type="text" name="<?php echo $campo; ?>" id="<?php echo $campo; ?>" required>
    <?php endforeach; ?>
    <button type="submit">Generar y Enviar FUEC</button>
  </form>
</div>

</body>
</html>
