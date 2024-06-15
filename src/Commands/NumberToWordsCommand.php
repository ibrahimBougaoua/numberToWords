<?php

namespace NumberToWord\NumberToWords\Commands;

use Illuminate\Console\Command;

class NumberToWordsCommand extends Command
{
    public $signature = 'numbertowords';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
