<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
		
    /** @var string */
    public $uuid;
		
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
    public function handle()
    {
        Product::firstOrCreate(['session_id' => $this->uuid]);
    }
}
