
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.createElement("div");
    modal.id = "f4Modal";
    modal.style.position = "fixed";
    modal.style.top = "0";
    modal.style.left = "0";
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.background = "rgba(0,0,0,0.6)";
    modal.style.display = "none";
    modal.style.zIndex = "1000";
    modal.innerHTML = '<div style="background:white;padding:20px;margin:10% auto;width:80%;max-height:70%;overflow:auto;"><h3>Selecciona un registro</h3><table id="f4Table" border="1" style="width:100%;border-collapse:collapse;"></table><br><button onclick="document.getElementById(\'f4Modal\').style.display=\'none\'">Cerrar</button></div>';
    document.body.appendChild(modal);

    let currentField = "";

    document.addEventListener("keydown", function (e) {
        if (e.key === "F4") {
            e.preventDefault();
            const active = document.activeElement;
            currentField = active.name;

            let file = "";
            if (currentField.includes("conductor")) file = "TblEmpleados.csv";
            else if (currentField.includes("contratante")) file = "TblEmpresas.csv";
            else if (currentField.includes("placa")) file = "TblCajas.csv";
            else return;

            fetch("data/" + file)
                .then(res => res.text())
                .then(csv => {
                    const lines = csv.trim().split("\n");
                    const headers = lines[0].split(",");
                    const rows = lines.slice(1).map(line => line.split(","));
                    const table = document.getElementById("f4Table");
                    table.innerHTML = "";
                    const thead = table.insertRow();
                    headers.forEach(h => {
                        const th = document.createElement("th");
                        th.textContent = h;
                        thead.appendChild(th);
                    });

                    rows.forEach((row, i) => {
                        const tr = table.insertRow();
                        row.forEach(cell => {
                            const td = tr.insertCell();
                            td.textContent = cell;
                        });
                        tr.addEventListener("click", () => {
                            if (file === "TblEmpleados.csv") {
                                document.querySelector('[name="conductor1_nombre"]').value = row[0];
                                document.querySelector('[name="conductor1_cedula"]').value = row[1];
                                document.querySelector('[name="conductor1_licencia"]').value = row[2];
                                document.querySelector('[name="conductor1_vigencia"]').value = row[3];
                                document.querySelector('[name="conductor1_conduccion"]').value = row[4];
                            } else if (file === "TblEmpresas.csv") {
                                document.querySelector('[name="contratante"]').value = row[0];
                                document.querySelector('[name="ccnit"]').value = row[1];
                                document.querySelector('[name="responsable_direccion"]').value = row[2];
                                document.querySelector('[name="responsable_telefono"]').value = row[3];
                            } else if (file === "TblCajas.csv") {
                                document.querySelector('[name="placa"]').value = row[0];
                                document.querySelector('[name="modelo"]').value = row[1];
                                document.querySelector('[name="marca"]').value = row[2];
                                document.querySelector('[name="clase"]').value = row[3];
                                document.querySelector('[name="num_interno"]').value = row[4];
                                document.querySelector('[name="tarjeta_operacion"]').value = row[5];
                            }
                            modal.style.display = "none";
                        });
                    });

                    modal.style.display = "block";
                });
        }
    });
});
