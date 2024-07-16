<?php

return [
    "label" => "فواتير العمولة",
    "create" => [
        "label" => "توليد فاتورة عمولة",
        "select_vendor" => "اختر المتجر",
        "all_vendors" => "كل المتاجر",
        "select_year" => "حدد السنة",
        "select_month" => "حدد الشهر",
    ],
    "print" => [
        "label" => "طباعة الفاتورة",
    ],
    "view" => "عرض",
    "invoice_line_description_text" => "عمولة المنصة بنسبة :commission %",
    "description_from_to" => "من تاريخ :from إلى تاريخ :to",
    "orders_count" => "عدد العمليات",
    "attributes" => [
        "number" => "رقم الفاتورة",
        "period" => "الفترة",
        "period_start_at" => "بداية الفترة",
        "period_end_at" => "نهاية الفترة",
        "total_without_vat" => "الإجمالي غير شامل الضريبة",
        "total_without_vat_1" => "المبلغ الخاضع للضريبة",
        "vat_amount" => "إجمالي الضريبة",
        "total_with_vat" => "الإجمالي شامل الضريبة",
        "status" => "الحالة",
        "created_at" => "تاريخ الإنشاء"
    ],
    "state" => [
        "completed" => [
            "title" => "مكتمل",
            "badge_class" => "info"
        ],
    ],
    "errors" => [
        "no_orders_found" => "لا يوجد طلبات للمتجر خلال الفترة المحددة"
    ]
];
