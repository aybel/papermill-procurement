<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportExportRequest;
use App\Services\Reports\ReportService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function export(ReportExportRequest $request): BinaryFileResponse
    {
        $type = $request->validated('type');
        $format = $request->validated('format');
        $filters = $request->validated('filters') ?? [];
        $filePath = $this->reportService->generate($type, $format, $filters);
        $filename = basename($filePath);
        $mime = $format === 'excel' ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' : 'application/pdf';
        return response()->download($filePath, $filename, ['Content-Type' => $mime]);
    }
}
