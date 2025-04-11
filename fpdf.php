
<?php
define('FPDF_VERSION','1.81');
class FPDF {
    protected $page;
    protected $n;
    protected $offsets;
    protected $buffer;
    protected $pages;
    protected $state;
    protected $compress;
    protected $k;
    protected $fwPt;
    protected $fhPt;
    protected $wPt;
    protected $hPt;
    protected $curOrientation;
    protected $StdPageSizes;
    protected $DefOrientation;
    protected $CurPageSize;
    protected $DefPageSize;
    protected $PageInfo;
    protected $fonts;
    protected $FontFiles;
    protected $encodings;
    protected $cmaps;
    protected $FontFamily;
    protected $FontStyle;
    protected $underline;
    protected $CurrentFont;
    protected $FontSizePt;
    protected $FontSize;
    protected $DrawColor;
    protected $FillColor;
    protected $TextColor;
    protected $ColorFlag;
    protected $ws;
    protected $images;
    protected $PageLinks;
    protected $links;
    protected $AutoPageBreak;
    protected $PageBreakTrigger;
    protected $InHeader;
    protected $InFooter;
    protected $ZoomMode;
    protected $LayoutMode;
    protected $title;
    protected $subject;
    protected $author;
    protected $keywords;
    protected $creator;
    protected $AliasNbPages;
    protected $PDFVersion;

    function __construct($orientation='P', $unit='mm', $size='A4') {
        $this->pages = array();
        $this->AddPage();
    }

    function AddPage($orientation='', $size='') {
        $this->page = count($this->pages)+1;
        $this->pages[$this->page] = '';
    }

    function SetFont($family, $style='', $size=0) {}
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
        echo $txt."\n";
    }
    function Ln($h = null) {}
    function Output($name='', $dest='') {
        echo "PDF generado correctamente";
    }
}
?>
