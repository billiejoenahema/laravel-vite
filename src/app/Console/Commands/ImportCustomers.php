<?php

namespace App\Console\Commands;

use App\Imports\CustomerImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-customers {excel_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'エクセルファイルから顧客を登録するコマンド';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('excel_file');
        $filePath = Storage::disk('local')->path($fileName);

        Excel::import(new CustomerImport, $filePath);
    }
}
