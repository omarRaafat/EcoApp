<?php

namespace App\Console\Commands;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportSplCountiresCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spl:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command import spl - shipping company - countries and cities';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = SimpleExcelReader::create(storage_path("international-cities.xlsx"))->getRows();
        $citiesGroupByCountryID = $rows->groupBy("CountryID");
        foreach ($citiesGroupByCountryID as $row) {
            if(!isset($row[0]["CountryID"])) {
                Log::warning("SPL_IMPORT_WARNING:Spl country code not exists for " . $row[0]["CountryNameAr"]);
                $this->info("SPL_IMPORT_WARNING:Spl country code not exists for " . $row[0]["CountryNameAr"]);
                continue;
            }

            $splCountryID = $row[0]["CountryID"];

            $country = Country::where("spl_id", $splCountryID)->first();

            if(!$country) {
                Log::warning("SPL_IMPORT_WARNING: No country with this spl id exists in our database " . $row[0]["CountryID"]);
                $this->info("SPL_IMPORT_WARNING: No country with this spl id exists in our database " . $row[0]["CountryID"]);
                continue;
            }

            if(!$country->is_national) {
                Log::warning("SPL_IMPORT_WARNING: This country has spl_id but not  support international shipping in our system" . $row[0]["CountryID"]);
                $this->info("SPL_IMPORT_WARNING: This country has spl_id but not  support international shipping in our system" . $row[0]["CountryID"]);
                continue;
            }

            if(!Area::where("name->en", $row[0]["CountryNameEn"])->first()) {
                $area = $country->areas()->create([
                    "name" => [
                        "en" => $row["CountryNameEn"],
                        "ar" => $row["CountryNameAr"]
                    ],
                    "is_active" => true,
                ]);
            }

            foreach ($row as $splCity) {
                $city = City::where("spl_id", $splCity["CityID"])->first();

                if(!$city) {
                    City::create([
                        "name" => [
                            "en" => $splCity["CityNameEn"],
                            "ar" => $splCity["CityNameAr"]
                        ],
                        "area_id" => $area->id,
                        "is_active" => true,
                        "torod_city_id" => null,
                        "spl_id" => $splCity["CityID"]
                    ]);
                }
            }
        }

        $this->info("Cities Seeded Successfully...");

        return Command::SUCCESS;
    }
}
