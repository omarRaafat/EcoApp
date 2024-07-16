<?php

namespace Database\Seeders;

use App\Enums\ClientMessageEnum;
use App\Models\ClientMessage;
use Illuminate\Database\Seeder;

class ClientMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::CompletedTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                        "طلبك ::var_order_invoice_no:: بين ايديك، هني وعافية\n".
                        "ولا تنسانا بتقييم الطلب\n".
                        "::var_link_order::",
                ]
            ]
        );
        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::CreatedTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "شكرا يا ::var_client_name::،\n".
                        "تم إستلام طلبك رقم: ::var_order_id::\n".
                        "بقيمة: ::var_order_amount:: ر.س.\n",
                ]
            ]
        );
        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::OnDeliveryTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                        "جاري توصيل طلبك رقم: ::var_order_invoice_no::\n",
                ]
            ]
        );
        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::ReceiveTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                        "جاري توصيل طلبك رقم: ::var_order_invoice_no::\n",
                        "::var_warehouse_name:: : من مستودع",
                        "::var_no_packets:: : يرجى التأكد من عد القطع",
                        "::var_receive_order_code:: : كود التأكيد",
                        "::var_warhouse_map:: : خريطة المستودع",
                ]
            ]
        );

        ClientMessage::updateOrCreate(
            ['message_for' => ClientMessageEnum::CanceledTransaction],
            [
                'deletable' => false,
                'message' => [
                    'ar' => "::var_client_name::،\n".
                        "تم إلغاء طلبك رقم ::var_order_id::\n",
                ]
            ]
        );

//        ClientMessage::updateOrCreate(
//            ['message_for' => ClientMessageEnum::DepositBalance],
//            [
//                'deletable' => false,
//                'message' => [
//                    'ar' => "::var_client_name::،\n".
//                        "تم إضافة مبلغ: ::var_deposited_balance:: لمحفظتك\n",
//                ]
//            ]
//        );
//        ClientMessage::updateOrCreate(
//            ['message_for' => ClientMessageEnum::BalanceWithdrawal],
//            [
//                'deletable' => false,
//                'message' => [
//                    'ar' => "::var_client_name::،\n".
//                        "تم خصم مبلغ: ::var_withdrawal_balance:: من محفظتك\n",
//                ]
//            ]
//        );

//        ClientMessage::updateOrCreate(
//            ['message_for' => ClientMessageEnum::TransactionTaxInvoice],
//            [
//                'deletable' => false,
//                'message' => [
//                    'ar' => "::var_client_name::،\n".
//                        "تم إصدار فاتورتك لطلبك رقم: ::var_order_id::\n".
//                        "::var_link_invoice::",
//                ]
//            ]
//        );
    }
}
