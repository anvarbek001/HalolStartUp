<?php

namespace App\Imports;

use App\Models\Party;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected int $party_id;
    public string $errorMessage;

    public function __construct(int $party_id)
    {
        $this->party_id = $party_id;
    }

    public function collection(Collection $rows)
    {
        $data = $rows
            ->filter(fn($row) => !empty($row['qrcode_number']))
            ->map(fn($row) => [
                'party_id'       => $this->party_id,
                'user_id' => Auth::user()->id,
                'qrcode_number'  => (int) trim((string) $row['qrcode_number']),
                'barcode_number' => !empty($row['barcode_number'])
                    ? (int) trim((string) $row['barcode_number'])
                    : null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ])->toArray();

        if (empty($data)) return;

        foreach (array_chunk($data, 1000) as $chunk) {
            Product::insertOrIgnore($chunk);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
