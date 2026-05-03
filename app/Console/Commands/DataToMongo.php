<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DataToMongo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('membersihkan data');
        \App\Models\DataEkstraksi::truncate();

        $filename = ['data_train.csv', 'data_validation.csv'];
        foreach ($filename as $value) {
            $path = storage_path("app/archieves/reports/{$value}");
    
            if (!file_exists($path)) {
                $this->error("File tidak ditemukan di : {$path}");
                return;
            }
    
            $this->info("Memulai impor : {$value}");
    
            $file = fopen($path, 'r');
            $header = fgetcsv($file);
    
            $count = 0;
            while (($row = fgetcsv($file)) !== false) {
                $data = array_combine($header, $row);
                \App\Models\DataEkstraksi::create($data);
                $count++;
            }
    
            fclose($file);
            $this->info("Selesai, $count data berhasil diimpor");
        }
    }
}
