<?php

namespace App\Console\Commands\DataMigration;

use Exception;
use App\Models\User;
use App\Models\Vendor;
use App\Enums\UserTypes;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ImportVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:old-vendors {csvfile_fullpath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        This command to import vendors & owners from old Saudi Dates DB to this system,
        expected header for csv:
            'is_active', 'approval', 'name', 'desc', 'street', 'logo', 'tax_num', 'cr', 'crd', 'broc',
            'tax_certificate', 'bank_num', 'ipan', 'commission', 'owner_name', 'owner_phone', 'owner_email', 'owner_active'
    ";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csvFilePath = $this->argument('csvfile_fullpath');
        if (($fileHandler = fopen($csvFilePath, "r")) !== FALSE) {
            $header = fgetcsv($fileHandler);
            $lineNumber = 1;
            while (($line = fgetcsv($fileHandler, 1000, ",")) !== FALSE) {
                try {
                    if ($line[0] == 1 && $line[1] == "approved") {
                        $vendorUser = User::updateOrCreate([
                            'email' => $line[16]
                        ], [
                            'name' => $line[14],
                            'phone' => $line[15],
                            'is_active' => $line[17],
                            'type' => UserTypes::VENDOR
                        ]);
                        $vendorData["is_active"] = $line[0];
                        $vendorData["approval"] = $line[1];
                        $vendorData["name"] = $line[2];
                        $vendorData["desc"] = $line[3];
                        $vendorData["street"] = $line[4];
                        $vendorData["logo"] = $line[5];
                        $vendorData["tax_num"] = is_numeric($line[6]) ? $line[6] : 0;
                        $vendorData["cr"] = $line[7];
                        // $vendorData["crd"] = $line[8];
                        $vendorData["broc"] = $line[9];
                        $vendorData["tax_certificate"] = $line[10];
                        $vendorData["bank_num"] = is_numeric($line[11]) ? $line[11] : 0;
                        $vendorData["ipan"] = $line[12];
                        $vendorData["commission"] = $line[13];
                        $vendorData["user_id"] = $vendorUser->id;
                        Vendor::create($vendorData);
                    }
                } catch (Exception $e) {
                    $msg = Str::substr($e->getMessage(), 0, 50);
                    echo "Issue in line number: $lineNumber with message: $msg";
                }
                $lineNumber++;
            }
            fclose($fileHandler);
        }
        return Command::SUCCESS;
    }
}
