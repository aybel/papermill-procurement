<?php

namespace App\Services\Reports;

use InvalidArgumentException;

class ReportService
{
    protected array $generators;

    public function __construct(array $generators = [])
    {
        $this->generators = $generators;
    }

    public function registerGenerator(string $type, ReportGeneratorInterface $generator)
    {
        $this->generators[$type] = $generator;
    }

    public function generate(string $type, string $format, array $filters = [])
    {
        if (!isset($this->generators[$type])) {
            throw new InvalidArgumentException("Tipo de reporte no soportado: $type");
        }
        return $this->generators[$type]->generate($filters, $format);
    }
}
