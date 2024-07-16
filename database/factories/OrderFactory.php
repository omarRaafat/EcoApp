<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\Vendor;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses=['registered','shipping_done','in_delivery','completed','canceled','refund'];
        return [
            'transaction_id'=>Transaction::inRandomOrder()->first()->id,
            'vendor_id'=>Vendor::inRandomOrder()->first()->id,
            'date'=>Carbon::now(),
            'status'=>$statuses[array_rand($statuses,1)],
            'delivery_type'=>'aramex',
            'total'=>5000,
            'sub_total'=>4000,
            'vat'=>4.00,
            'tax'=>600,
            'company_percentage'=> 10 ,
            'company_profit'=>400 ,
            'vendor_amount'=>3600 ,
            'code'=>orderCode(),
        ];
    }
}
