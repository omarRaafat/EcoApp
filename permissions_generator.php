<?php

return [
    [
        "name" => [
            "ar" => "المتاجر",
            "en" => "Vendors"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.index"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض المتجر",
            "en" => "Show Vendor"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.show"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "تعديل المتجر",
            "en" => "Edit Vendor"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendors.edit",
            "admin.vendors.update"
        ],
        "group" => "vendors",
    ],
    // [
    //     "name" => [
    //         "ar" => "تحرير حالة المتجر",
    //         "en" => "Edit Vendor Approved"
    //     ],
    //     "module" => [
    //         "ar" => "المتاجر",
    //         "en" => "vendors"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["   "],
    //     "group" => "vendors",
    // ],
    [
        "name" => [
            "ar" => "تعطيل المتجر",
            "en" => "Disable Vendor"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.change-status"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "النسبة المئوية للإدارة",
            "en" => "Administration Accept Ratio"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.accept-set-ratio", "admin.vendors.approve"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض تحذيرات المتجر",
            "en" => "Show Vendor Warnings"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.warnings.index"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إضافة تحذير جديد",
            "en" => "Add New Vendor Warning"
        ],
        "module" => [
            "ar" => "المتاجر",
            "en" => "vendors"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendors.warnings.store"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض العملاء",
            "en" => "All Customers"
        ],
        "module" => [
            "ar" => "العملاء",
            "en" => "customers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.customers.index"],
        "group" => "customers",
    ],
    [
        "name" => [
            "ar" => "عرض العميل",
            "en" => "Show Customer"
        ],
        "module" => [
            "ar" => "العملاء",
            "en" => "customers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.customers.show"],
        "group" => "customers",
    ],
    [
        "name" => [
            "ar" => "تعديل أهمية العميل",
            "en" => "Modify Customer Priority"
        ],
        "module" => [
            "ar" => "العملاء",
            "en" => "customers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.customers.change-priority"],
        "group" => "customers",
    ],
    [
        "name" => [
            "ar" => "تعطيل العميل",
            "en" => "Disabled Customer"
        ],
        "module" => [
            "ar" => "العملاء",
            "en" => "customers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.customers.block"],
        "group" => "customers",
    ],
    [
        "name" => [
            "ar" => "تعديل بيانات العميل",
            "en" => "Edit Customer Info"
        ],
        "module" => [
            "ar" => "العملاء",
            "en" => "customers"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.customers.edit",
            "admin.customers.update"
        ],
        "group" => "customers",
    ],
    [
        "name" => [
            "ar" => "عرض الطلبات",
            "en" => "Show All Transactions"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.index", "admin.transactions.export"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => " عرض الطلبات الفرعية",
            "en" => "Show All Sub Transactions"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.sub_orders", "admin.transactions.sub_orders_export"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "تغير مستودع الإستلام",
            "en" => "Change Receiving Warehouse"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.sub_orders", "admin.transactions.sub_orders.change_warehouse"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => " عرض الطلبات الملغية",
            "en" => "Show All Transactions Canceled"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.canceled_orders", "admin.transactions.canceled_export"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "عرض الطلب",
            "en" => "Show Transaction"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.get_order_status",
            "admin.transactions.show",
            // "admin.transactions.export",
            "admin.transactions.invoice",
            "admin.transactions.pdf-invoice",
            "admin.transactions.send-to-bezz",
        ],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "تعديل الطلب",
            "en" => "Edit Transaction"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => [
            'admin.update_order_status',
            "admin.transactions.manage",
            "admin.transactions.update",
            "admin.transactions.send-to-bezz",
        ],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "ملخص الطلب",
            "en" => "Review Transaction"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.transactions.invoice",
            "admin.transactions.invoice.pdf"
        ],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "عرض سلات الشراء",
            "en" => "Show All Carts"
        ],
        "module" => [
            "ar" => "سلة الشراء",
            "en" => "cart"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.carts.index"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "عرض سلة شراء",
            "en" => "Show Cart"
        ],
        "module" => [
            "ar" => "سلة الشراء",
            "en" => "cart"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.carts.show"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "حذف سلة شراء",
            "en" => "Delete Cart"
        ],
        "module" => [
            "ar" => "سلة الشراء",
            "en" => "cart"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.carts.delete"],
        "group" => "transactions",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض محافظ العملاء",
    //         "en" => "Customers Wallets"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.wallets.index"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إنشاء محفظة عميل",
    //         "en" => "Create Customer Wallet"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.wallets.create",
    //         "admin.wallets.store"
    //     ],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات محفظة عميل",
    //         "en" => "Show Customer Wallet"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.wallets.show"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل محفظة عميل",
    //         "en" => "Edit Customer Wallet"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.wallets.edit",
    //         "admin.wallets.update"
    //     ],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "حذف محفظة عميل",
    //         "en" => "Delete Customer Wallet"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.wallets.destroy"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إدارة رصيد المحفظة",
    //         "en" => "Manage Wallet Balance"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.wallets.manageWalleBalance"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إضافة-خصم رصيد",
    //         "en" => "Add|Sub Balance"
    //     ],
    //     "module" => [
    //         "ar" => "محافظ إرضاء العملاء",
    //         "en" => "wallets"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.wallets.increaseAndDecreaseAmount"],
    //     "group" => "customer-finance",
    // ],
    [
        "name" => [
            "ar" => "عرض الأقسام",
            "en" => "Show Categories"
        ],
        "module" => [
            "ar" => "الأقسام",
            "en" => "categories"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.categories.index",
            "admin.categories.show",

            "admin.categories.showSubCategory",
            "admin.categories.showSubChildCategory",
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "إنشاء قسم",
            "en" => "Create Category"
        ],
        "module" => [
            "ar" => "الأقسام",
            "en" => "categories"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.categories.store",
            "admin.categories.create",
            "admin.categories.createSubCategory",
            "admin.categories.createSubChildCategory",
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "تعديل قسم",
            "en" => "Edit Category"
        ],
        "module" => [
            "ar" => "الأقسام",
            "en" => "categories"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.categories.update",
            "admin.categories.edit",
            "admin.categories.editSubCategory",
            "admin.categories.editSubChildCategory",
            "admin.categories.updateCategoryOrder"
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "حذف قسم",
            "en" => "Delete Category"
        ],
        "module" => [
            "ar" => "الأقسام",
            "en" => "categories"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.categories.destroy"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "عرض فئات المنتجات",
            "en" => "Products Classes"
        ],
        "module" => [
            "ar" => "فئات المنتجات",
            "en" => "productsClasses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productClasses.index"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "إنشاء فئة جديدة",
            "en" => "Create New Product Class"
        ],
        "module" => [
            "ar" => "فئات المنتجات",
            "en" => "productsClasses"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.productClasses.create",
            "admin.productClasses.store"
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "عرض فئة منتج",
            "en" => "Show Product Class"
        ],
        "module" => [
            "ar" => "فئات المنتجات",
            "en" => "productsClasses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productClasses.show"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "تعديل فئة منتج",
            "en" => "Edit Product Class"
        ],
        "module" => [
            "ar" => "فئات المنتجات",
            "en" => "productsClasses"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.productClasses.edit",
            "admin.productClasses.update"
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "حذف فئة منتج",
            "en" => "Delete Product Class"
        ],
        "module" => [
            "ar" => "فئات المنتجات",
            "en" => "productsClasses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productClasses.destroy"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "عرض المنتجات",
            "en" => "All Products"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.products.index"],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "منتجات شارفت على الإنتهاء",
            "en" => "Products almostOutOfStock"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.products.almostOutOfStock"],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "منتجات نفذت من المخزون",
            "en" => "Products outOfStock"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.products.outOfStock"],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "منتجات محذوفة",
            "en" => "Products deleted"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.products.deleted"],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "إنشاء منتج جديد",
            "en" => "Create New Product"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.products.create",
            "admin.products.store",
            "admin.admin.upload_product_images"
        ],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "عرض المنتج",
            "en" => "Show Product"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.products.show",
            "admin.products.print-barcode",
            "admin.products.approve",
            "admin.products.toggle-status",
            "admin.products.accept-update",
            "admin.products.refuse-update",
            "admin.products.delete-stock"
        ],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "تعديل منتج",
            "en" => "Edit Product"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.products.edit",
            "admin.products.update",
            "admin.admin.upload_product_images",
            "admin.products.update-stock"
        ],
        "group" => "products",
    ],
    [
        "name" => [
            "ar" => "حذف منتج",
            "en" => "Delete Product"
        ],
        "module" => [
            "ar" => "المنتجات",
            "en" => "products"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.products.destroy"],
        "group" => "products",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض كل البلاد",
    //         "en" => "All Countries"
    //     ],
    //     "module" => [
    //         "ar" => "البلاد",
    //         "en" => "countries"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.countries.index"],
    //     "group" => "countries-areas-cities",
    // ],
    // [
    //     "name" => [
    //         "ar" => "أنشاء دولة",
    //         "en" => "Create Country"
    //     ],
    //     "module" => [
    //         "ar" => "البلاد",
    //         "en" => "countries"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.countries.create",
    //         "admin.countries.store"
    //     ],
    //     "group" => "countries-areas-cities",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات الدولة",
    //         "en" => "Show Country"
    //     ],
    //     "module" => [
    //         "ar" => "البلاد",
    //         "en" => "countries"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.countries.show"],
    //     "group" => "countries-areas-cities",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل بيانات دولة",
    //         "en" => "Edit Country"
    //     ],
    //     "module" => [
    //         "ar" => "البلاد",
    //         "en" => "countries"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.countries.edit",
    //         "admin.countries.update"
    //     ],
    //     "group" => "countries-areas-cities",
    // ],
    // [
    //     "name" => [
    //         "ar" => "حذف دوله",
    //         "en" => "Delete Country"
    //     ],
    //     "module" => [
    //         "ar" => "البلاد",
    //         "en" => "countries"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.countries.destroy"],
    //     "group" => "countries-areas-cities",
    // ],
    [
        "name" => [
            "ar" => "عرض كل المدن",
            "en" => "All Cities"
        ],
        "module" => [
            "ar" => "المدن",
            "en" => "Cities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.cities.index"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "إنشاء مدينة",
            "en" => "Create City"
        ],
        "module" => [
            "ar" => "المدن",
            "en" => "Cities"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.cities.create",
            "admin.cities.store"
        ],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات مدينة",
            "en" => "Show City"
        ],
        "module" => [
            "ar" => "المدن",
            "en" => "Cities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.cities.show"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "تعديل مدينة",
            "en" => "Edit City"
        ],
        "module" => [
            "ar" => "المدن",
            "en" => "Cities"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.cities.edit",
            "admin.cities.update"
        ],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "حذف مدينة",
            "en" => "Delete City"
        ],
        "module" => [
            "ar" => "المدن",
            "en" => "Cities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.cities.destroy"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "عرض كل المناطق",
            "en" => "All Cities"
        ],
        "module" => [
            "ar" => "المناطق",
            "en" => "Areas"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.areas.index"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "إنشاء منطقة جديدة",
            "en" => "Create Area"
        ],
        "module" => [
            "ar" => "المناطق",
            "en" => "Areas"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.areas.create",
            "admin.areas.store"
        ],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات منطقة",
            "en" => "Show Area"
        ],
        "module" => [
            "ar" => "المناطق",
            "en" => "Areas"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.areas.show"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "تعديل منطقة",
            "en" => "Edit Area"
        ],
        "module" => [
            "ar" => "المناطق",
            "en" => "Areas"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.areas.edit",
            "admin.areas.update"
        ],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "حذف منطقة",
            "en" => "Delete Area"
        ],
        "module" => [
            "ar" => "المناطق",
            "en" => "Areas"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.areas.destroy"],
        "group" => "countries-areas-cities",
    ],
    [
        "name" => [
            "ar" => "عرض كل الشهادات",
            "en" => "All Certifications"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.certificates.index"],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "إنشاء شهادة جديدة",
            "en" => "Create New Certification"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.certificates.create",
            "admin.certificates.store"
        ],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "تعديل شهادة",
            "en" => "Edit Certification"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.certificates.edit",
            "admin.certificates.update"
        ],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "حذف شهادة",
            "en" => "Delete Certification"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.certificates.delete"],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "طلب شهادة",
            "en" => "Request Certifications"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.certificates.requests"],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "الموافقة/رفض شهادة",
            "en" => "Certification Approve|Reject"
        ],
        "module" => [
            "ar" => "الشهادات",
            "en" => "certifications"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.certificates.approve",
            "admin.certificates.reject"
        ],
        "group" => "certifications",
    ],
    [
        "name" => [
            "ar" => "إدارة صفحة عن المنصة",
            "en" => "About Us"
        ],
        "module" => [
            "ar" => "عن المنصة",
            "en" => "About Us"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.about-us.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء قسم عن المنصة",
            "en" => "Create About Us"
        ],
        "module" => [
            "ar" => "عن المنصة",
            "en" => "About Us"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.about-us.create",
            "admin.about-us.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات قسم عن المنصة",
            "en" => "Show About Us"
        ],
        "module" => [
            "ar" => "عن المنصة",
            "en" => "About Us"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.about-us.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل قسم عن المنصة",
            "en" => "Edit About Us"
        ],
        "module" => [
            "ar" => "عن المنصة",
            "en" => "About Us"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.about-us.edit",
            "admin.about-us.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف قسم عن المنصة",
            "en" => "Delete About Us"
        ],
        "module" => [
            "ar" => "عن المنصة",
            "en" => "About Us"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.about-us.destroy"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض أقسام سياسة الخصوصية",
            "en" => "All Privacy Policies"
        ],
        "module" => [
            "ar" => "سياسية الخصوصية",
            "en" => "Privacy Policy"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.privacy-policy.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء قسم سياسة خصوصية",
            "en" => "Create Privacy Policy"
        ],
        "module" => [
            "ar" => "سياسية الخصوصية",
            "en" => "Privacy Policy"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.privacy-policy.create",
            "admin.privacy-policy.store",
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات قسم سياسة الخصوصية",
            "en" => "Show Privacy Policy"
        ],
        "module" => [
            "ar" => "سياسية الخصوصية",
            "en" => "Privacy Policy"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.privacy-policy.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل قسم سياسية خصوصية",
            "en" => "Edit Privacy Policy"
        ],
        "module" => [
            "ar" => "سياسية الخصوصية",
            "en" => "Privacy Policy"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.privacy-policy.edit",
            "admin.privacy-policy.update",
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف قسم سياسة خصوصية",
            "en" => "Delete Privacy Policy"
        ],
        "module" => [
            "ar" => "سياسية الخصوصية",
            "en" => "Privacy Policy"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.privacy-policy.destroy"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض أقسام إتفاقية الإستخد المنصةام",
            "en" => "All Usage Agreenents"
        ],
        "module" => [
            "ar" => "إتفاقية الإستخدام المنصة",
            "en" => "Usage Agreenent"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.usage-agreement.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء قسم إتفاقية الإستخد المنصةام",
            "en" => "Create Usage Agreenent"
        ],
        "module" => [
            "ar" => "إتفاقية الإستخدام المنصة",
            "en" => "Usage Agreenent"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.usage-agreement.create",
            "admin.usage-agreement.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض إتفاقية إستخدام المنصة",
            "en" => "Show Usage Agreenent"
        ],
        "module" => [
            "ar" => "إتفاقية الإستخدام المنصة",
            "en" => "Usage Agreenent"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.usage-agreement.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل قسم إتفاقية إستخدام المنصة",
            "en" => "Edit Usage Agreenent"
        ],
        "module" => [
            "ar" => "إتفاقية الإستخدام المنصة",
            "en" => "Usage Agreenent"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.usage-agreement.edit",
            "admin.usage-agreement.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف قسم إتفاقية إستخدام المنصة",
            "en" => "Delete Usage Agreenent"
        ],
        "module" => [
            "ar" => "إتفاقية الإستخدام المنصة",
            "en" => "Usage Agreenent"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.usage-agreement.destroy"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض أقسام الأسئلة والأجوبة",
            "en" => "All QnA"
        ],
        "module" => [
            "ar" => "الأسئلة والأجوبة",
            "en" => "qna"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.qna.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء سؤال",
            "en" => "Create QnA"
        ],
        "module" => [
            "ar" => "الأسئلة والأجوبة",
            "en" => "qna"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.qna.create",
            "admin.qna.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض قسم أسئلة وأجوبة",
            "en" => "Show QnA"
        ],
        "module" => [
            "ar" => "الأسئلة والأجوبة",
            "en" => "qna"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.qna.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل قسم أسئلة وأجوبة",
            "en" => "Edit QnA"
        ],
        "module" => [
            "ar" => "الأسئلة والأجوبة",
            "en" => "qna"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.qna.edit",
            "admin.qna.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف قسم أسئلة وأجوبة",
            "en" => "Delete QnA"
        ],
        "module" => [
            "ar" => "الأسئلة والأجوبة",
            "en" => "qna"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.qna.destroy"],
        "group" => "static-content",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض الوصفات",
    //         "en" => "All Recipes"
    //     ],
    //     "module" => [
    //         "ar" => "الوصفات",
    //         "en" => "recipe"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.recipe.index"],
    //     "group" => "static-content",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إنشاء وصفه",
    //         "en" => "Create Recipe"
    //     ],
    //     "module" => [
    //         "ar" => "الوصفات",
    //         "en" => "recipe"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.recipe.create",
    //         "admin.recipe.store"
    //     ],
    //     "group" => "static-content",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض وصفه",
    //         "en" => "Show  Recipe"
    //     ],
    //     "module" => [
    //         "ar" => "الوصفات",
    //         "en" => "recipe"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.recipe.show"],
    //     "group" => "static-content",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل وصفه",
    //         "en" => "Edit Recipe"
    //     ],
    //     "module" => [
    //         "ar" => "الوصفات",
    //         "en" => "recipe"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.recipe.edit",
    //         "admin.recipe.update"
    //     ],
    //     "group" => "static-content",
    // ],
    // [
    //     "name" => [
    //         "ar" => "حذف وصفه",
    //         "en" => "Delete Recipe"
    //     ],
    //     "module" => [
    //         "ar" => "الوصفات",
    //         "en" => "recipe"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.recipe.destroy"],
    //     "group" => "static-content",
    // ],
    [
        "name" => [
            "ar" => "عرض المدونات",
            "en" => "All Blogs"
        ],
        "module" => [
            "ar" => "المدونة",
            "en" => "blog"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.blog.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء مدونة",
            "en" => "Create Blog"
        ],
        "module" => [
            "ar" => "المدونة",
            "en" => "blog"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.blog.create",
            "admin.blog.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض مدونة",
            "en" => "Show Blog"
        ],
        "module" => [
            "ar" => "المدونة",
            "en" => "blog"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.blog.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل مدونة",
            "en" => "Edit Blog"
        ],
        "module" => [
            "ar" => "المدونة",
            "en" => "blog"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.blog.edit",
            "admin.blog.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف مدونة",
            "en" => "Delete Blog"
        ],
        "module" => [
            "ar" => "المدونة",
            "en" => "blog"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.blog.destroy"],
        "group" => "static-content",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض طلبات سحب أرصدة العملاء",
    //         "en" => "All Customer Cach With Draws"
    //     ],
    //     "module" => [
    //         "ar" => "طلبات سحب الرصيد",
    //         "en" => "customerCachWithDraw"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.customer-cash-withdraw.index"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات طلب سحب رصيد عميل",
    //         "en" => "Show Customer Cach With Draw"
    //     ],
    //     "module" => [
    //         "ar" => "طلبات سحب الرصيد",
    //         "en" => "customerCachWithDraw"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.customer-cash-withdraw.show"],
    //     "group" => "customer-finance",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل طلب سحب رصيد عميل",
    //         "en" => "Edit Customer Cach With Draw"
    //     ],
    //     "module" => [
    //         "ar" => "طلبات سحب الرصيد",
    //         "en" => "customerCachWithDraw"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.customer-cash-withdraw.update"],
    //     "group" => "customer-finance",
    // ],
    [
        "name" => [
            "ar" => "عرض تقييم المنتجات",
            "en" => ""
        ],
        "module" => [
            "ar" => "تقييم المنتجات",
            "en" => "productRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productRates.index"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض تقييم منتج",
            "en" => "Show Product Rate"
        ],
        "module" => [
            "ar" => "تقييم المنتجات",
            "en" => "productRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productRates.show"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "قبول تقييم منتج",
            "en" => "Accept Product Rate"
        ],
        "module" => [
            "ar" => "تقييم المنتجات",
            "en" => "productRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productRates.update", "admin.productRates.update-checks"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "حذف تقييم منتج",
            "en" => "Delete Product Rate"
        ],
        "module" => [
            "ar" => "تقييم المنتجات",
            "en" => "productRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.productRates.destroy"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض وحدات قياس المنتجات",
            "en" => ""
        ],
        "module" => [
            "ar" => "وحدات قياس المنتجات",
            "en" => "productQuantities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.product-quantities.index"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "إنشاء وحدة قياس منتج",
            "en" => "Create Product Quantity"
        ],
        "module" => [
            "ar" => "وحدات قياس المنتجات",
            "en" => "productQuantities"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.product-quantities.create",
            "admin.product-quantities.store"
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "عرض وحدة قياس منتج",
            "en" => "Show Product Quantity"
        ],
        "module" => [
            "ar" => "وحدات قياس المنتجات",
            "en" => "productQuantities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.product-quantities.show"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "تعديل وحدة قياس منتج",
            "en" => "Edit Product Quantity"
        ],
        "module" => [
            "ar" => "وحدات قياس المنتجات",
            "en" => "productQuantities"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.product-quantities.edit",
            "admin.product-quantities.update"
        ],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "حذف وحدة قياس منتج",
            "en" => "Delete Product Quantity"
        ],
        "module" => [
            "ar" => "وحدات قياس المنتجات",
            "en" => "productQuantities"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.product-quantities.destroy"],
        "group" => "categories-calsses-types",
    ],
    [
        "name" => [
            "ar" => "عرض تقييم المتاجر",
            "en" => "All Vendors Rates"
        ],
        "module" => [
            "ar" => "تقييم المتاجر",
            "en" => "vendorRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorRates.index"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض تقييم عمليات الشراء",
            "en" => "Transaction Process Rates"
        ],
        "module" => [
            "ar" => "تقييم عمليات الشراء",
            "en" => "transactionProcessRate"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactionProcessRate.index"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض تقييم الطلب",
            "en" => "Order Process Rates"
        ],
        "module" => [
            "ar" => "تقييم الطلب",
            "en" => "orderProcessRate"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.orderProcessRate.index"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض تقييم منتج",
            "en" => "Show Vendor Rate"
        ],
        "module" => [
            "ar" => "تقييم المتاجر",
            "en" => "vendorRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorRates.show"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "قبول تقييم منتج",
            "en" => "Accept Vendor Rate"
        ],
        "module" => [
            "ar" => "تقييم المتاجر",
            "en" => "vendorRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorRates.update", "admin.vendorRates.update-checks"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "حذف تقييم منتج",
            "en" => "Delete Vendor Rate"
        ],
        "module" => [
            "ar" => "تقييم المتاجر",
            "en" => "vendorRates"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorRates.destroy"],
        "group" => "rates",
    ],
    [
        "name" => [
            "ar" => "عرض طلبات التخزين",
            "en" => "All Warehouse Requests"
        ],
        "module" => [
            "ar" => "طلبات التخزين",
            "en" => "warehouseRequest"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.wareHouseRequests.index"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "إنشاء طلب تخزين",
            "en" => "Create Warehouse Request"
        ],
        "module" => [
            "ar" => "طلبات التخزين",
            "en" => "warehouseRequest"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.wareHouseRequests.create",
            "admin.wareHouseRequests.store",
            "admin.wareHouseRequests.show-products",
            "admin.vendor-warehouse-request"
        ],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "عرض طلب تخزين",
            "en" => "Show Warehouse Request"
        ],
        "module" => [
            "ar" => "طلبات التخزين",
            "en" => "warehouseRequest"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.wareHouseRequests.show"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "عرض السلايدرات",
            "en" => "All Sliders"
        ],
        "module" => [
            "ar" => "السلايدر",
            "en" => "slider"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.slider.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض سلايدر",
            "en" => "Show Slider"
        ],
        "module" => [
            "ar" => "السلايدر",
            "en" => "slider"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.slider.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "انشاء سلايدر",
            "en" => "create Slider"
        ],
        "module" => [
            "ar" => "السلايدر",
            "en" => "slider"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.slider.create",
            "admin.slider.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل سلايدر",
            "en" => "Edit Slider"
        ],
        "module" => [
            "ar" => "السلايدر",
            "en" => "slider"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.slider.edit",
            "admin.slider.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض مشرفي النظام",
            "en" => "All SubAdmins"
        ],
        "module" => [
            "ar" => "مشرفي النظام",
            "en" => "subAdmins"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.subAdmins.index"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "إنشاء مشرف نظام",
            "en" => "Create SubAdmin"
        ],
        "module" => [
            "ar" => "مشرفي النظام",
            "en" => "subAdmins"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.subAdmins.create",
            "admin.subAdmins.store"
        ],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات مشرف النظام",
            "en" => "Show SubAdmin"
        ],
        "module" => [
            "ar" => "مشرفي النظام",
            "en" => "subAdmins"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.subAdmins.show"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "تعديل بيانات مشرف النظام",
            "en" => "Edit  SubAdmin"
        ],
        "module" => [
            "ar" => "مشرفي النظام",
            "en" => "subAdmins"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.subAdmins.edit",
            "admin.subAdmins.update"
        ],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "حذف مشرف النظام",
            "en" => "Delete SubAdmin"
        ],
        "module" => [
            "ar" => "مشرفي النظام",
            "en" => "subAdmins"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.subAdmins.destroy"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "عرض أدوار المشرفين",
            "en" => "All Roles"
        ],
        "module" => [
            "ar" => "أدوار المشرفين",
            "en" => "rules"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.rules.index"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "إنشاء دور",
            "en" => "Create Role"
        ],
        "module" => [
            "ar" => "أدوار المشرفين",
            "en" => "rules"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.rules.create",
            "admin.rules.store"
        ],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات الدور",
            "en" => "Show Role"
        ],
        "module" => [
            "ar" => "أدوار المشرفين",
            "en" => "rules"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.rules.show"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "تعديل الدور",
            "en" => "Edit Role"
        ],
        "module" => [
            "ar" => "أدوار المشرفين",
            "en" => "rules"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.rules.edit",
            "admin.rules.update"
        ],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "حذف الدور",
            "en" => "Delete Role"
        ],
        "module" => [
            "ar" => "أدوار المشرفين",
            "en" => "rules"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.rules.destroy"],
        "group" => "dashboard-users",
    ],
    [
        "name" => [
            "ar" => "عرض محافظ المتاجر",
            "en" => "All Vendors Wallets"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorWallets.index"],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => "استراد خصم من محافظ المتاجر",
            "en" => "Import discount from Vendors Wallets"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorWallets.import"],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات المحفظة",
            "en" => "Show Vendor Wallet"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendorWallets.show"],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => "تعديل حساب المحفظة",
            "en" => "Edit Vendor Wallet"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendorWallets.edit",
            "admin.vendorWallets.update"
        ],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => "عرض الإعدادات",
            "en" => "All Settings"
        ],
        "module" => [
            "ar" => "الإعدادات",
            "en" => "settings"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.settings.index"],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "تعديل الإعدادات",
            "en" => "Edit Setting"
        ],
        "module" => [
            "ar" => "الإعدادات",
            "en" => "settings"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.settings.edit",
            "admin.settings.update",
            "admin.settings.update-all"
        ],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "امر الصرف",
            "en" => "Dispensing Order"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.dispensingOrder.index", 'admin.dispensingOrder.store'],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => 'الأعتماد الأولى',
            "en" => "initialDispensingOrder"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.initialDispensingOrder.index", 'admin.initialDispensingOrder.change'],
        "group" => "vendors-finance",
    ],
    [
        "name" => [
            "ar" => 'الأعتماد النهائي',
            "en" => "initialDispensingOrder"
        ],
        "module" => [
            "ar" => "محافظ المتاجر",
            "en" => "vendorsWallets"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.finalDispensingOrder.index", 'admin.finalDispensingOrder.change'],
        "group" => "vendors-finance",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض الكوبونات",
    //         "en" => "All Coupons"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "Coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.coupons.index"],
    //     "group" => "Coupons",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إنشاء كوبون",
    //         "en" => "Create Coupon"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.coupons.create",
    //         "admin.coupons.store"
    //     ],
    //     "group" => "Coupons",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات الكوبون",
    //         "en" => "Show Coupon"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.coupons.show"],
    //     "group" => "Coupons",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل الكوبون",
    //         "en" => "Edit Coupon"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.coupons.edit",
    //         "admin.coupons.update"
    //     ],
    //     "group" => "Coupons",
    // ],
    // [
    //     "name" => [
    //         "ar" => "حذف الكوبون",
    //         "en" => "Delete Coupon"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.coupons.destroy"],
    //     "group" => "Coupons",
    // ],
    // [
    //     "name" => [
    //         "ar" => "الموافقة/رفض الكوبون",
    //         "en" => "Apporve|Reject Coupon"
    //     ],
    //     "module" => [
    //         "ar" => "الكوبونات",
    //         "en" => "coupons"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.coupons.change-status"],
    //     "group" => "Coupons",
    // ],
    [
        "name" => [
            "ar" => "عرض أدوار مستخدمي المتاجر",
            "en" => "All roles"
        ],
        "module" => [
            "ar" => "أدوار مستخدموا المتاجر",
            "en" => "vendorRoles"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.roles.index"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إنشاء دور",
            "en" => "Create Role"
        ],
        "module" => [
            "ar" => "أدوار مستخدموا المتاجر",
            "en" => "vendorRoles"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.roles.create",
            "admin.roles.store"
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "تعديل دور",
            "en" => "Edit Role"
        ],
        "module" => [
            "ar" => "أدوار مستخدموا المتاجر",
            "en" => "vendorRoles"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.roles.edit",
            "admin.roles.update"
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "حذف دور",
            "en" => "Delete Role"
        ],
        "module" => [
            "ar" => "أدوار مستخدموا المتاجر",
            "en" => "vendorRoles"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.roles.delete"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض مستخدموا المتاجر",
            "en" => "All Vendor Users"
        ],
        "module" => [
            "ar" => "مستخدموا المتاجر",
            "en" => "vendorUsers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendor-users.index"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إنشاء مستخدم",
            "en" => "Create Vendor User"
        ],
        "module" => [
            "ar" => "مستخدموا المتاجر",
            "en" => "vendorUsers"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendor-users.create",
            "admin.vendor-users.store"
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "تعديل مستخدم",
            "en" => "Edit User Vendor"
        ],
        "module" => [
            "ar" => "مستخدموا المتاجر",
            "en" => "vendorUsers"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendor-users.edit",
            "admin.vendor-users.update"
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "حذف مستخدم",
            "en" => "Delete Vendor User"
        ],
        "module" => [
            "ar" => "مستخدموا المتاجر",
            "en" => "vendorUsers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendor-users.delete"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إيقاف مستخدم",
            "en" => "Block Vendor User"
        ],
        "module" => [
            "ar" => "مستخدموا المتاجر",
            "en" => "vendorUsers"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.vendor-users.block"],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض المستودعات",
            "en" => "All Warehouses"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.warehouses.index", "admin.warehouses.export"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "إنشاء مستودع",
            "en" => "Create Warehouse"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.warehouses.create",
            "admin.warehouses.store"
        ],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات المستودع",
            "en" => "Show Warehouse"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.warehouses.show"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "تعديل المستودع",
            "en" => "Edit Warehouse"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.warehouses.edit",
            "admin.warehouses.update"
        ],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "حذف المستودع",
            "en" => "Delete Warehouse"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.warehouses.destroy"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "عرض جميع مناطق التوصيل",
            "en" => "Domestic Zone View"
        ],
        "module" => [
            "ar" => "مناطق التوصيل",
            "en" => "domestic-zone"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.domestic-zones.index"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "عرض منظقه التوصيل",
            "en" => "Domestic Zone ساخص"
        ],
        "module" => [
            "ar" => "مناطق التوصيل",
            "en" => "domestic-zone"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.domestic-zones.show"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "إضافة مناطق التوصيل",
            "en" => "Domestic Zone Create"
        ],
        "module" => [
            "ar" => "مناطق التوصيل",
            "en" => "domestic-zone"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.domestic-zones.create", "admin.domestic-zones.store"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "تعديل مناطق التوصيل",
            "en" => "Domestic Zone Edit"
        ],
        "module" => [
            "ar" => "مناطق التوصيل",
            "en" => "domestic-zone"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.domestic-zones.edit", "admin.domestic-zones.update"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "حذف مناطق التوصيل",
            "en" => "Domestic Zone Delete"
        ],
        "module" => [
            "ar" => "مناطق التوصيل",
            "en" => "domestic-zone"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.domestic-zones.destroy"],
        "group" => "delivery",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض شركات الشحن التابعة لطرود",
    //         "en" => "All Torod Shipping Companies"
    //     ],
    //     "module" => [
    //         "ar" => "شركة طرود",
    //         "en" => "torodCompanies"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.torodCompanies.index"],
    //     "group" => "delivery",
    // ],
    // [
    //     "name" => [
    //         "ar" => "إنشاء شركة",
    //         "en" => "Create Company"
    //     ],
    //     "module" => [
    //         "ar" => "شركة طرود",
    //         "en" => "torodCompanies"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.torodCompanies.create",
    //         "admin.torodCompanies.store"
    //     ],
    //     "group" => "delivery",
    // ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات شركة شحن",
    //         "en" => "Show Shipping Company Info"
    //     ],
    //     "module" => [
    //         "ar" => "شركة طرود",
    //         "en" => "torodCompanies"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.torodCompanies.show"],
    //     "group" => "delivery",
    // ],
    // [
    //     "name" => [
    //         "ar" => "تعديل بيانات شركة الشحن",
    //         "en" => "Edit Shipping Company Info"
    //     ],
    //     "module" => [
    //         "ar" => "شركة طرود",
    //         "en" => "torodCompanies"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.torodCompanies.edit",
    //         "admin.torodCompanies.update"
    //     ],
    //     "group" => "delivery",
    // ],
    // [
    //     "name" => [
    //         "ar" => "حذف شركة شحن",
    //         "en" => "Delete Shipping Company"
    //     ],
    //     "module" => [
    //         "ar" => "شركة طرود",
    //         "en" => "torodCompanies"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.torodCompanies.destroy"],
    //     "group" => "delivery",
    // ],

    [
        "name" => [
            "ar" => "اعدادت اراميكس",
            "en" => "Aramix Setting"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => ['admin.settings.aramex.index'],
        "group" => "delivery",
    ],
    // [
    //     "name" => [
    //         "ar" => "إحصائيات لوحة التحكم",
    //         "en" => "Dashboard Statistics"
    //     ],
    //     "module" => [
    //         "ar" => "إحصائيات لوحة التحكم",
    //         "en" => "dashboardStatistics"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.home", "admin.chartApi"],
    //     "group" => "settings",
    // ],
    [
        "name" => [
            "ar" => "عرض كل البنوك",
            "en" => "All Banks"
        ],
        "module" => [
            "ar" => "بنوك",
            "en" => "banks"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.banks.index"],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "إنشاء بنك",
            "en" => "Create Bank"
        ],
        "module" => [
            "ar" => "بنوك",
            "en" => "banks"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.banks.create",
            "admin.banks.store"
        ],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات بنك",
            "en" => "Show Bank Info"
        ],
        "module" => [
            "ar" => "بنوك",
            "en" => "banks"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.banks.show"],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "تعديل بيانات بنك",
            "en" => "Edit Bank Info"
        ],
        "module" => [
            "ar" => "بنوك",
            "en" => "banks"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.banks.edit",
            "admin.banks.update"
        ],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "حذف بنك",
            "en" => "Delete Bank"
        ],
        "module" => [
            "ar" => "بنوك",
            "en" => "banks"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.banks.destroy"],
        "group" => "settings",
    ],
    [
        "name" => [
            "ar" => "عرض كل شركات الشحن",
            "en" => "All Shipping Methods"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.shipping-methods.index"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "إنشاء شركة شحن",
            "en" => "Create Shipping Method"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.shipping-methods.create",
            "admin.shipping-methods.store"
        ],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "عرض بيانات شركة الشحن",
            "en" => "Show Shipping Method Info"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.shipping-methods.show"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "تعديل مناطق التوصيل الخاصة بشركة الشحن ",
            "en" => "Sync Zone"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.shipping-methods.sync-zones"],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "تعديل بيانات شركة الشحن",
            "en" => "Edit Shipping Method"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.shipping-methods.edit",
            "admin.shipping-methods.update"
        ],
        "group" => "delivery",
    ],
    [
        "name" => [
            "ar" => "حذف شركة الشحن",
            "en" => "Delete Shipping Method"
        ],
        "module" => [
            "ar" => "شركات الشحن",
            "en" => "Shipping Methods"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.shipping-methods.destroy"],
        "group" => "delivery",
    ],


    [
        "name" => [
            "ar" => "عرض جميع اسعار شحنات المدن",
            "en" => "All Shipping Line Prices"
        ],
        "module" => [
            "ar" => "الشحن بين المدن",
            "en" => "line shipping price"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.line_shipping_price.index"],
        "group" => "line_price_shipping",
    ],
    [
        "name" => [
            "ar" => "إنشاء مدن  للشحن",
            "en" => "Create Shipping Line Price"
        ],
        "module" => [
            "ar" => "الشحن بين المدن",
            "en" => "line shipping price"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.line_shipping_price.create",
            "admin.line_shipping_price.store"
        ],
        "group" => "line_price_shipping",
    ],
    // [
    //     "name" => [
    //         "ar" => "عرض بيانات مدينه للشحن",
    //         "en" => "Show Shipping Line Price"
    //     ],
    //     "module" => [
    //         "ar" => "الشحن بين المدن",
    //         "en" => "line shipping price"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => ["admin.line_shipping_price.show"],
    //     "group" => "line_price_shipping",
    // ],
    [
        "name" => [
            "ar" => "تعديل بيانات مدينه للشحن",
            "en" => "Edit Shipping Line Price"
        ],
        "module" => [
            "ar" => "الشحن بين المدن",
            "en" => "Shipping Line Prices"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.line_shipping_price.edit",
            "admin.line_shipping_price.update"
        ],
        "group" => "line_price_shipping",
    ],
    [
        "name" => [
            "ar" => "حذف مدينه",
            "en" => "Delete Shipping Line Price"
        ],
        "module" => [
            "ar" => "الشحن بين المدن",
            "en" => "Shipping Line Prices"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.line_shipping_price.destroy"],
        "group" => "line_price_shipping",
    ],
    // [
    //     "name" => [
    //         "ar" => "سعر المنتج طبقاً لكل دولة",
    //         "en" => "Countries prices For Product"
    //     ],
    //     "module" => [
    //         "ar" => "سعر المنتج طبقاً لكل دولة",
    //         "en" => "CountryPrices"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.products.prices.list",
    //         "admin.products.prices.store",
    //         "admin.products.prices.update",
    //         "admin.products.prices.create",
    //         "admin.products.prices.delete",
    //     ],
    //     "group" => "CountryPrices",
    // ],
    [
        "name" => [
            "ar" => "تقارير الكمية ",
            "en" => "Product Quantity Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.products_quantity",
        ],
        "group" => "reports",
    ],
    [
        "name" => [
            "ar" => "المنتجات اكثر مبيعا",
            "en" => "Most Selling Product Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.mostSellingProducts",
        ],
        "group" => "reports",
    ],
    [
        "name" => [
            "ar" => "المبيعات لكل تاجر",
            "en" => "Sales per vendors"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.SalesAllVendors",
            "admin.reports.SalesAllVendors.print",
        ],
        "group" => "reports",
    ],

    [
        "name" => [
            "ar" => "وسائل الدفع",
            "en" => "Payment Methods Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.PaymentMethods",
        ],
        "group" => "reports",
    ],

    // [
    //     "name" => [
    //         "ar" => "محافظ ارضاء العميل",
    //         "en" => "Satisfaction Clients Wallet Reports"
    //     ],
    //     "module" => [
    //         "ar" => "التقارير",
    //         "en" => "Reports"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.reports.SatisfactionClientsWallet",
    //     ],
    //     "group" => "reports",
    // ],

    [
        "name" => [
            "ar" => "طلبات مع الشحن",
            "en" => "Order Shipping Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.OrdersShipping",
        ],
        "group" => "reports",
    ],


    [
        "name" => [
            "ar" => "تقرير تكلفة الشحنه",
            "en" => "Product Quantity Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.ShippingCharges",
        ],
        "group" => "reports",
    ],


    [
        "name" => [
            "ar" => "تقرير تكلفه الشحنه (المستلمه )",
            "en" => "Product Quantity Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.ShippingChargesCompleted",
        ],
        "group" => "reports",
    ],


    [
        "name" => [
            "ar" => "تقرير تكلفه الشحنه (الغير المستلمه )",
            "en" => "Product Quantity Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.ShippingChargesWait",
        ],
        "group" => "reports",
    ],

    [
        "name" => [
            "ar" => " سحب ملف البنك",
            "en" => "Bank Reports"
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.vendors_earnings",
        ],
        "group" => "reports",
    ],
    [
        "name" => [
            "ar" => "    تقرير مبيعات المتاجر",
            "en" => "Vendor Reports Sales "
        ],
        "module" => [
            "ar" => "التقارير",
            "en" => "Reports"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.reports.vendors_sales",
            "admin.reports.vendors_sales_print"
        ],
        "group" => "reports",
    ],


    [
        "name" => [
            "ar" => "وثائق المتاجر",
            "en" => "Vendor Agreements"
        ],
        "module" => [
            "ar" => "وثائق-المتاجر",
            "en" => "vendors-agreements"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendors-agreements.index",
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إرسال وثيقة للمتجر",
            "en" => "Send Agreement To Vendor"
        ],
        "module" => [
            "ar" => "وثائق-المتاجر",
            "en" => "vendors-agreements"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendors-agreements.send-form",
            "admin.vendors-agreements.send",
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إلغاء إرسال الوثيقة",
            "en" => "Cancel Agreement Request"
        ],
        "module" => [
            "ar" => "وثائق-المتاجر",
            "en" => "vendors-agreements"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendors-agreements.cancel",
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "إعادة إرسال الوثيقة",
            "en" => "Resend Agreement Request"
        ],
        "module" => [
            "ar" => "وثائق-المتاجر",
            "en" => "vendors-agreements"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.vendors-agreements.resend",
        ],
        "group" => "vendors",
    ],
    [
        "name" => [
            "ar" => "عرض السيو للصفحات",
            "en" => "All Page Seo"
        ],
        "module" => [
            "ar" => "السيو للصفحات",
            "en" => "Page Seo"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.page-seo.index"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "إنشاء السيو للصفحة",
            "en" => "Create Page Seo"
        ],
        "module" => [
            "ar" => "السيو للصفحات",
            "en" => "Page Seo"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.page-seo.create",
            "admin.page-seo.store"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "عرض السيو للصفحة",
            "en" => "Show Page Seo"
        ],
        "module" => [
            "ar" => "السيو للصفحات",
            "en" => "Page Seo"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.page-seo.show"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "تعديل السيو للصفحة",
            "en" => "Edit Page Seo"
        ],
        "module" => [
            "ar" => "السيو للصفحات",
            "en" => "Page Seo"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.page-seo.edit",
            "admin.page-seo.update"
        ],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "حذف السيو للصفحة",
            "en" => "Delete Page Seo"
        ],
        "module" => [
            "ar" => "السيو للصفحات",
            "en" => "Page Seo"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.page-seo.destroy"],
        "group" => "static-content",
    ],
    [
        "name" => [
            "ar" => "الفاتورة الضريبية للطلب",
            "en" => "Tax Invoice"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.tax-invoices.show",
            "admin.tax-invoices.print",
            "admin.order-tax-invoices.print",
            "admin.international-tax-invoices.show",
            "admin.international-tax-invoices.print",
        ],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "الرسائل المثبتة",
            "en" => "Client Messages"
        ],
        "module" => [
            "ar" => "الرسائل",
            "en" => "Messages"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.client-messages.index",
        ],
        "group" => "client-messages",
    ],
    [
        "name" => [
            "ar" => "تعديل الرسائل المثبتة",
            "en" => "Edit Client Messages"
        ],
        "module" => [
            "ar" => "الرسائل",
            "en" => "Messages"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.client-messages.edit",
            "admin.client-messages.update",
        ],
        "group" => "client-messages",
    ],
    [
        "name" => [
            "ar" => "رسالة",
            "en" => "Client SMS"
        ],
        "module" => [
            "ar" => "رسالة",
            "en" => "SMS"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.client-sms.index",
        ],
        "group" => "client-messages",
    ],
    [
        "name" => [
            "ar" => "أرسل رسالة",
            "en" => "Send SMS"
        ],
        "module" => [
            "ar" => "رسالة",
            "en" => "SMS"
        ],
        "scope" => "sub-admin",
        "route" => [
            "admin.client-sms.sendsms", "admin.sendsms",
        ],
        "group" => "client-messages",
    ],
    // [
    //     "name" => [
    //         "ar" => "التقارير",
    //         "en" => "Reports"
    //     ],
    //     "module" => [
    //         "ar" => "التقارير",
    //         "en" => "Reports"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.reports.products_quantity"
    //     ],
    //     "group" => "reports",
    // ],


    // [
    //     "name" => [
    //         "ar" => "التقارير",
    //         "en" => "Reports"
    //     ],
    //     "module" => [
    //         "ar" => "التقارير",
    //         "en" => "Reports"
    //     ],
    //     "scope" => "sub-admin",
    //     "route" => [
    //         "admin.reports.products_quantity"
    //     ],
    //     "group" => "reports",
    // ],

    [
        "name" => [
            "ar" => "الاحصائيات",
            "en" => "Statistics"
        ],
        "module" => [
            "ar" => "الاحصائيات",
            "en" => "Statistics"
        ],
        "scope" => "sub-admin",
        "route" => [],
        "group" => "statistics",
    ],
    [
        "name" => [
            "ar" => "إلغاء الطلبات",
            "en" => "Cancel Transactions and Orders"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.cancel", "admin.transactions.cancelOrder", "admin.transactions.refundOrder"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "فشل الشحن",
            "en" => "Shipping orders failed"
        ],
        "module" => [
            "ar" => "الطلبات",
            "en" => "transactions"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.transactions.shipping_failed_orders", "admin.transactions.shipping_failed_orders.resend"],
        "group" => "transactions",
    ],
    [
        "name" => [
            "ar" => "مستودعات تم تحديثها",
            "en" => "Warehouses updated"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.warehouses.updated", "admin.warehouses.acceptUpdate", "admin.warehouses.refuseUpdate"],
        "group" => "warehouses",
    ],
    [
        "name" => [
            "ar" => "مستودعات في إنتظار الموافقة",
            "en" => "Warehouses pending"
        ],
        "module" => [
            "ar" => "المستودعات",
            "en" => "warehouses"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.warehouses.pending", "admin.warehouses.accepting", "admin.warehouses.reject"],
        "group" => "warehouses",
    ],

    [
        "name" => [
            "ar" => "فواتير العمولة",
            "en" => "Invoices"
        ],
        "module" => [
            "ar" => "فواتير العمولة",
            "en" => "invoices"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.invoices.index", "admin.invoices.create", "admin.invoices.store", "admin.invoices.show"],
        "group" => "invoices",
    ],
    [
        "name" => [
            "ar" => "تصدير فواتير العمولة",
            "en" => "Invoices"
        ],
        "module" => [
            "ar" => "فواتير العمولة",
            "en" => "invoices"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.invoices.export-pdf"],
        "group" => "invoices",
    ],
    [
        "name" => [
            "ar" => "الخدمات",
            "en" => "Services"
        ],
        "module" => [
            "ar" => "الخدمات",
            "en" => "Services"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.services"],
        "group" => "services",
    ],
    [
        "name" => [
            "ar" => "طلبات الخدمات",
            "en" => "order-services"
        ],
        "module" => [
            "ar" => "طلبات الخدمات",
            "en" => "order-services"
        ],
        "scope" => "sub-admin",
        "route" => ["admin.service-transactions"],
        "group" => "transactions",
    ],
    //notice: not modify name->ar and module->ar and group
];
