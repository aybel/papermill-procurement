<?php

namespace App\Services\Reports\Base;

use TCPDF;

class BasePdfReport extends TCPDF
{
    public $arrayColumns = [];
    public $arrayWidths = [];
    public $heightRow = 8;

    public function __construct(
        $orientation = PDF_PAGE_ORIENTATION,
        $unit = PDF_UNIT,
        $format = PDF_PAGE_FORMAT,
        $unicode = true,
        $encoding = 'UTF-8',
        $diskcache = false
    ) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
    }
    // Header común para todos los reportes
    public function Header()
    {
        $imagePath = public_path('images/reports/logo.png');
        if (file_exists($imagePath)) {
            // Mueve el logo a la derecha (X = ancho de página - margen derecho - ancho del logo)
            $logoWidth = 30;
            $x = $this->getPageWidth() - $this->rMargin - $logoWidth;
            $this->Image($imagePath, $x, 10, $logoWidth); // X, Y, Width
        }
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Papermill', 0, 1, 'C');

        if (!empty($this->arrayColumns)) {
            $this->Ln(27);
            $this->drawTableHeader($this->arrayColumns, $this->arrayWidths, $this->heightRow);
            // Guardar la posición Y justo después del encabezado de la tabla
            $this->yAfterHeader = $this->GetY();
        }
    }

    /**
     * Dibuja el encabezado de una tabla en la posición actual.
     * @param array $columns Array de nombres de columnas
     * @param array $widths Array de anchos de columnas
     * @param int|float $height Alto de las celdas
     */
    public function drawTableHeader(array $columns, array $widths, $height = 8)
    {
        $this->SetFont('helvetica', 'B', 11);
        $this->SetFillColor(230, 230, 230);
        foreach ($columns as $i => $col) {
            $w = $widths[$i] ?? 20;
            $this->MultiCell($w, $height, $col, 1, 'C', 1, 0);
        }
        $this->Ln();
        $this->SetFont('helvetica', '', 10);
    }
    /**
     * Dibuja una fila de tabla con celdas de igual altura, soportando anchos variables.
     * @param array $data Valores de la fila
     * @param array $widths Anchos de cada columna
     * @param float $rowHeight Altura base de la celda (por línea)
     * @param int $border Borde de la celda (1 o 0)
     * @param string $align Alineación del texto ('L', 'C', 'R')
     */
    public function Row(array $data, array $widths, $rowHeight = 8, $border = 1, $align = 'C')
    {
        // Calcular cuántas líneas ocupa la celda más alta
        $maxLines = 0;
        foreach ($data as $i => $cell) {
            $w = $widths[$i] ?? 20;
            $maxLines = max($maxLines, $this->getNumLines($cell, $w));
        }
        $finalHeight = $maxLines * $rowHeight;
        $pageHeight = $this->getPageHeight();
        $topMargin = $this->tMargin;
        $bottomMargin = $this->bMargin;
        $currentY = $this->GetY();
        // Si es la primera página y estamos justo después del header, ajustar Y automáticamente
        if ($this->PageNo() === 1 && property_exists($this, 'yAfterHeader') && $currentY < $this->yAfterHeader) {
            $this->SetY($this->yAfterHeader);
            $currentY = $this->GetY();
        }
        // Checar si hay espacio suficiente en la página actual (considerando márgenes)
        if (($currentY + $finalHeight + $bottomMargin) > ($pageHeight)) {
            $this->AddPage();
            // Después de AddPage, si existe yAfterHeader, ajustar Y para no sobreponer header
            if (property_exists($this, 'yAfterHeader')) {
                $this->SetY($this->yAfterHeader);
                $currentY = $this->GetY();
            }
        }
        // Si la fila es tan grande que no cabe ni en una página, ajustar la altura para que no se salga
        if ($finalHeight > ($pageHeight - $topMargin - $bottomMargin)) {
            $this->SetY($topMargin);
            $finalHeight = $pageHeight - $topMargin - $bottomMargin;
        }
        // Dibujar cada celda
        foreach ($data as $i => $cell) {
            $w = $widths[$i] ?? 20;
            $this->MultiCell($w, $finalHeight, $cell, $border, $align, 0, 0, '', '', true, 0, false);
        }
        $this->Ln();
    }

    /** Footer común para todos los reportes */
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}
