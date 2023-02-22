<?php

namespace App\Console\Commands;

use App\Traits\ProductTrait;
use Illuminate\Console\Command;

class product extends Command
{
    use ProductTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = 'public/Product.csv';
        $this->extractData($path);

        // return Command::SUCCESS;
    }
}
