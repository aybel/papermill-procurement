<?php

namespace App\Services\Reports;

interface ReportGeneratorInterface
{
    /**
     * Genera el reporte y retorna la ruta o contenido del archivo.
     *
     * @param array $filters
     * @param string $format
     * @return mixed
     */
    public function generate(array $filters, string $format);
}
