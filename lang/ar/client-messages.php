<?php

use App\Enums\ClientMessageEnum;

return [
    'messages' => 'الرسائل',
    'title' => 'الرسائل المثبتة',
    'sms_title' => 'أرسل رسالة',
    ClientMessageEnum::CreatedTransaction => "إستلام طلب جديد",
    ClientMessageEnum::CreatedServiceTransaction => "إستلام طلب خدمة جديد",
    ClientMessageEnum::OnDeliveryTransaction => "جاري توصيل الطلب",
    ClientMessageEnum::CompletedTransaction => "تم توصيل الطلب",
    ClientMessageEnum::CompletedServiceTransaction => "تم تقديم الخدمة",
    ClientMessageEnum::ReceiveTransaction => "استلام الطلب بنفسى",
    ClientMessageEnum::ReceiveServiceTransaction => "جاري تقديم الخدمة",
//    ClientMessageEnum::DepositBalance => "إضافة رصيد للمحفظة",
    ClientMessageEnum::CanceledTransaction => "تم إلغاء الطلب",
    ClientMessageEnum::RefundTransaction => "تم إسترجاع الطلب",
//    ClientMessageEnum::BalanceWithdrawal => "خصم رصيد من المحفظة",
//    ClientMessageEnum::TransactionTaxInvoice => "تم إصدار فاتورة الطلب",
//    ClientMessageEnum::PendingOrder => "تم إستلام الطلب",
//    ClientMessageEnum::ProcessingOrder => "تم تجهيز الطلب",
//    ClientMessageEnum::CompleteOrder => "تم انتهاء الطلب",
    'message' => "محتوي الرسالة",
    'message-for' => "نوع الرسالة",
    'not_found' => 'لا يوجد رسال مثبتة',
    'edit' => 'تعديل الرسالة',
    'edited' => [
        'title' => 'تم التعديل بنجاح',
        'body' => 'تم تعديل الرسالة المثبتة بنجاح',
    ],
    'hint' => 'يرجي التأكد من وضع كل المتغيرات في الرسالة بالشكل الآتي: (::اسم المتغير كما موضح::) و لإضافة سطر جديد يرجي إضافة \n',
    'variables' => 'المتغيرات للرسالة',
    'edit-error' => "خطاء أثناء التعديل",
    'missed-variables' => "يوجد بعض المتغيرات غير مرسلة يرجي إضافتها :variables",
];
