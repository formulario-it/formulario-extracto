
document.addEventListener('keydown', function(event) {
    if (event.key === 'F4') {
        event.preventDefault();
        const active = document.activeElement;
        if (!active || !active.name) return;

        const field = active.name;
        let file = '';
        if (field.includes('conductor')) file = 'TblEmpleados.csv';
        else if (field.includes('contratante')) file = 'TblEmpresas.csv';
        else if (field.includes('placa')) file = 'TblCajas.csv';
        else return;

        fetch('data/' + file)
            .then(response => response.text())
            .then(csv => {
                const rows = csv.trim().split('\n').map(r => r.split(','));
                const header = rows.shift();
                const results = prompt('Selecciona línea (número):\n' + rows.map((r, i) => `${i + 1}: ${r.join(' | ')}`).join('\n'));
                const index = parseInt(results) - 1;
                if (rows[index]) {
                    const values = rows[index];
                    if (file === 'TblEmpleados.csv') {
                        document.querySelector('[name="conductor1_nombre"]').value = values[0];
                        document.querySelector('[name="conductor1_cedula"]').value = values[1];
                        document.querySelector('[name="conductor1_licencia"]').value = values[2];
                        document.querySelector('[name="conductor1_vigencia"]').value = values[3];
                        document.querySelector('[name="conductor1_conduccion"]').value = values[4];
                    } else if (file === 'TblEmpresas.csv') {
                        document.querySelector('[name="contratante"]').value = values[0];
                        document.querySelector('[name="ccnit"]').value = values[1];
                        document.querySelector('[name="responsable_direccion"]').value = values[2];
                        document.querySelector('[name="responsable_telefono"]').value = values[3];
                    } else if (file === 'TblCajas.csv') {
                        document.querySelector('[name="placa"]').value = values[0];
                        document.querySelector('[name="modelo"]').value = values[1];
                        document.querySelector('[name="marca"]').value = values[2];
                        document.querySelector('[name="clase"]').value = values[3];
                        document.querySelector('[name="num_interno"]').value = values[4];
                        document.querySelector('[name="tarjeta_operacion"]').value = values[5];
                    }
                }
            });
    }
});
