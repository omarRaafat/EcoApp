<?php

namespace Database\Seeders;

use App\Enums\ClientMessageEnum;
use App\Models\ClientMessage;
use Illuminate\Database\Seeder;

class ServiceClientMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::CreatedServiceTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                            "تم إستلام طلب الخدمة رقم: ::var_order_id::\n".
                            "بقيمة: ::var_order_amount:: ر.س.\n".
                            "رقم الطلب: ::var_order_invoice_no::",
                ]
            ]
        );

        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::ReceiveServiceTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                        "جاري تقديم الخدمة رقم: ::var_order_invoice_no::\n",
                        "::var_receive_order_code:: : كود التأكيد",
                ]
            ]
        );

        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::CompletedServiceTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                            "تم تقديم الخدمة رقم ::var_order_invoice_no::\n".
                            "رابط تقييم الطلب \n".
                            "::var_link_order::",
                ]
            ]
        );
    }
}
