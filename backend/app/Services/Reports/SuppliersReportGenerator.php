<?php

namespace App\Services\Reports;

use TCPDF;
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
        \Log::info('SuppliersReportGenerator: constructor ejecutado');
    }

    public function generate(array $filters, string $format)
    {
        $data = $this->getData($filters);
        \Log::info('SuppliersReportGenerator: total proveedores', ['count' => count($data)]);
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
        // Implementación básica usando TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $html = '<h1>Reporte de Proveedores</h1><table border="1" cellpadding="4"><tr><th>ID</th><th>Nombre</th><th>RFC</th><th>Email</th></tr>';
        foreach ($suppliers as $s) {
            $html .= '<tr><td>' . $s->id . '</td><td>' . $s->name . '</td><td>' . $s->rfc . '</td><td>' . $s->email . '</td></tr>';
        }
        $html .= '</table>';
        \Log::info('SuppliersReportGenerator: HTML PDF', ['html' => $html]);
        $pdf->writeHTML($html, true, false, true, false, '');
        $filename = storage_path('app/suppliers_report_' . now()->format('Ymd_His') . '.pdf');
        $pdf->Output($filename, 'F');
        return $filename;
    }
}
