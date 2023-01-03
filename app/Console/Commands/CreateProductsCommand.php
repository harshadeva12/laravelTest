<?php

namespace App\Console\Commands;

use App\Jobs\CreateProductJob;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class CreateProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $uuid = (string) Uuid::uuid4();
        foreach (range(1, 5) as $i) {
            dispatch(new CreateProductJob($uuid));
        }
    }
}
