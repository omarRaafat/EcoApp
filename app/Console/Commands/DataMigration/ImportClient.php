<?php

namespace App\Console\Commands\DataMigration;

use App\Enums\UserTypes;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ImportClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:old-clients {csvfile_fullpath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        This command to import clients & owners from old Saudi Dates DB to this system,
        expected header for csv: 'name', 'email', 'phone'
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
                    User::updateOrCreate([
                        'email' => $line[1]
                    ], [
                        'name' => $line[0],
                        'phone' => "+$line[2]",
                        'type' => UserTypes::CUSTOMER,
                        'password' => 'cl!entP@ssw0rD'
                    ]);
                } catch (Exception $e) {
                    $msg = Str::substr($e->getMessage(), 0, 100);
                    echo "Issue in line number: $lineNumber with message: $msg";
                }
                $lineNumber++;
            }
            fclose($fileHandler);
        }
        return Command::SUCCESS;
    }
}
