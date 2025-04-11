<?php
// Versión simple de FPDF con soporte de fuentes integradas
class FPDF {
    // solo un esqueleto de demostración para evitar errores de inclusión
    var $page = 0;
    var $pages = array();

    function AddPage() {
        $this->page++;
        $this->pages[$this->page] = '';
    }

    function SetFont($family, $style = '', $size = null) {
        // fuentes integradas (arial, times, courier)
    }

    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        echo "Cell: $txt
";
    }

    function Output($name = '', $dest = '') {
        echo "PDF generado (simulado)";
    }

    function Ln($h = null) {}
}
?>
