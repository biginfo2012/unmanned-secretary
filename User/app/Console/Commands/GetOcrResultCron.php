<?php

namespace App\Console\Commands;

use App\Models\Cost;
use App\Models\Shop;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use stdClass;

class GetOcrResultCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get-ocr-result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        Log::info("OCR Scheduler Start:");
        $costs = Cost::where('type', 0)->whereNotNull('url')->take(20)->get();
        $costs_id = Cost::where('type', 0)->whereNotNull('url')->take(20)->pluck('id');
        if(count($costs_id)){
            Cost::whereIn('id', $costs_id)->update(['type' => 2]);
            foreach ($costs as $cost){
                Log::info("OCR Scheduler Start Item:");
                $start = new \DateTime();
                $filename = $cost->url;
                $path = public_path() . '/upload/' . $filename;
                $parseData = $this->getOCRInfo($path);
                $shop_name = $parseData->name;
                $shop_id = null;
                if (!empty($shop_name)) {
                    $shop = Shop::where('shop_name', $shop_name)->first();
                    if (isset($shop)) {
                        $shop_id = $shop->id;
                    } else {
                        $shop_data = [
                            'shop_name' => $shop_name
                        ];
                        $shop = Shop::create($shop_data);
                        $shop_id = $shop->id;
                    }
                }
                $data = [
                    'shop_id' => $shop_id,
                    'pay_date' => $parseData->year != '' && $parseData->month != '' && $parseData->day != '' ? $parseData->year . '-' . $parseData->month . '-' . $parseData->day : null,
                    'total' => $parseData->total,
                    'percent' => $parseData->percent,
                    'type' => 1
                ];
                Cost::find($cost->id)->update($data);
                $end = new \DateTime();
                $diff = $end->getTimestamp() - $start->getTimestamp();
                Log::info("OCR Scheduler Item-Time: " . $cost->id . "-" . $diff);
            }
        }
        Log::info("OCR Scheduler End:");
        return 0;
    }

    private function getOCRInfo($path)
    {
        $command = 'tesseract --tessdata-dir /home/ubuntu/tessdata_best ' . $path . ' - -l script/Japanese --psm 6';
        $content = shell_exec($command);
        Log::info("OCR Scheduler Content: " . $content);
        $name = ''; $total = ''; $percent = ''; $year = ''; $month = ''; $day = '';
        $line = strtok($content, PHP_EOL);
        $isContainNumber = false;
        while ($line !== FALSE) {
            $line = strtok(PHP_EOL);
            if ($isContainNumber) {
                $splits = explode(' ', $line);
                for ($i = 0, $iMax = count($splits); $i < $iMax; $i++) {
                    if (strlen($splits[$i]) > 1) {
                        $name = $splits[$i];
                        break;
                    }
                }
                $isContainNumber = false;
            } else {
                if (str_contains($line, '年')) {
                    $len = strlen($line);
                    for ($i = 0; $i < $len; $i++) {
                        if ($line[$i] == '年') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $year = $line[$j] . $year;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                        if ($line[$i] == '月') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $month = $line[$j] . $month;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                        if ($line[$i] == '日') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $day = $line[$j] . $day;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                }
                if (str_contains($line, 'XXXXX')) {
                    $isContainNumber = true;
                }
                if (str_contains($line, '%')) {
                    $len = strlen($line);
                    for ($i = 0; $i < $len; $i++) {
                        if ($line[$i] == '%') {
                            for ($j = $i - 1; $j >= 0; $j--) {
                                if ($line[$j] == ' ' || $line[$j] == ',' || $line[$j] == '.' || is_numeric($line[$j])) {
                                    if (is_numeric($line[$j])) {
                                        $percent = $line[$j] . $percent;
                                    }
                                } else {
                                    break;
                                }
                            }
                            for ($j = $i; $j < $len; $j++) {
                                if (is_numeric($line[$j])) {
                                    for ($k = $j; $k < $len; $k++) {
                                        if ($line[$k] == ' ' || $line[$k] == ',' || $line[$k] == '.' || is_numeric($line[$k])) {
                                            if (is_numeric($line[$k])) {
                                                $total = $total . $line[$k];
                                            }
                                        } else {
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
            }
        }
        strtok('', '');
        $data = new stdClass();
        $data->name = $name;
        $data->total = $total;
        $data->percent = $percent;
        $data->year = $year;
        $data->month = $month;
        $data->day = $day;
        return $data;
    }
}
