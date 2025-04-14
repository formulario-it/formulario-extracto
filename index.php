<?php
$data = array_map('str_getcsv', file('TblExtracto.csv'));
$headers = array_map('trim', array_shift($data));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario FUEC</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form input, form select { width: 100%; padding: 6px; margin: 4px 0; }
        form button { padding: 10px 15px; }
        .form-container { max-width: 700px; margin: auto; }
    </style>
    <script>
        const registros = <?php echo json_encode($data); ?>;
        const headers = <?php echo json_encode($headers); ?>;

        function cargarRegistro(index) {
            const fila = registros[index];
            headers.forEach((campo, i) => {
                const input = document.getElementsByName(campo)[0];
                if (input) input.value = fila[i];
            });
        }
    </script>
</head>
<body>

<h2>Registros disponibles</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <?php foreach ($headers as $h): ?>
                <th><?php echo htmlspecialchars($h); ?></th>
            <?php endforeach; ?>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $i => $row): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <?php foreach ($row as $value): ?>
                    <td><?php echo htmlspecialchars($value); ?></td>
                <?php endforeach; ?>
                <td><button onclick="cargarRegistro(<?php echo $i; ?>)">Cargar</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-container">
    <h2>Formulario FUEC</h2>
    <form action="enviar_fuec.php" method="post">
        <?php foreach ($headers as $campo): ?>
            <label><?php echo htmlspecialchars($campo); ?></label>
            <input type="text" name="<?php echo $campo; ?>" required>
        <?php endforeach; ?>
        <br>
        <button type="submit">Generar y Enviar PDF</button>
    </form>
</div>

</body>
</html>
