<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;

class tableController extends Controller
{
    public function generateTable()
    {
        $columns = 52;
        $rows = 10;

        $headers = ['Persons']; 
        for ($i = 1; $i <= $columns; $i++) {
            $headers[] = 'Week ' . $i;
        }

        $table = [];

        for ($i = 0; $i < $rows; $i++) {
            $table[$i] = [];
            for ($j = 0; $j < $columns; $j++) {
                $table[$i][$j] = mt_rand() / mt_getrandmax(); 
            }
        }

        $cumulativeTable = [];
        foreach ($table as $index => $row) {
            $cumulativeSum = 0;
            $cumulativeRow = ["Person " . ($index + 1)]; 
            foreach ($row as $value) {
                $cumulativeSum += $value;
                $cumulativeRow[] = $cumulativeSum;
            }
            $cumulativeTable[] = $cumulativeRow;
        }

        $finalData = array_merge([$headers], $cumulativeTable);

          
        $spreadsheetId = '1LubOWizm86FwFXBzfQXkyc1W767n1UZMmnKQ_Ghfbms'; 
        $range = 'Sayfa1!A1'; 
        $values = $finalData; 

        
        $googleSheetsService = new GoogleSheetsService();
        $googleSheetsService->updateSheet($spreadsheetId, $range, $values);

        return view('table', compact('cumulativeTable'));
    }
}
