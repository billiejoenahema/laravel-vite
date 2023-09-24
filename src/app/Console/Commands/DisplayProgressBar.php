<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;


class DisplayProgressBar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:display-progress-bar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'プログレスバーを表示させるテストコマンド';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // エクセルから読み込むときは$recordsの要素数を$countに代入する
        $count = 10;

        // ①処理の総ステップ数を指定します
        $progressBar = $this->output->createProgressBar($count);

        $records = range(1, $count);

        foreach ($records as $record) {
            // 本来、ここで何か処理を行います
            for ($j = 1; $j <= 10000000; $j++) {
                // 何もしない
            }
            // ②プログレスバーの表示を１つ分進めます
            $progressBar->advance();
        }

        // ③プログレスバーの表示を完了状態にします
        $progressBar->finish();

        $this->info("\n" . "Done!" . "\n");

        return 0;
    }
}
