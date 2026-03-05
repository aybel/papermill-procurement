<?php

namespace App\DTOs\Input\BudgetRequest;

class BudgetRequestSearchDTO
{
    public function __construct(
        public readonly ?string $search,
        public readonly int $perPage,
        public readonly ?int $departmentId,
        public readonly ?int $statusId,
        public readonly ?int $year,
        public readonly string $sortBy,
        public readonly string $sortDir,
    ) {
    }

    public static function fromValidated(array $validated): self
    {
        return new self(
            search: isset($validated['q']) ? trim((string) $validated['q']) : null,
            perPage: (int) ($validated['per_page'] ?? 15),
            departmentId: isset($validated['department_id']) ? (int) $validated['department_id'] : null,
            statusId: isset($validated['status_id']) ? (int) $validated['status_id'] : null,
            year: isset($validated['year']) ? (int) $validated['year'] : null,
            sortBy: (string) ($validated['sort_by'] ?? 'created_at'),
            sortDir: (string) ($validated['sort_dir'] ?? 'desc'),
        );
    }
}
