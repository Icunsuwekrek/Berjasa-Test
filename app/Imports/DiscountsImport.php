<?php

namespace App\Imports;

use App\Models\Discount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DiscountsImport implements ToModel, WithHeadingRow
{
    private $filePath;
    private $worksheet;
    private $rowIndex = 2;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->initializeWorksheet();
    }

    private function initializeWorksheet()
    {
        $fullPath = Storage::path($this->filePath);
        $spreadsheet = IOFactory::load($fullPath);
        $this->worksheet = $spreadsheet->getActiveSheet();
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $evaluatedRow = $this->evaluateFormulas($row, $this->rowIndex++);

        foreach ($evaluatedRow as $key => &$value) {
            if (empty($value)) {
                $value = 0;
            }
        }
        
        $discountData = [
            'region' => $evaluatedRow['region'],
            'distributor' => $evaluatedRow['distributor'],
            'month' => $evaluatedRow['month'],
            'target_june' => $evaluatedRow['target_june'],
            'balance_incentive' => $evaluatedRow['balance_incentive_monthly'] ?? 0,
            'four_budget_promotion' => $evaluatedRow['4_budget_promotion'] ?? 0,
            'release_back' => $evaluatedRow['release_back_trading_term'] ?? 0,
            'trending_term' => $evaluatedRow['trading_term_deduction'] ?? 0,
            'TUB' => $evaluatedRow['4_tub_8l'] ?? 0,
            'balance_special' => $evaluatedRow['balance_special_pack'] ?? 0,
            'adjusment' => $evaluatedRow['adjustment_incentive'] ?? 0,
            'total_balance' => $evaluatedRow['total_balance_incentive'] ?? 0,
            'balance_hero' => $evaluatedRow['balance_hero_discount'] ?? 0,
            'adjusment_hero' => $evaluatedRow['adjustment_hero'] ?? 0,
            'return_allowance' => $evaluatedRow['return_allowance'] ?? 0
        ];

        Discount::create($discountData);

        Log::info('Discount record inserted', $discountData);
    }

    /**
     * Evaluate formulas in the given row.
     *
     * @param array $row
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $worksheet
     * @return array
     */
    private function evaluateFormulas(array $row, $rowIndex)
    {
        foreach ($row as $key => &$cell) {
            $cellCoordinate = $this->getCellCoordinate($key, $rowIndex);
            if ($cellCoordinate && strpos($cell, '=') === 0) {
                $cell = $this->worksheet->getCell($cellCoordinate)->getCalculatedValue();
            }
        }

        return $row;
    }


    /**
     * Convert your key to a cell coordinate.
     *
     * @param string $key
     * @return string|null
     */
    private function getCellCoordinate($key, $rowIndex)
    {
        $columnMapping = [
            'region' => 'A',
            'distributor' => 'B',
            'month' => 'C',
            'target_june' => 'D',
            'balance_incentive_monthly' => 'E',
            '4_budget_promotion' => 'F',
            'release_back_trading_term' => 'G',
            'trading_term_deduction' => 'H',
            '4_tub_8l' => 'I',
            'balance_special_pack' => 'J',
            'adjustment_incentive' => 'K',
            'total_balance_incentive' => 'L',
            'balance_hero_discount' => 'M',
            'adjustment_hero' => 'R',
            'return_allowance' => 'T'
        ];

        if (array_key_exists($key, $columnMapping)) {
            return $columnMapping[$key] . $rowIndex;
        }

        return null;
    }
}
