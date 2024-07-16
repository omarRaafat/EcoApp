<?php

namespace App\Traits;

use \Spatie\SimpleExcel\SimpleExcelWriter;

trait ExportToExcel
{
    public  function exportToExcel($fileName, $data = [], $storeToServer = false, $filePath = '')
    {
        $excel = $storeToServer ?
            SimpleExcelWriter::create($filePath . $fileName . '.xlsx') :
            SimpleExcelWriter::streamDownload($fileName . '.xlsx');

        $excel->addRows($data);
        $excel->siz

        $storeToServer ?
            $excel :
            $excel->toBrowser();
    }
}
