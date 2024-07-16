<?php

namespace App\Http\Controllers\Admin;

use App\Models\DomesticZone;
use App\Http\Controllers\Controller;
use App\Enums\DomesticZone as DomesticZoneType;
use App\Models\DomesticZoneDeliveryFees;
use Exception;
use Illuminate\Support\Collection;

class DomesticZoneDeliveryFeesController extends Controller
{
    public function downloadDeliveryFeesDemo() {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=domestic-zone-deliver-feeses.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];
        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["weight_from_in_kilo", "weight_to_in_kilo", "delivery_fees_in_sar"]);
            fputcsv($file, ["0.5", "1", "25"]);
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function uploadSheet(DomesticZone $domestic) {
        if ($domestic->type == DomesticZoneType::INTERNATIONAL_TYPE) {
            $this->validateUploadRequest();
            $csv = request()->file('delivery_fees_sheet');
            $csvFile = fopen($csv->getRealPath(), "r");
            
            fgetcsv($csvFile); // just ignore the header
            
            try {
                $rows = $this->getValidatedRows(500, $csvFile);
                if ($rows->isNotEmpty()) {
                    $domestic->deliveryFeeses()->delete();
                    DomesticZoneDeliveryFees::insert(
                        $rows
                        ->map(function($r) use ($domestic) {
                            $r['domestic_zone_id'] = $domestic->id;
                            return $r;
                        })
                        ->toArray()
                    );
                }
            } catch (Exception $e) {
                return redirect()->back()->with("danger", $e->getMessage());
            }
        }
        return redirect()->back()->with("success", __('admin.delivery.domestic-zones.delivery-feeses.sheet-uploaded'));
    }

    private function validateUploadRequest() {
        $this->validate(
            request(),
            ['delivery_fees_sheet' => "required|max:2048|mimes:csv,txt"],
            [],
            ['delivery_fees_sheet' => __('admin.delivery.domestic-zones.delivery-feeses.delivery_fees_sheet')]
        );
    }

    private function getValidatedRows($maxRowsToProceed, $csvFile) : Collection {
        $rows = collect([]);
        $rowNumbers = 1;
        while (
            $rowNumbers <= $maxRowsToProceed &&
            ($line = fgetcsv($csvFile)) != false
        ) {
            $weightFrom = $line[0];
            $weightTo = $line[1];
            $delivetyFees = $line[2];

            if (!$this->isValidPositiveNumber($weightFrom))
                throw new Exception("Row #$rowNumbers: weight_from must be a valid kilo (0 accepted)");
            if (!$this->isValidPositiveNumber($weightTo)) 
                throw new Exception("Row #$rowNumbers: weight_to must be a valid kilo (0 accepted)");
            if (!$this->isValidPositiveNumber($delivetyFees))
                throw new Exception("Row #$rowNumbers: delivery_fees must be a valid money field (0 accepted)");

            $rows->push([
                "created_at" => now(),
                "updated_at" => now(),
                "weight_from" => $weightFrom,
                "weight_to" => $weightTo,
                "delivery_fees" => amountInHalala($delivetyFees),
            ]);
            $rowNumbers++;
        }
        return $rows;
    }

    private function isValidPositiveNumber($number) {
        return is_numeric($number) && $number >= 0;
    }
}
