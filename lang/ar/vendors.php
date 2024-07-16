<?php

return [
    "api" => [
        "vendors_retrived" => "تم إسترجاع البائعين بنجاح",
        "vendor_retrived" => "تم إسترجاع البائع بنجاح",
        "vendors_retrieved" => "تم إسترجاع البائعين بنجاح",
    ],
    "assign-order-services" => [
        "assign-order-services-request" => 'اسناد الطلب لموظف',
        "employees" => 'الموظفين',
        'assign' => 'اسناد',
        'assign_success' => 'تم الاسناد بنجاح',
        'assign_error' => 'عفوا الموظف تم الاسناد له من قبل',
    ],
    "registration" => [
        "choose_bank_name" => "إختار بنك",
        "validations" => [
            "tax_num_size" => "يجب أن يكون طول الرقم الضريبي 15 رقم",
            "street_required" => "العنوان مطلوب",
            "name_required" => " اسم المنشأة (كما في السجل التجاري) مطلوب",
            "store_name_required" => "إسم المنشأة مطلوب",
            "street_string" => "يجب أن يكون نوع حقل العنوان من نوع سلسلة نصية",
            "street_max" => "أقصى عدد لحروف العنوان 255 حرف",
            "desc_string" => "يجب أن يكون نوع حقل وصف المتجر من نوع سلسة نصية",
            "logo_required" => "حقل اللوجو مطلوب",
            "logo_image" => "يجب أن يكون حقل اللوجو من نوع صورة",
            "logo_mimes" => "الصيغ المقبولة لحقل اللوجو هي:jpeg,png,jpg,gif,svg",
            "logo_max" => "أقصى حجم لحقل اللوجو 2.48 ميجابيت",
            "tax_num_required" => "حقل الرقم الضريبي مطلوب",
            "tax_num_regex" => "تنسيق الرقم الضريبي غير صحيح",
            "cr_required" => "حقل السجل التجاري مطلوب",
            "cr_file" => "يجب ان يكون حقل السجل التجاري من نوع ملف",
            "cr_mimes" => "الصيغ المقبولة لحقل السجل التجاري هي:pdf,png,jpg",
            "cr_max" => "إقصى حجم لحقل السجل التجاري 2.48 ميجابايت",
            "crd_after" => "يجب أن يكون تاريخ السجل التجاري اكبر من التاريخ الحالى",

            "crd_date_format" => "يجب أن يكون تاريخ السجل التجاري Y-m-d",

            "iban_certificate_required" => "حقل شهادة IBAN مطلوب",
            "iban_certificate_file" => "يجب ان يكون حقل شهادة IBAN من نوع ملف",
            "iban_certificate_mimes" => "الصيغ المقبولة لحقل للشهادة هي:pdf,png,jpg",
            "iban_certificate_max" => "إقصى حجم للشهادة 2.48 ميجابايت",
            "broc_required" => "حقل علامة تمور السعودية مطلوب",
            "broc_file" => "يجب ان يكون حقل علامة تمور السعودية من نوع ملف",
            "broc_mimes" => "الصيغ المقبولة لحقل علامة تمور السعودية هي:pdf,png,jpg",
            "broc_max" => "أقصى حجم لحقل علامة تمور السعودية 2.48 ميجابايت",

            "tax_certificate_required" => "حقل شهادة ضريبة القيمة المضافة مطلوب",
            "tax_certificate_file" => "يجب أن يكون حقل شهادة ضريبة القيمة المضافة من نوع ملف",
            "tax_certificate_mimes" => "الصيغ المقبولة لحقل شهادة ضريبة القيمة المضافة هي:pdf,png,jpg",
            "tax_certificate_max" => "أقصى حجم لحقل شهادة ضريبة القيمة المضافة 2.48 ميجابايت",


            "saudia_certificate_required" => "حقل شهادة السعودة مطلوب",
            "saudia_certificate_file" => "يجب أن يكون حقل شهادة السعودة من نوع ملف",
            "saudia_certificate_mimes" => "الصيغ المقبولة لحقل شهادة السعودة هي:pdf,png,jpg",
            "saudia_certificate_max" => "أقصى حجم لحقل شهادة السعودة 2.48 ميجابايت",

            "subscription_certificate_required" => "حقل شهادة الاشتراك ف التأمينات الاجتماعية مطلوب",
            "subscription_certificate_file" => "يجب أن يكون حقل شهادة الاشتراك ف التأمينات الاجتماعية من نوع ملف",
            "subscription_certificate_mimes" => "الصيغ المقبولة لحقل شهادة الاشتراك ف التأمينات الاجتماعية هي:pdf,png,jpg",
            "subscription_certificate_max" => "أقصى حجم لحقل شهادة الاشتراك ف التأمينات الاجتماعية 2.48 ميجابايت",
            "desc_required" => 'حقل الوصف مطلوب' ,
            "room_certificate_required" => "حقل شهادة الاشتراك في الغرفة التجارية مطلوب",
            "room_certificate_file" => "يجب أن يكون حقل شهادة الاشتراك في الغرفة التجارية من نوع ملف",
            "room_certificate_mimes" => "الصيغ المقبولة لحقل شهادة الاشتراك في الغرفة التجارية هي:pdf,png,jpg",
            "room_certificate_max" => "أقصى حجم لحقل شهادة الاشتراك في الغرفة التجارية 2.48 ميجابايت",

            "bank_name_required" => "حقل إسم البنك مطلوب",
            'bank_num_required' => "حقل إسم رقم البنك مطلوب",
            "bank_num_max" => "أقصى طول لحقل رقم البنك 16 رقم",
            "ipan_max" => "أقصى طول لحقل لرقم الحساب الدولي 30 رقم",
            "ipan_required" => "حقل رقم الحساب الدولي مطلوب",
            "commercial_registration_no_required" => "حقل رقم السجل التجاري مطلوب",
            "commercial_registration_no_number" => "يجيب ان يكون رقم السجل التجاري يحتوي على ارقام",
            "ipan_min" => "اقل طول لحقل لرقم الحساب الدولي 20 رقم",
            "bank_id_required" => "حقل إسم البنك مطلوب",
            "phone_unique" => "رقم الجوال موجود مسبقاً",
            'phone_max' => 'يجيب ان يكون طول نص الهاتف على الاكثى 12 رقماً',
            'phone_min' => 'يجيب ان يكون طول نص الهاتف على الاقل 10 رقماً',
            "second_phone_unique" => "رقم الجوال موجود مسبقاً",
            'second_phone_max' => 'يجيب ان يكون طول نص الهاتف على الاكثى 12 رقماً',
            'second_phone_min' => 'يجيب ان يكون طول نص الهاتف على الاقل 10 رقماً',
            'second_phone_required' => 'حقل رقم الهاتف الاضافى مطلوب',
            'second_phone_regex' => 'تنسق حقل الهاتف الاضافى غير صحيح',
            'second_phone_different' => 'يجيب ان يكون رقم الهاتف الاضافى مختلف عن الهاتف الاساسى',
            'website_url' => 'https:// , يجيب ادخال موقع الكترونى صالح , و يبداء بى',
            'phone_number_exists' => 'رقم الهاتف مسجل مسبقاً',
            'email_exists' => 'البريد الإكتروني مسجل مسبقاً',
            'services_required' => 'يجب تحديد خدمة واحده علي الاقل',
        ]
    ],
    "inactive" => "تم تعطيل المتجر يرجى التواصل مع الإدارة",
    "barcode" => "باركود",
    "vendor_company_name" => "اسم المنشأة ",
    "shipping_info" => [
        "title" => "بيانات الشحن",
        "status" => "الحالة",
        "tracking_url"  => "تتبع الطلب" ,
        "tracking_id" => "معرف التتبع",
        'shipping_method' => 'شركه الشحن',
        'shipping_method_logo' => 'صوره  شركه الشحن' ,
        "van_type" => "نوع العربه",
        "total_weight" => "الوزن الكلي",
        "base_shipping_fees" => "تكلفه التوصيل",
        "extra_shipping_fees" => "تكلفه الحموله الزائده",
        "total_shipping_fees" => "تكلفه التوصيل الاجماليه ",
    ],

    "shipping_status" => [
        'waitingPay' => 'في إنتظار الدفع',
        'seen' => 'تمت المشاهدة',
        'paid' => 'تم الدفع',
        'pending' => 'جارى التجهيز',
        'registered' => 'جارى التجهيز',
        'processing' => 'تم التجهيز',
        'PickedUp' => 'تم الإلتقاط',
        'in_shipping' => 'جارى التوصيل',
        'completed' => 'تم التوصيل',
        'confirmed' => 'تم التجهيز',
        'delivered' => 'تم التوصيل',
        'cancelled' => 'ملغي',
        'canceled' => 'ملغي',
        'refund' => 'تم الاسترجاع',
    ],
    "service_shipping_status" => [
        'waitingPay' => 'في إنتظار الدفع',
        'seen' => 'تمت المشاهدة',
        'paid' => 'تم الدفع',
        'pending' => 'طلب جديد',
        'registered' => 'طلب جديد',
        'processing' => 'جاري تقديم الخدمة',
        'completed' => 'تمت الخدمة',
        'confirmed' => 'جاري تقديم الخدمة',
        'cancelled' => 'ملغي',
        'canceled' => 'ملغي',
    ],
    "empty" => "غير متاح",
    "successfully_updated" => "تم التعديل بنجاح",
    'logo_image' => 'يجب أن يكون الشعار صورة',
    'tax_num_regex' => 'تنسيق رقم ضريبة غير صالح',
    'crd_date_format' => 'يجب أن يكون تاريخ CR Y-M-D',
    'iban_certificate_required' => 'شهادة IBAN مطلوبة',
    'iban_certificate_file' => 'يجب أن تكون شهادة IBAN ملفًا',
    'iban_certificate_mimes' => 'امتدادات مقبولة لشهادة IBAN: PDF ، PNG ، JPG',
    'iban_certificate_max' => 'الحد الأقصى لحجم الشهادة هو 2.48 ميغابايت',
    'ipan_max' => 'الحد الأقصى لطول حقل IBAN هو 30 رقمًا',
    'ipan_required' => 'حقل إيبان مطلوب',
    'ipan_min' => 'الحد الأدنى لطول حقل IBAN هو 20 رقمًا',
    'phone_max' => 'يجب أن يكون طول نص الهاتف 12 رقمًا على الأقل',
    'phone_min' => 'يجب أن يكون طول نص الهاتف بأرقام Leaster 10',
    'second_phone_unique' => 'يوجد هاتف إضافي من قبل',
    'second_phone_max' => 'يجب أن يكون طول نص الهاتف 12 رقمًا على الأقل',
    'second_phone_min' => 'يجب أن يكون طول نص الهاتف بأرقام Leaster 10',
    'second_phone_required' => 'مطلوب هاتف إضافي',
    'second_phone_regex' => 'هاتف إضافي غير صالح',
    'second_phone_different' => 'يجب أن يكون رقم الهاتف الإضافي مختلفًا عن الهاتف الأساسي',
    'website_url' => 'أدخل موقع ويب صالح ، وابدأ بـ https: //',
    'agreement-required' => 'يجب موافقة مالك المتجر على إتفاقية إستخدام منصة مزارع',
    'agreement-requested' => 'تحديث إتفاقية التجار. عزيزي التاجر يرجى الإطلاع على الإتفاقية و قبولها أدناه',
    'download-agreement' => 'تحميل إتفاقية منصة مزارع',
    'agreement-read-and-approve' => 'لقد قرأت الإتفاقية و أوافق عليها',
    'no-agreement-requested' => 'لا يوجد إتفاقية للموافقة عليها',
    'you-have-approved-agreement' => 'لقد وافقت علي الإتفاقية بنجاح',
    'cant-approved-agreement' => 'لا يمكن الموافقة علي الإتفاقية في الوقت الحالي, حاول في وقت لاحق',
    'create-warehouse-request-error' => 'خطاء في إنشاء الطلب',
    'my-agreements' => 'إتفاقية التجار',
    'actions' => 'الإجراءات',
    'created_at' => 'تاريخ الإنشاء',
    'role-name' => 'إسم الدور',
    'role-permission' => 'صلاحيات الدور',
    'no-roles' => 'لا يوجد أدوار الموظفين',
    'roles' => 'أدوار الموظفين',
    'create_role' => 'إنشاء دور جديد',
    'edit_role' => 'تعديل الدور',
    'role_data' => 'بيانات الدور',
    'role_name' => 'إسم الدور',
    'permissions' => 'الصلاحيات',
    'permissions_keys' => [
        'role' => 'إدارة أدوار الموظفين',
        'order' => 'إدارة طلبات المنتجات',
        'product' => 'إدارة المنتجات',
        'user' => 'إدارة المستخدمين',
        'review' => 'إدارة التقييمات',
        'certificate' => 'إدارة الشهادات',
        'warehouse' => 'إدارة طلبات التخزين',
        'reports' => 'إدارة التقارير',
        'statistics' => 'الاحصائيات',
        'services' => 'ادارة الخدمات',
        'order_services' => 'ادارة طلبات الخدمات',
        'type_of_employees' => 'ادارة انواع الموظفين',
    ],
    'role_created_successfully' => 'تم إنشاء دور جديد بنجاح',
    'role_updated_successfully' => 'تم تحديث الدور بنجاح',
    'role_deleted_successfully' => 'تم حذف الدور بنجاح',
    "is_active" => "حالة التفعيل",
];