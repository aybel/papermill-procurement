<?php

namespace App\Services\Reports;

use App\Services\Reports\Base\BasePdfReport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Repositories\SupplierRepositoryInterface;

class SuppliersReportGenerator implements ReportGeneratorInterface
{
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function generate(array $filters, string $format)
    {
        $data = $this->getData($filters);
        if ($format === 'excel') {
            return $this->generateExcel($data);
        } elseif ($format === 'pdf') {
            return $this->generatePdf($data);
        }
        throw new \InvalidArgumentException('Formato no soportado');
    }

    private function getData(array $filters)
    {
        // Aplicar filtros si es necesario
        return $this->supplierRepository->getAll($filters);
    }

    protected function generateExcel($suppliers)
    {
        // Implementación básica usando Laravel Excel
        $export = new class($suppliers) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $suppliers;
            public function __construct($suppliers)
            {
                $this->suppliers = $suppliers;
            }
            public function collection()
            {
                return collect($this->suppliers);
            }
            public function headings(): array
            {
                return ['ID', 'Nombre', 'RFC', 'Email'];
            }
        };
        $filename = 'suppliers_report_' . now()->format('Ymd_His') . '.xlsx';
        Excel::store($export, $filename, 'local');
        return Storage::path($filename);
    }

    protected function generatePdf($suppliers)
    {
        // Usar la clase base personalizada
        $pdf = new BasePdfReport('L', 'mm', 'A4');
        // Definir encabezados y configuración de tabla ANTES de AddPage
        $pdf->arrayColumns = ['ID', 'Código', 'Nombre', 'RFC', 'Tipo', 'Estatus', 'Moneda', 'Límite', 'Score'];
        $pdf->arrayWidths = [12, 22, 65, 30, 30, 25, 25, 35, 40];
        $pdf->heightRow = 8;
        $widths = $pdf->arrayWidths;
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Papermill-ERP');
        $pdf->SetTitle('TCPDF Example 003');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_HEADER);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Contenido del reporte
        $pdf->AddPage();
        // Ya no es necesario setear Y manualmente, el Header y drawTableHeader lo controlan
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetFillColor(230, 230, 230);
        // Datos
        foreach ($suppliers as $s) {
            $pdf->Row([
                $s->id,
                $s->code ?? '',
                $s->name ?? '',
                $s->tax_id ?? '',
                optional($s->supplierType)->name ?? '',
                optional($s->supplierStatus)->name ?? '',
                optional($s->currency)->code ?? '',
                $s->credit_limit ?? '',
                $s->overall_score ?? ''
            ], $widths, 8);
        }
        $filename = storage_path('app/suppliers_report_' . now()->format('Ymd_His') . '.pdf');
        $pdf->Output($filename, 'F');
        // Leer el contenido antes de borrar
        $content = file_get_contents($filename);
        // Eliminar el archivo generado
        @unlink($filename);
        // Guardar el archivo temporalmente para la respuesta (puedes devolver el contenido o un stream)
        $tmpPath = tempnam(sys_get_temp_dir(), 'report_') . '.pdf';
        file_put_contents($tmpPath, $content);
        return $tmpPath;
    }
}
