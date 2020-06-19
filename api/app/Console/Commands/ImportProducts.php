<?php

namespace App\Console\Commands;

use App\Products;
use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Product csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_path = storage_path("app/products.csv");
        if (!file_exists($file_path)) {
            echo "File Not Exists\n";
            exit();
        }


        $csv = $this->csv_to_array($file_path, ";");

        $data = collect($csv)->chunk(20);
        foreach ($data as $ch => $row) {
            $row = $row->map(function ($item){
                if ($item['vendor_id'] == ""){
                    $item['vendor_id'] = null;
                }
                return $item;
            });
            Products::insert($row->toArray());
            echo "Ready " . $ch . "\n";
        }
    }

    /**
     * @param string $filename
     * @param string $delimiter
     * @return array|bool
     */
    private function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}
