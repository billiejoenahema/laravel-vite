<?php

declare(strict_types=1);

namespace App\Console\Commands\Customer;

use App\Models\Customer;
use function count;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /** @var string シート名 */
    private const SHEET_NAME = '顧客リスト';

    /** @var array ヘッダの値の配列 */
    private const SHEET_HEADERS = [
        '氏名', // 0
        'ふりがな', // 1
        '電話番号', // 2
        '性別', // 3
        '生年月日', // 4
        '郵便番号', // 5
        '都道府県', // 6
        '市区町村', // 7
        '番地', // 8
        '備考', // 9
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        // エクセルファイル読込
        $fileName = $this->argument('file');
        $filePath = Storage::disk('local')->path('public/' . $fileName);
        $reader = new XlsxReader();
        $sheet = $reader->load($filePath)->getSheetByName(self::SHEET_NAME);
        // $sheet = $reader->load($filePath)->getActiveSheet();
        $rows = $sheet->toArray();

        // 1行目を取り出す
        $headerRow = array_shift($rows);
        // ヘッダチェック
        $diff = array_diff(self::SHEET_HEADERS, $headerRow);
        // ヘッダが一致しない場合は処理を終了する
        if ($diff) {
            $this->error('ヘッダ不一致');
            $this->error(implode(',', $diff));

            return;
        }

        // 行数取得
        $rowCount = $rows ? count($rows) : 0;
        // 行数が0なら処理を終了する
        if ($rowCount === 0) {
            $this->error('データが存在しません');

            return;
        }

        // 処理の総ステップ数をセット
        $progressBar = $this->output->createProgressBar($rowCount);

        // 登録処理
        DB::transaction(static function () use ($rows, $progressBar) {
            foreach ($rows as $row) {
                $customer = new Customer();
                $customer->name = $row[0];
                $customer->name_kana = $row[1];
                $customer->phone = $row[2];
                $customer->gender = $row[3];
                $customer->birth_date = $row[4];
                $customer->postal_code = $row[5];
                $customer->pref = $row[6];
                $customer->city = $row[7];
                $customer->street = $row[8];
                $customer->note = $row[9];

                $customer->save();
                $progressBar->advance();
            }
        });

        // プログレスバーの表示を完了状態にする
        $progressBar->finish();

        $this->info("\n" . '登録完了！');
    }
}
