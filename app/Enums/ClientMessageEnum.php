<?php
namespace App\Enums;

class ClientMessageEnum {
    const CompletedTransaction = "CompletedTransaction";
    const CompletedServiceTransaction = "CompletedServiceTransaction";
    const CreatedTransaction = "CreatedTransaction";
    const CreatedServiceTransaction = "CreatedServiceTransaction";
    const OnDeliveryTransaction = "OnDeliveryTransaction";
    const ReceiveTransaction = "ReceiveTransaction";
    const ReceiveServiceTransaction = "ReceiveServiceTransaction";
    const CanceledTransaction = "CanceledTransaction";
    const RefundTransaction = "RefundTransaction";

//    const DepositBalance = "DepositBalance";
//    const BalanceWithdrawal = "BalanceWithdrawal";
//    const TransactionTaxInvoice = "TransactionTaxInvoice";
//    const PendingOrder = "PendingOrder";
//    const ProcessingOrder = "ProcessingOrder";
//    const CompleteOrder =  "CompleteOrder";

    public static function getMessageTypes() : array {
        return [
            self::CompletedTransaction,
            self::CompletedServiceTransaction,
            self::CreatedTransaction,
            self::CreatedServiceTransaction,
            self::OnDeliveryTransaction,
            self::ReceiveTransaction,
            self::ReceiveServiceTransaction,
            self::CanceledTransaction,
            self::RefundTransaction,
//            self::TransactionTaxInvoice,
//            self::PendingOrder,
//            self::ProcessingOrder,
//            self::CompleteOrder,
//            self::BalanceWithdrawal,
//            self::DepositBalance,


        ];
    }

    public static function getMessageTypesTranslated() : array {
        return [
            self::CompletedTransaction => __("client-messages.CompletedTransaction"),
            self::CompletedServiceTransaction => __("client-messages.CompletedServiceTransaction"),
            self::CreatedTransaction => __("client-messages.CreatedTransaction"),
            self::CreatedServiceTransaction => __("client-messages.CreatedServiceTransaction"),
            self::OnDeliveryTransaction => __("client-messages.OnDeliveryTransaction"),
            self::ReceiveTransaction => __("client-messages.ReceiveTransaction"),
            self::ReceiveServiceTransaction => __("client-messages.ReceiveServiceTransaction"),
//            self::DepositBalance => __("client-messages.DepositBalance"),
//            self::BalanceWithdrawal => __("client-messages.BalanceWithdrawal"),
            self::CanceledTransaction => __("client-messages.CanceledTransaction"),
            self::RefundTransaction => __("client-messages.RefundTransaction"),
//            self::TransactionTaxInvoice => __("client-messages.TransactionTaxInvoice"),
//            self::PendingOrder => __("client-messages.PendingOrder"),
//            self::ProcessingOrder => __("client-messages.ProcessingOrder"),
//            self::CompleteOrder => __("client-messages.CompleteOrder"),

        ];
    }

    public static function getMessageVariables(string $messageType) : array {
        return match($messageType) {
            self::CompletedTransaction => [
                "::var_client_name::",
                "::var_order_invoice_no::",
                "::var_link_order::",
            ],
            self::CompletedServiceTransaction => [
                "::var_client_name::",
                "::var_order_invoice_no::",
                "::var_link_order::",
            ],
            self::CreatedTransaction => [
                "::var_client_name::",
                "::var_order_id::",
                "::var_order_amount::",
                "::var_order_invoice_no::",
            ],
            self::CreatedServiceTransaction => [
                "::var_client_name::",
                "::var_order_id::",
                "::var_order_amount::",
                "::var_order_invoice_no::",
            ],
            self::OnDeliveryTransaction => [
                "::var_client_name::",
                "::var_order_invoice_no::",
            ],
            self::ReceiveTransaction => [
                "::var_client_name::",
                "::var_order_invoice_no::",
                "::var_warehouse_name::",
                "::var_no_packets::",
                "::var_receive_order_code::",
                "::var_warhouse_map::",
            ],
            self::ReceiveServiceTransaction => [
                "::var_client_name::",
                "::var_order_invoice_no::",
                "::var_receive_order_code::",
            ],
            self::CanceledTransaction => [
                "::var_client_name::",
                "::var_order_id::",
            ],
            self::RefundTransaction => [
                "::var_client_name::",
                "::var_order_id::",
            ],

//            self::DepositBalance => [
//                "::var_client_name::",
//                "::var_deposited_balance::",
//            ],
//            self::BalanceWithdrawal => [
//                "::var_client_name::",
//                "::var_withdrawal_balance::",
//            ],

//            self::TransactionTaxInvoice => [
//                "::var_client_name::",
//                "::var_order_id::",
//                "::var_link_invoice::",
//            ],
//            self::PendingOrder => [
//                "::var_client_name::",
//                "::var_order_invoice_no::",
//                "::var_order_receive_code::",
//                "::var_warehouse_map::",
//            ],
//            self::ProcessingOrder => [
//                "::var_client_name::",
//                "::var_order_invoice_no::",
//                "::var_order_receive_code::",
//                "::var_warehouse_map::",
//            ],
//            self::CompleteOrder => [
//                "::var_client_name::",
//                "::var_order_invoice_no::",
//                "::var_order_receive_code::",
//                "::var_warehouse_map::",
//            ],
            default => []
        };
    }
}
