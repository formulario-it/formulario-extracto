
<?php
function cargar_csv($archivo) {
    $datos = [];
    if (($gestor = fopen($archivo, "r")) !== FALSE) {
        $encabezados = fgetcsv($gestor);
        while (($linea = fgetcsv($gestor)) !== FALSE) {
            $fila = [];
            foreach ($encabezados as $i => $col) {
                $fila[$col] = $linea[$i] ?? "";
            }
            $datos[] = $fila;
        }
        fclose($gestor);
    }
    return $datos;
}
$extractos = cargar_csv("TblExtracto_202504150938.csv");
$empleados = cargar_csv("TblEmpleados_202504150938.csv");
$empresas = cargar_csv("TblEmpresas_202504150938.csv");
$terceros = cargar_csv("TblTerceros_202504150938.csv");
$cajas = cargar_csv("TblCajas_202504150944.csv");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario FUEC</title>
</head>
<body>
    <form action="enviar_fuec.php" method="post">
        <label for="contrato">Selecciona un contrato:</label>
        <select name="contrato" id="contrato" onchange="this.form.submit()">
            <option value="">-- Selecciona --</option>
            <?php foreach ($extractos as $ex): ?>
                <option value="<?= htmlspecialchars(json_encode($ex)) ?>">
                    <?= $ex['IdExtracto'] ?? 'Contrato sin ID' ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</body>
</html>
