<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function test(Request $request)
    {
        Artisan::call('optimize:clear');
        $id = random_int(1, 100);
        return $this->testBase($id);
    }

    public function testCustom(Request $request)
    {
        Artisan::call('optimize:clear');
        $id = $request['session_id'];
        return $this->testBase($id);
    }

    private function testBase($id)
    {
        DB::beginTransaction();
        try {
            $faker = Factory::create();
            $data = [
                'session_id' => $id,
                'name' => $faker->name . 'this'
            ];
            $count = Product::where('session_id', $data['session_id'])->where('name', 'like', '%this%')->count();
            if ($count > 0) {
                Log::info('Already exists : ' . $data['session_id'] . ' ' . $count);
            } else {
                $this->longer();
                Product::create($data);
                DB::commit();
                Log::info('created  : ' . $data['session_id'] . ' ' . $count);
                if ($count > 0) {
                    Log::error('************************error found *************');
                }
            }
            return 'finished';
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('exception');
        }
    }

    private function longer()
    {
        $faker = Factory::create();
        $items = Product::where('name', 'like', '%' . $faker->name . '%')->get();
        foreach ($items as $item) {
            $sessionItems = Product::where('session_id', 'like', '%' . $item['session_id'] . '%')->get();
            foreach ($sessionItems as $sessionItem) {
                $records =  Product::where('name', 'like', '%' . $sessionItem->name . '%')->get();
                foreach ($records as $record) {
                    $record->updated_at = now();
                    $record->save();
                }
            }
        }
    }

    public function tinker()
    {
        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        Product::factory()->count(100000)->create();
    }
}
