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
    protected $signature = 'import:csv {filename}';


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
        $filename = $this->argument('filename');
        $path = storage_path("app/archieves/reports/{$filename}");

        if (!file_exists($path)) {
            $this->error("File tidak ditemukan di : {$path}");
            return;
        }

        $this->info("Memulai impor : {$filename}");

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
