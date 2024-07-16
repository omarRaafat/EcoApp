<?php

use App\Enums\CustomerWithdrawRequestEnum;
use App\Enums\OrderStatus;
use App\Enums\ShippingMethodType;

return [
    /* General phrases */
    "success" => "Success",
    "error" => "Error",
    "create_success" => "Created successfully",
    "update_success" => "Updated successfully",
    "delete_success" => "Deleted successfully",
    "warehouse_status" => "Status",
    "warehouse_active" => "Active",
    "warehouse_inactive" => "InActive ",
    "dashboard" => "control Board",
    "menu" => "control list",
    "name" => "the name",
    "name_ar" => "The name is in Arabic",
    "name_en" => "The name is in English",
    "image" => "Image",
    "phone" => "cell phone",
    "email" => "email",
    "email_placeholder" => "Enter email",
    "password_placeholder" => "Enter the password",
    "forgot_password" => "Forgot your password ?",
    "forgot_password_email" => "Password recovery",
    "forgot_password_email_notes" =>
        "You can reset your password from the link below:",
    "forgot_password_notes" =>
        "Enter your email and password reset instructions will be sent to this email",
    "password" => "password",
    "new_password" => "password",
    "confirm_new_password" => "password confirmation",
    "password_reset" => "Reset the password",
    "confirm_new_password_placeholder" => "Enter confirm password",
    "remember_me" => "Remember me",
    "sign_in" => "sign in",
    "sign" => "entrance",
    "close" => "Close",
    "add" => "Add",
    "save" => "save",
    "reset" => "Reset",
    "back" => "Return",
    "create" => "construction",
    "edit" => "amendment",
    "send" => "send",
    "desc_order" => "descending",
    "asc_order" => "Progressive",
    "not_found" => "unavailable",
    "order_placed" => "The time the request was sent",
    "an_order_has_been_placed" => "The request has been sent from the client",
    "admin" => "admin",
    "price" => "the price",
    "errors" => "incorrect data",
    "remember_login" => "Did you remember your data?",
    "actions" => "procedures",
    "yes" => "Yes",
    "no" => "no",
    "quantity" => "Quantity",
    "last_update" => "Last updated",
    "payment_data" => "payment data",
    "address_data" => "Location and address data",
    "created_at" => "Date created",
    "Showing" => "review",
    "to" => "to",
    "of" => "from",
    "from" => "from",
    "results" => "Results",
    "select" => "Choose",
    "welcome" => "Hello",

    /* Line shipping price */
    "line_shipping_price" => "Line shipping price",
    "city_from" => "city from",
    "city_to" => "city to",
    "dyna" => "Dyna",
    "lorry" => "Lorry",
    "truvk" => "Truck",

    /* Notifications phrases */
    "notifications" => [
        "unread" => "Unread notifications",
        "notifications" => "Notices",
        "vendor" => [
            "modify" => [
                "title" => "Store data",
                "message" => "Store data has been modified by management",
            ],
            "warning" => [
                "title" => "Warning from management",
            ],
            "product" => [
                "approve" => [
                    "title" => "Product approved:",
                    "message" =>
                        "Product modifications are approved by management",
                ],
                "reject" => [
                    "title" => "Product rejected:",
                    "message" =>
                        "Modifications to the product have been rejected by management",
                ],
                "modify" => [
                    "title" => "Edit a product:",
                    "message" => "The product has been modified by management",
                ],
            ],
            "order" => [
                "created" => [
                    "title" => "new request",
                    "message" =>
                        "A new request has been created with the code=>#",
                ],
            ],
            "admin" => [
                "transaction" => [
                    "created" => [
                        "title" => "new request",
                        "message" =>
                            "A new request has been created with the code=>#",
                    ],
                ],
            ],
        ],
    ],
    /* Vendor phrases */

    "vendor_website" => "website",
    "vendors" => "Shops",
    "vendors_list" => "All stores",
    "vendors_show" => "store view",
    "vendors_edit" => "Store modification",
    "vendor_logo" => "Store logo",
    "vendor_owner_name" => "Store owner name",
    "vendor_name" => "Store name",
    "vendor_phone" => "cell phone",
    "vendor_second_phone" => "additional mobile",
    "vendor_tax_number" => "Tax Number",
    "vendor_tax_certificate" => "Value added tax certificate",
    "vendor_iban_certificate" => "IBAN certificate",
    "vendor_commercial_register" => "commercial register",
    "vendor_commercial_register_date" =>
        "The expiry date of the commercial registration",
    "vendor_bank" => "Bank name",
    "vendor_bank_number" => "Bank account number",
    "vendor_broc" => "Brand ownership certificate",
    "vendor_iban" => "IBAN number",
    "vendor_email" => "Store email",
    "vendor_password" => "password",
    "vendor_password_confirm" => "password confirmation",
    "vendor_address" => "the address",
    "vendor_admin_percentage" => "management percentage",
    "vendor_admin_percentage_order" => "Ranking by management percentage",
    "vendor_admin_percentage_hint" =>
        "Put the management percentage of the seller's sales",
    "vendor_wallet" => "Portfolio",
    "vendor_products" => "client products",
    "vendor_rate" => "Evaluation",
    "vendor_sales" => "the sales",
    "vendor_description" => "Store description",
    "vendor_external_warehouse" => "external warehouses",
    "vendor_status" => "Store status",
    "vendor_registration_date" => "date of registration",
    "vendor_active" => "Enabled",
    "vendor_inactive" => "Not enabled",
    "vendor_pending" => "Store approval is pending",
    "vendor_approved" => "The store has been approved",
    "vendor_not_approved" => "Store refused",
    "vendor_warnings" => "Store warnings",
    "vendor_warning" => "The warning",
    "vendor_warning_new" => "New warning",
    "vendor_warning_new_add" => "Add a new warning",
    "vendor_warning_date" => "Warning date",
    "vendor_warning_send" =>
        "A warning has been sent to the store successfully",
    "vendor_active_on" => "The store is activated",
    "vendor_active_off" => "Store is disabled",
    "vendor_commission" =>
        "Management percentage of the sale price (%) (purchase from the platform)",
    "vendor_is_international" => "Enable the store to deal internationally",
    /* Order phrases */

    "transactions" => "Requests",
    "transaction_edit" => "amendment",
    "transactions_list" => "All requests",
    "delivery_fees" => "Delivery charges",
    "city" => "City",
    "payment_method" => "payment method",
    "total" => "The total amount",
    "total_sub" => "The amount paid",
    "paid_amount" => "The amount paid",
    "coupon-discount" => "discount amount",
    "vendors_count" => "Number of sellers",
    "shipping" => "Shipping",
    "all" => "everyone",
    "registered" => "registered",
    "shipping_done" => "it is charged",
    "in_delivery" => "It is connected",
    "completed" => "completed",
    "canceled" => "Canceled",
    "refund" => "throwback",
    "transaction_show" => "Watch the request",
    "transaction_main_details" => "Master order data",
    "transaction_id" => "request code",
    "transaction_date" => "The date of application",
    "transaction_status" => "Order status",
    "transaction_note" => "Notes on ordering",
    "transaction_customer_filter_placeholder" =>
        "Search by customer number or name",
    "transaction_id_filter_placeholder" => "Search by request code",
    "transaction_not_has_ship" =>
        "The order does not have a tracking number for the shipment, which means that it was not sent to the shipping company",
    "transaction_status_not_high" =>
        "The application status cannot be converted to a previous one",
    "transaction_vendor_product" => "shop products (:vendor)",
    'transaction_gateway_id' => 'Gateway transaction id',
    "transaction_invoice" => [
        "app_name" => "The National Center for Palms and Dates",
        "title" => "the demand",
        "header_title" => "order request",
        "invoice_brief" => "Order summary",
        "address" => "the address",
        "zip_code" => "Post number",
        "legal_registration_no" => "Legal registration number",
        "client_name" => "The recipient",
        "client_sale" => "the buyer",
        "email" => "E-mail",
        "bill_info" => "Buyer data",
        "ship_info" => "Recipient data",
        "website" => "the site",
        "contact_no" => "contact number",
        "invoice_no" => "order number",
        "date" => "The date of application",
        "payment_status" => "reimbursement status",
        "total_amount" => "total order",
        "shipping_address" => "Shipping Address",
        "phone" => "cell phone",
        "sub_total" => "Sub price",
        "estimated_tax" => "Tax",
        "tax_no" => "Tax Number",
        "discount" => "Discount",
        "shipping_charge" => "shipping fee",
        "download" => "download request",
        "print" => "Print the request",
        "not_found" => "There are no products for this order",
        "shipment_no" => "delivery number",
        "payment_type" => "payment method",
        "sub_from_wallet" => "deducted from the wallet",
        "sub_total_without_vat" => "The total does not include tax",
        "vat_percentage" => "tax rate",
        "vat_rate" => "tax value",
        "products_table_header" => [
            "product_details" => "the product",
            "rate" => "unit price",
            "quantity" => "Quantity",
            "amount" => "The total does not include tax",
            "tax_ratio" => "tax rate",
            "tax_value" => "tax value",
            "barcode" => "barcode",
            "total_with_tax" => "The total is inclusive of tax",
        ],
    ],
    /* customer phrases */

    "customers_list" => "clients",
    "customer_details" => "Customer data",
    "customer_name" => "customer name",
    "customer_phone" => "Customer's mobile number",
    "customer_email" => "Customer's email",
    "customer_avatar" => "customer photo",
    "customer_addresses_count" => "number of addresses",
    "customer_transactions_count" => "The number of orders",
    "customer_warnings_count" => "The number of reports",
    "customer_priority" => "Customer importance",
    "customer_banned" => "Client ban",
    "customer_last_login" => "last entry",
    "customer_last_activity" => "last activity",
    "customer_change_priority_message" =>
        "Customer importance has been successfully changed",
    "customer_perfect" => "ideal",
    "customer_important" => "Important",
    "customer_show" => "Customer data",
    "customer_edit" => "Modify customer data",
    "customer_regular" => "normal",
    "customer_parasite" => "Parasitical",
    "customer_caution" => "Take care of it",
    "customer_noDeal" => "Not dealing with it",
    "customer_unblocked" => "The ban has been lifted from the client",
    "customer_blocked" => "The client has been blocked",
    "customer_new_password" =>
        "(leave it blank if you haven't changed it) Password",
    "customer_confirm_new_password" => "password confirmation",
    "customer_registration_date" => "date of registration",
    "customer_addresses" => "client addresses",
    "price_before_offer" => "Price before bid",
    /* addresses phrases */

    "address_description" => "Title description",
    "edits_history" => "Change log",
    "address_type" => "Address type",
    "address_id" => "Address ID number",
    "desc_en" => "Description in English",
    "desc_ar" => "Description in Arabic",
    "category_id" => "main section",
    "sub_category_id" => "First subsection",
    "final_category_id" => "last subsection",
    "type_id" => "class",
    "order" => "arrangement",
    "width" => "the offer",
    "height" => "height",
    "length" => "height",
    "total_weight" => "the total weight",
    "net_weight" => "net weight",
    "quantity_bill_count" => "The number of the quantity",
    "bill_weight" => "The number of the quantity",
    "customer_finances" => [
        "title" => "customer finances",
        "payment_methods" => [
            "cash" => "cash",
            "visa" => "Visa",
            "wallet" => "Portfolio",
            'tabby' => 'tabby',
        ],
        "wallets" => [
            "all_wallets" => "All conservative",
            "id" => "Wallet ID",
            "create" => "Create a new wallet",
            "edit" => "Modify the client's portfolio",
            "manage" => "Client portfolio management",
            "delete" => "Delete the wallet",
            "import" => "import wallets",
            "search" => "Search in portfolios",
            "title" => "Customer satisfaction portfolios",
            "single_title" => "client wallet",
            "customer_name" => "customer name",
            "attachments" => "attachments",
            "no_attachments" => "There are no attachments",
            "by_admin" => "by",
            "is_active" => "activation status",
            "last_update" => "Last updated",
            "active" => "active",
            "inactive" => "not active",
            "choose_state" => "Select wallet status",
            "choose_customer" => "Choose a client",
            "amount" => "balance",
            "reason" => "the reason",
            "created_at" => "The date the wallet was created",
            "created_at_select" => "Choose a date",
            "all" => "everyone",
            "filter" => "filtering",
            "no_result_found" => "No results found",
            "attachment" => "attachments",
            "has_attachment" => "Attachment preview",
            "has_no_attachment" => "There are no attachments",
            "change_status" => "Change wallet status",
            "manage_wallet_balance" => "Wallet balance management",
            "current_wallet_balance" => "current wallet balance",
            "wallet_balance" => "wallet balance",
            "wallets_transactions" => [
                "title" => "portfolio transactions",
                "single_title" => "wallet transaction",
                "customer_name" => "customer name",
                "wallet_id" => "Wallet ID",
                "type" => "Type of transaction",
                "amount" => "The amount of the transaction",
                "transaction_date" => "Transaction date",
            ],
            "validations" => [
                "customer_id_required" => "Customer field is required",
                "customer_id_unique" =>
                    "It is not possible to create more than one wallet for one customer",
            ],
            "messages" => [
                "created_successfully_title" => "New client portfolio",
                "created_successfully_body" =>
                    "A new client portfolio has been created successfully",
                "created_error_title" => "Client wallet creation failed",
                "created_error_body" => "Creating a new client wallet failed",
                "updated_successfully_title" =>
                    "Modify the status of a client's portfolio",
                "updated_successfully_body" =>
                    "The status of a customer's wallet has been modified successfully",
                "updated_error_title" =>
                    "Failed to modify the state of a client's wallet",
                "updated_error_body" =>
                    "The operation to modify the state of a client's wallet failed",
                "customer_has_wallet_title" =>
                    "A wallet cannot be created for this customer",
                "customer_has_wallet_message" =>
                    "It is not possible to create a wallet for this customer because he already owns one",
            ],
            "customer_info" => [
                "email" => "Mail",
                "phone" => "cell phone",
            ],
            "transaction" => [
                "title" => "Wallet balance management",
                "wallet_transactions_log" => "Wallet transaction history",
                "id" => "Transaction ID",
                "type" => "Type of transaction",
                "choose_type" => "Choose the type of transaction",
                "amount" => "Transaction value",
                "date" => "Transaction date",
                "add" => "Add +",
                "sub" => "rival -",
                "success_add_title" => "Successful credit adding process",
                "success_add_message" =>
                    "The customer's card has been successfully credited",
                "success_sub_title" => "Successful credit deduction",
                "success_sub_message" =>
                    "The customer's card balance has been debited successfully",
                "fail_add_title" => "Add credit failed",
                "fail_add_message" => "Credit card credit operation failed",
                "fail_sub_title" => "Balance deduction failed",
                "fail_sub_message" => "Debiting the customer's card failed",
                "cannot_subtract_message" =>
                    "The card balance is less than the discount values",
                "user_id" => "The process was done by",
                "transaction_type" => [
                    "title" => "Operation type",
                    "choose_transaction_type" => "Choose the type of operation",
                    "purchase" => "buy products",
                    "gift" => "gift",
                    "bank_transfer" => "Bank transfer",
                    "compensation" => "compensation",
                    "sales_balance" => "Sales balance",
                ],
                "opening_balance" => "Opening balance",
                "validations" => [
                    "amount_required" => "Transaction value field is required",
                    "amount_numeric" =>
                        "The transaction value must be a numeric value",
                    "type_required" => "Transaction type field is required",
                    "type_numeric" => "You must select the type of transaction",
                    "transaction_type_required" =>
                        "Operation type field is required",
                    "transaction_type_numeric" =>
                        "The type of operation must be selected",
                ],
                "save" => "Save the process",
            ],
        ],
    ],
    "customer-cash-withdraw" => [
        "page-title" => "Customer balance withdrawal requests",
        "show-page-title" => "Request to withdraw the customer's balance",
        "status" => "Order status",
        "approved" => "acceptable",
        "not-approved" => "unacceptable",
        "customer-name-search" => "Search by customer name or mobile number",
        "customer-name" => "customer name",
        "customer-phone" => "Customer mobile",
        "customer-balance" => "Client wallet balance",
        "request-id" => "order number",
        "request-amount" => "order amount",
        "request-bank-name" =>
            "The name of the bank to which it is transferred",
        "admin-approved" => "Been approved",
        "admin-not-approved" => "access denied",
        "all-status" => "all cases",
        "statuses" => [
            CustomerWithdrawRequestEnum::PENDING =>
                "The receipt of the request",
            CustomerWithdrawRequestEnum::APPROVED =>
                "The request has been executed",
            CustomerWithdrawRequestEnum::NOT_APPROVED =>
                "reques has been rejected",
        ],
        "request-bank-account-name" => "Account Holder's Name",
        "request-bank-account-iban" =>
            "The IBAN number to which it is transferred",
        "reject-reason" => "the reason of refuse",
        "rejected-by" => "Rejected by",
        "save-status" => "Modify the status of the request",
        "bank-receipt" => "Transfer receipt attached",
        "validations" => [
            "status-required" => "Transfer request status is required",
            "status-in" => "The status of the transfer request must be (Executed, Rejected or Received)",
            "reject_reason-required_if" => "Reason for refusal is required",
            "bank_receipt-required_if" => "Transfer receipt attachment is required",
            'bank_receipt-mimes' => "Bank transfer receipt must be one of those extensions (pdf, png, jpg)",
            "bank_receipt-image" => "The transfer receipt attachment must be a copy",
            "bank_receipt-max" => "The maximum size of the transfer receipt attachment is 2MB",
            "transaction_type-required_if" => "The type of operation required",
            "transaction_type-in" =>
                "The operation type must be one of the available types",
        ],
        "messages" => [
            "status-not-pending" =>
                "This request cannot change its status because it has already been changed",
            "status-set-to-not-approved" =>
                "The status of the rejected request has been modified successfully",
            "status-set-to-approved" =>
                "The status of the request has been modified successfully",
        ],
        "manage_wallet_balance" => "Client portfolio management",
    ],
    "categories" => [
        "title_main" => "Categories and sections",
        "title" => "sections",
        "single_title" => "Section",
        "all_categories" => "All Sections",
        "choose_search_lang" => "Choose the name language",
        "manage_categories" => "Department management",
        "id" => "Department ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "slug_ar" => "Section link in Arabic",
        "slug_en" => "Section link in English",
        "level" => "the level",
        "parent_id" => "Follow the section",
        "child_id" => "belong to a subsection",
        "is_active" => "the condition",
        "active" => "active",
        "inactive" => "Inactive",
        "edit_child" => "Edit subsection",
        "edit_sub_child" => "Modify the last subsection",
        "order" => "ranking",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new section",
        "update" => "Modify a section",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "created_at_select" => "Choose a date",
        "parent_name_ar" => "The name of the main department in Arabic",
        "parent_name_en" => "The name of the main department in English",
        "not_found" => "nothing",
        "parent" => "the main",
        "child" => "sub",
        "subchild" => "Final",
        "child_count" => "The number of subsections",
        "show" => "View section data",
        "delete" => "delete",
        "arabic_date" => "Arabic data",
        "english_date" => "Data in English",
        "choose_category" => "Choose a department",
        "choose_sub_category" => "Select a subsection",
        "choose_level" => "Select the department level",
        "image_for_show" => "section image",
        "image" => "Select the section image",
        "image_title" => "Drag the section image here",
        "delete_modal" => [
            "title" => "Are you about to delete a section?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The section has been created successfully",
            "created_successfully_body" =>
                "The section has been created successfully",
            "created_error_title" => "Error creating partition",
            "created_error_body" =>
                "An error occurred while creating the partition",
            "updated_successfully_title" =>
                "The section has been modified successfully",
            "updated_successfully_body" =>
                "The section has been modified successfully",
            "updated_error_title" => "Error while modifying partition",
            "updated_error_body" =>
                "An error occurred while modifying the partition",
            "deleted_successfully_title" =>
                "The section has been deleted successfully",
            "deleted_successfully_message" =>
                "The section has been deleted successfully",
            "deleted_error_title" => "Error deleting partition",
            "deleted_error_message" =>
                "Something went wrong while deleting the partition",
        ],
        "validations" => [
            "name_ar_required" => "Department name in Arabic is required",
            "name_ar_string" =>
                "The name of the Arabic section must be a string",
            "name_ar_min" =>
                "The minimum number of letters for the Arabic department name is at least 3 letters",
            "name_en_required" => "Department name in English is required",
            "name_en_string" => "The English section name must be a string",
            "name_en_min" =>
                "The least number of letters in the name of the English department is at least 3 letters",
            "slug_ar_required" => "Section link in Arabic is required",
            "slug_ar_string" =>
                "The link for the Arabic section must be a string",
            "slug_en_min" =>
                "The minimum number of characters for the Arabic section link is at least 3 letters",
            "slug_en_required" => "Section link in English is required",
            "slug_en_string" =>
                "Section URL must be in the form of a text string",
            "slug_en_min" =>
                "The minimum number of characters for the section link in English is at least 3 characters",
            "level_numeric" => "The partition level must be of numeric type",
            "level_between" =>
                "The section level should be (Main - Sub - Sub - Final)",
            "parent_id_numeric" =>
                "The partition identifier with the highest numeric value",
            "parent_id_exists" => "Section not found",
            "is_featured_boolean" => "The value of this field must be numeric",
            "is_active_boolean" => "The value of this field must be numeric",
            "order_unique" => "Section order cannot be repeated",
            "image_required" => "Section Image field is required",
            "image_image" => "The file must be of image type",
            "image_mimes" => "Accepted extensions=>jpeg, png, jpg, gif, svg",
            "image_max" => "The maximum image size is 2048 KB",
        ],
    ],
    /* product phrases */
    "productClasses" => [
        "name" => "name",
        "title" => "categories",
        "single_title" => "class",
        "all_productClasses" => "All categories",
        "manage_productClasses" => "Categories management",
        "id" => "Category ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new category",
        "update" => "Class modification",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "created_at_select" => "Choose a date",
        "not_found" => "nothing",
        "show" => "View category data",
        "delete" => "delete",
        "delete_modal" => [
            "title" => "Are you about to delete a category?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Category created successfully",
            "created_successfully_body" => "Category created successfully",
            "created_error_title" => "Error creating class",
            "created_error_body" => "An error occurred creating the category",
            "updated_successfully_title" =>
                "The category has been modified successfully",
            "updated_successfully_body" =>
                "The category has been modified successfully",
            "updated_error_title" => "Error while modifying class",
            "updated_error_body" =>
                "An error occurred while modifying the category",
            "deleted_successfully_title" =>
                "The category has been deleted successfully",
            "deleted_successfully_message" =>
                "The category has been deleted successfully",
            "deleted_error_title" => "Error deleting category",
            "deleted_error_message" =>
                "An error occurred while deleting the category",
        ],
        "validations" => [
            "name_ar_required" => "Category name in Arabic is required",
            "name_ar_string" => "The Arabic class name must be of type String",
            "name_ar_min" =>
                "The minimum number of letters for the Arabic category name is at least 3 letters",
            "name_en_required" => "Category name in English is required",
            "name_en_string" => "The English class name must be of type String",
            "name_en_min" =>
                "The minimum number of letters in the English category name is at least 3 letters",
        ],
    ],
    "products" => [

        "with_note" => "With Note",
        "without_note" => "Without Note",

        "edit_your_reject_reason" => 'Edit Your Reject Reason',

        "title" => "products",
        "single_title" => "the product",
        "all_products" => "All products",
        "manage_products" => "Product management",
        "in_review_products" => "Products under review",
        "id" => "Product ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "follow_edits" => "Follow up on modifications",
        "desc_ar" => "Product Description in Arabic",
        "desc_en" => "Product description in English",
        "is_featured" => "Featured product",
        "is_active" => "the condition",
        "active" => "active",
        "inactive" => "Inactive",
        "price" => "the price",
        "unitPrice" => "unit price",
        "total" => "The total price of the product",
        "order" => "ranking",
        "category" => "Section",
        "vendor" => "the shop",
        "pending" => "my neighbour",
        "in_review" => "under evaluation",
        "held" => "hanging",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new product",
        "update" => "Modify a product",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "created_at_select" => "Choose a date",
        "not_found" => "nothing",
        "show" => "an offer",
        "delete" => "delete",
        "edit" => "amendment",
        "vendor_id" => "the shop",
        "arabic_date" => "Arabic data",
        "english_date" => "Data in English",
        "choose_category" => "Choose a department",
        "image" => "Choose the product image",
        "image_title" => "Drag the product image here",
        "accepting" => "Product acceptance",
        "re-pending" => "Select the product as a running product",
        "field_changed" => "Changes done",
        "images" => "Product pictures",
        "reject" => "Reject modifications",
        "write_your_reject_reason" => "Write the reason for rejection",
        "reject_reason" => "Reject modifications",
        "reject_confirm" => "Confirm rejection",
        "accept_update" => "Accept modifications",
        "updated_products" => "Updated products",
        "pending_products" => "Products pending",
        "delete_modal" => [
            "title" => "Are you about to delete a product?",
            "description" =>
                "Deleting your order will remove all information for that product.",
        ],
        "messages" => [
            "created_successfully_title" => "Product created successfully",
            "created_successfully_body" => "Product created successfully",
            "created_error_title" => "Error creating product",
            "created_error_body" =>
                "An error occurred while creating the product",
            "updated_successfully_title" =>
                "The product has been modified successfully",
            "updated_successfully_body" =>
                "The product has been modified successfully",
            "updated_error_title" => "Error while modifying the product",
            "updated_error_body" =>
                "An error occurred while modifying the product",
            "deleted_successfully_title" =>
                "The product has been successfully deleted",
            "deleted_successfully_message" =>
                "The product has been successfully deleted",
            "deleted_error_title" => "Error while deleting the product",
            "deleted_error_message" =>
                "An error occurred while deleting the product",
            "status_changed_successfully_title" =>
                "The product status has been modified successfully",
            "status_approved_successfully_title" =>
                "The product has been successfully accepted",
        ],
        "print-barcode" => "Barcode printing",
        "barcode" => "barcode",
        "image-validation" =>
            "The minimum width of the image must be 800 pixels, and the minimum height of the image must be 800 pixels",
        "image-validation-width" =>
            "The minimum width of the image must be 800 pixels",
        "image-validation-height" =>
            "The minimum image length must be 800 pixels",
        "image-validation-max" => "Images must be less than 1500 KB",
        "product_details" => "Product details",
        "product_price" => "Product price",
        "product_quantity" => "Quantity",
        "product_reviews" => "Ratings",
        "product_price_final" => "The final price includes tax",
        "prices" => [
            "countries" => "Product price according to each country",
        ],
        "warehouse-stock" => "Stock for each warehouse",
        "warehouse-no-stock" => "No stock available at warehouses",
        "warehouse-name" => "Warehouse name",
        "stock" => "Stock",
        "add-warehouse-stock" => "Add new stock",
        "stock-updated" => "Warehouse stock for product updated :warehouse",
    ],
    "countries_and_cities_title" => "states and cities",
    "coupons_title" => "coupons",
    "countries" => [
        "name" => "name",
        "title" => "Countries",
        "single_title" => "Country",
        "all_countries" => "All countries",
        "manage_countries" => "States management",
        "id" => "Country ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "No",
        "create" => "Create New Country",
        "update" => "Edit Country",
        "search" => "Search",
        "all" => "All",
        "filter" => "Filter",
        "is_active" => "State",
        "active" => "Active",
        "inactive" => "Inactive",
        "not_found" => "Not Found",
        "show" => "Show All Country Info",
        "delete" => "Delete",
        "filter_is_active" => "Filter Using State",
        "code" => "Code",
        "choose_state" => "Choose The State Of The Country",
        "country_cities" => "Country Cities",
        "city_id" => "ID",
        "city_name" => "City Name",
        "spl_id" => "SPL ID",
        "country_areas" => "regions of the state",
        "area_id" => "Region ID",
        "area_name" => "Area name",
        "national" => "local",
        "not_national" => "non-local",
        "is_national" => "Is the country local?",
        "delete_modal" => [
            "title" => "Are you about to delete a country?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The state has been created successfully",
            "created_successfully_body" =>
                "The state has been created successfully",
            "created_error_title" => "Error creating the state",
            "created_error_body" =>
                "Something went wrong while creating the state",
            "updated_successfully_title" =>
                "The state has been modified successfully",
            "updated_successfully_body" =>
                "The state has been modified successfully",
            "updated_error_title" => "Error while modifying the state",
            "updated_error_body" =>
                "An error occurred while modifying the country",
            "deleted_successfully_title" =>
                "The country has been deleted successfully",
            "deleted_successfully_message" =>
                "The country has been deleted successfully",
            "deleted_error_title" => "Error while deleting the country",
            "deleted_error_message" =>
                "An error occurred while deleting the country",
        ],
        "validations" => [
            "name_ar_required" => "Country name in Arabic is required",
            "name_ar_string" => "The Arabic country name must be a string",
            "name_ar_min" =>
                "The minimum number of letters in the name of the Arab country is at least 3 letters",
            "name_en_required" => "Country name in English is required",
            "name_en_string" => "The English country name must be a string",
            "name_en_min" =>
                "The least number of letters in the English country name is at least 3 letters",
            "code_required" => "Country code is required",
            "code_string" => "The country code must be of type String",
            "code_min" =>
                "The minimum number of characters for the country code is at least 2 characters",
        ],
        "vat_percentage" => "VAT (%)",
        "code_min" =>
            "The minimum number of characters for the country code is at least 2 characters",
        "at-least-a-national-country" => "System must have at least one national country",
    ],
    "vat_percentage" => "VAT (%)",

    "cities" => [
        "name" => "name",
        "title" => "the cities",
        "single_title" => "City",
        "all_cities" => "All cities",
        "manage_cities" => "Cities management",
        "id" => "City ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new city",
        "update" => "Modify a city",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View city data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "choose_state" => "Select the state of the city",
        "choose_area" => "Select the region",
        "area_id" => "Region",
        "torod_city_id" => "The city identifier of the parcel company",
        "areas_cities" => "The city's areas",
        "delete_modal" => [
            "title" => "Are you about to delete a city?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The city has been successfully established",
            "created_successfully_body" =>
                "The city has been successfully established",
            "created_error_title" => "Error creating city",
            "created_error_body" =>
                "Something went wrong while creating the city",
            "updated_successfully_title" =>
                "The city has been modified successfully",
            "updated_successfully_body" =>
                "The city has been modified successfully",
            "updated_error_title" => "Error while modifying the city",
            "updated_error_body" =>
                "An error occurred while modifying the city",
            "deleted_successfully_title" =>
                "The city has been successfully deleted",
            "deleted_successfully_message" =>
                "The city has been successfully deleted",
            "deleted_error_title" => "Error while deleting the city",
            "deleted_error_message" =>
                "An error occurred while deleting the city",
            "cannot_delete_city_title" => "You cannot delete the city",
            "cannot_delete_city_body" =>
                "You cannot delete a city associated with a delivery area",
        ],
        "validations" => [
            "name_en_required" => "City name in Arabic is required",
            "name_en_string" => "The Arabic city name must be a string",
            "name_ar_min" =>
                "The minimum number of letters in the Arabic city name is at least 3 letters",
            "name_en_required" => "City name in English is required",
            "name_en_string" => "The English city name must be a string",
            "name_en_min" =>
                "The least number of letters in the English city name is at least 3 letters",
            "country_id_required" => "The state is required",
            "torod_city_id_string" =>
                "The parcel company's city identifier must be a text value",
        ],
    ],
    "areas" => [
        "title" => "Regions",
        "single_title" => "Region",
        "all_areas" => "All speaking",
        "manage_areas" => "Speaker management",
        "id" => "Region ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new region",
        "update" => "edit area",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View area data",
        "delete" => "delete",
        "choose_state" => "Select the state of the region",
        "choose_country" => "Select country",
        "country_id" => "Country",
        "is_active" => "the condition",
        "active" => "active",
        "inactive" => "not active",
        "delete_modal" => [
            "title" => "You are about to delete pixelated",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The area has been created successfully",
            "created_successfully_body" =>
                "The area has been created successfully",
            "created_error_title" => "Error creating region",
            "created_error_body" =>
                "An error occurred while creating the region",
            "updated_successfully_title" =>
                "The region has been modified successfully",
            "updated_successfully_body" =>
                "The region has been modified successfully",
            "updated_error_title" => "Error while modifying the region",
            "updated_error_body" =>
                "An error occurred while modifying the region",
            "deleted_successfully_title" =>
                "The region has been deleted successfully",
            "deleted_successfully_message" =>
                "The region has been deleted successfully",
            "deleted_error_title" => "Error while deleting the region",
            "deleted_error_message" =>
                "An error occurred while deleting the region",
        ],
        "validations" => [
            "name_ar_required" =>
                "The name of the region in Arabic is required",
            "name_ar_string" => "The Arabic region name must be a string",
            "name_ar_min" =>
                "The minimum number of letters in the name of the Arabic region is at least 3 letters",
            "name_en_required" =>
                "The name of the region in English is required",
            "name_en_string" => "The English region name must be a string",
            "name_en_min" =>
                "The least number of letters in the English name of the region is at least 3 letters",
            "country_id_required" => "The state is required",
        ],
    ],
    "static-content" => [
        "title" => "Website content",
        "about-us" => [
            'title' => 'Section title',
            'paragraph' => 'Part description',
            "page-title" => "Manage a page about the platform",
            "create" => "Add a section about the platform",
            "search" => "research",
            "title_ar" => "The title of the section is Arabic",
            "title_en" => "The title of the section is English",
            "show" => "View a section about the platform",
            "edit" => "Modify a section about the platform",
            "delete_modal" => [
                "title" => "Delete a section on the platform",
                "description" =>
                    "Do you want to delete a section on the platform?",
            ],
            "delete" => "Delete a section on the platform",
            "paragraph_ar" => "Section Description Arabic",
            "paragraph_en" => "Section description English",
        ],
        "validations" => [
            "title_ar_required" => "Section title Arabic is required",
            "title_ar_string" =>
                "The title of the section must be an Arabic type of string",
            "title_ar_min" =>
                "The minimum number of characters for the Arabic section title is at least 3 characters",
            "title_ar_max" =>
                "The largest number of letters in the Arabic section title is 600 characters at most",
            "title_en_required" => "Section title English is required",
            "title_en_string" => "The section title must be an English string",
            "title_en_min" =>
                "The minimum number of characters for the English section title is at least 3 characters",
            "title_en_max" =>
                "The largest number of letters in the title of the section is English, 600 characters at most",
            "paragraph_en_required" =>
                "Section Description English is required",
            "paragraph_en_string" =>
                "The description of the section must be in the English type of a string",
            "paragraph_en_min" =>
                "The minimum number of characters for the English section description is at least 50 characters",
            "paragraph_en_max" =>
                "The maximum number of characters for the English section description is 1000 characters or more",
            "paragraph_ar_required" => "Section Description Arabic is required",
            "paragraph_ar_string" =>
                "The description of the section must be Arabic of type String",
            "paragraph_ar_min" =>
                "The minimum number of characters for the Arabic section description is at least 50 characters",
            "paragraph_ar_max" =>
                "The maximum number of characters for the description of the Arabic section is 1000 characters or more",
        ],
        "messages" => [
            "success" => "successful operation",
            "warning" => "warning",
            "error" => "mistake",
            "section-created" => "The section has been created successfully",
            "section-updated" => "The section has been modified successfully",
            "section-deleted" => "The section has been deleted successfully",
            "section-not-deleted" =>
                "The section cannot be deleted at this time",
        ],
        "privacy-policy" => [
            'title' => 'Section title',
            'paragraph' => 'Part description',
            "page-title" => "Manage the privacy policy page",
            "create" => "Add a privacy policy section",
            "search" => "research",
            "title_ar" => "The title of the section is Arabic",
            "title_en" => "The title of the section is English",
            "show" => "View the Privacy Policy section",
            "edit" => "Modify the privacy policy section",
            "delete_modal" => [
                "title" => "Delete the privacy policy section",
                "description" =>
                    "Do you want to delete the privacy policy section?",
            ],
            "delete" => "Delete the privacy policy section",
            "paragraph_ar" => "Section Description Arabic",
            "paragraph_en" => "Section description English",
        ],
        "usage-agreement" => [
            'title' => 'Section title',
            'paragraph' => 'Part description',
            "page-title" => "Manage the usage agreement page",
            "create" => "Add a section of the usage agreement",
            "search" => "research",
            "title_ar" => "The title of the section is Arabic",
            "title_en" => "The title of the section is English",
            "show" => "View the Terms of Use section",
            "edit" => "Amendment of the User Agreement section",
            "delete_modal" => [
                "title" => "Delete the Terms of Use section",
                "description" =>
                    "Do you want to delete the usage agreement section?",
            ],
            "delete" => "Delete the Terms of Use section",
            "paragraph_ar" => "Section Description Arabic",
            "paragraph_en" => "Section description English",
        ],
    ],
    "qnas" => [
        "question" => 'Frequently Asked Question',
        "answer" => 'answer to a frequently asked question',
        "title" => "common questions",
        "single_title" => "question",
        "all_products" => "All products",
        "manage_qnas" => "Frequently asked questions management",
        "id" => "Question ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "desc_ar" => "Description of a question in Arabic",
        "desc_en" => "Description of the question in English",
        "is_featured" => "Featured product",
        "is_active" => "the condition",
        "active" => "active",
        "inactive" => "Inactive",
        "price" => "the price",
        "unitPrice" => "unit price",
        "total" => "Total question price",
        "order" => "ranking",
        "category" => "Section",
        "vendor" => "the shop",
        "pending" => "my neighbour",
        "in_review" => "under evaluation",
        "held" => "hanging",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new question",
        "update" => "Modify a question",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "created_at_select" => "Choose a date",
        "not_found" => "nothing",
        "show" => "an offer",
        "delete" => "delete",
        "edit" => "amendment",
        "vendor_id" => "the shop",
        "arabic_date" => "Arabic data",
        "english_date" => "Data in English",
        "choose_category" => "Choose a department",
        "image" => "Choose the question picture",
        "image_title" => "Drag the question image here",
        "answer_ar" => "The answer is in Arabic",
        "answer_en" => "The answer is in English",
        "question_en" => "The question is in English",
        "question_ar" => "The question is in Arabic",
        "delete_modal" => [
            "title" => "You are about to delete a question",
            "description" =>
                "Deleting your request will remove all information for this question.",
        ],
        "validations" => [
            "question_ar_required" => "The question is required",
            "question_ar_string" => "The question must be text",
            "question_ar_min" => "Question must be at least 3 letters long",
            "question_ar_max" => "The question must be 600 characters at most",
            "answer_ar_required" => "The answer is required",
            "answer_ar_string" => "The answer must be text",
            "answer_ar_min" => "The answer must be at least 3 letters",
            "answer_ar_max" => "The answer must be 1000 characters at most",
            "question_en_required" => "The question is required",
            "question_en_string" => "The question must be text",
            "question_en_min" => "Question must be at least 3 letters long",
            "question_en_max" => "The question must be 600 characters at most",
            "answer_en_required" => "The answer is required",
            "answer_en_string" => "The answer must be text",
            "answer_en_min" => "The answer must be at least 3 letters",
            "answer_en_max" => "The answer must be 1000 characters at most",
        ],
        "messages" => [
            "created_successfully_title" => "Question created successfully",
            "created_successfully_body" => "Question created successfully",
            "created_error_title" => "Error creating the question",
            "created_error_body" => "An error occurred creating the question",
            "updated_successfully_title" => "Question modified successfully",
            "updated_successfully_body" => "Question modified successfully",
            "updated_error_title" => "Error while editing the question",
            "updated_error_body" =>
                "An error occurred while editing the question",
            "deleted_successfully_title" =>
                "The question has been successfully deleted",
            "deleted_successfully_message" =>
                "The question has been successfully deleted",
            "deleted_error_title" => "Error deleting the question",
            "deleted_error_message" =>
                "An error occurred while deleting the question",
        ],
    ],
    "rates_title" => "Evaluation",
    "no_data" => "nothing",
    "admin_approved_state" => [
        "pending" => "Approval in progress",
        "approved" => "OK",
        "rejected" => "unacceptable",
    ],
    "productRates" => [
        "last_admin_edit" => "Date last modified by admin",
        "title" => "Products evaluation",
        "single_title" => "Product evaluation",
        "all_productRates" => "All product reviews",
        "manage_productRates" => "Manage product reviews",
        "state_approved" => "It has been accepted",
        "state_not_approved" => "Not accepted",
        "id" => "Rating ID",
        "rate" => "Evaluation",
        "comment" => "Customer comment",
        "user_id" => "customer name",
        "product_id" => "product name",
        "reason" => "the reason",
        "admin_id" => "Admin name",
        "admin_comment" => "Admin comment",
        "admin_approved" => "approval status",
        "reporting" => "Notification",
        "yes" => "Yes",
        "no" => "no",
        "update" => "Modify evaluation data",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View evaluation data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "not_answer" => "The admin has not yet approved",
        "choose_state" => "Select evaluation status",
        "delete_modal" => [
            "title" => "You are about to delete a product review",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Assessment created successfully",
            "created_successfully_body" => "Assessment created successfully",
            "created_error_title" => "Error creating assessment",
            "created_error_body" =>
                "An error occurred while creating the assessment",
            "updated_successfully_title" =>
                "Rating has been modified successfully",
            "updated_successfully_body" =>
                "Rating has been modified successfully",
            "updated_error_title" => "Error while modifying the rating",
            "updated_error_body" =>
                "An error occurred while modifying the rating",
            "deleted_successfully_title" =>
                "The rating has been successfully deleted",
            "deleted_successfully_message" =>
                "The rating has been successfully deleted",
            "deleted_error_title" => "Error deleting rating",
            "deleted_error_message" =>
                "Something went wrong while deleting the rating",
        ],
        "validations" => [
            "admin_comment_string" =>
                "The admin's comment must be of text type",
            "admin_comment_min" =>
                "The minimum number of characters for an admin comment is 3 letters",
            "admin_approved_boolean" =>
                "The field type of this field must be a Boolean value",
            "admin_id_numeric" =>
                "The field type of this field must be a Boolean value",
        ],
    ],
    "vendorRates" => [
        "last_admin_edit" => "Date last modified by admin",
        "title" => "Store evaluation",
        "single_title" => "Merchant rating",
        "all_vendorRates" => "All store ratings",
        "manage_vendorRates" => "Store ratings management",
        "state_approved" => "It has been accepted",
        "state_not_approved" => "Not accepted",
        "id" => "Rating ID",
        "rate" => "Evaluation",
        "comment" => "Customer comment",
        "user_id" => "customer name",
        "vendor_id" => "Merchant name",
        "admin_id" => "Admin name",
        "admin_comment" => "Admin comment",
        "admin_approved" => "approval status",
        "yes" => "Yes",
        "no" => "no",
        "update" => "Modify evaluation data",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View evaluation data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "not_answer" => "The admin has not yet approved",
        "choose_state" => "Select evaluation status",
        "delete_modal" => [
            "title" => "You are about to delete a merchant rating",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Assessment created successfully",
            "created_successfully_body" => "Assessment created successfully",
            "created_error_title" => "Error creating assessment",
            "created_error_body" =>
                "An error occurred while creating the assessment",
            "updated_successfully_title" =>
                "Rating has been modified successfully",
            "updated_successfully_body" =>
                "Rating has been modified successfully",
            "updated_error_title" => "Error while modifying the rating",
            "updated_error_body" =>
                "An error occurred while modifying the rating",
            "deleted_successfully_title" =>
                "The rating has been successfully deleted",
            "deleted_successfully_message" =>
                "The rating has been successfully deleted",
            "deleted_error_title" => "Error deleting rating",
            "deleted_error_message" =>
                "Something went wrong while deleting the rating",
        ],
        "validations" => [
            "admin_comment_string" =>
                "The admin's comment must be of text type",
            "admin_comment_min" =>
                "The minimum number of characters for an admin comment is 3 letters",
            "admin_approved_boolean" =>
                "The field type of this field must be a Boolean value",
            "admin_id_numeric" =>
                "The field type of this field must be a Boolean value",
        ],
    ],
    "recipes" => [
        "body" => "content",
        'short_desc' => 'short description',
        "title" => "recipes",
        "single_title" => "the recipe",
        "all_recipes" => "All recipes",
        "manage_recipes" => "Prescription management",
        "id" => "Recipe ID",
        "body_ar" => "Arabic content",
        "body_en" => "Content in English",
        "image" => "Choose a description image",
        "most_visited" => "most visited",
        "image_for_show" => "Recipe photo",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new recipe",
        "update" => "Recipe modification",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View recipe data",
        "edit" => "amendment",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "choose_state" => "Select recipe status",
        "choose_country" => "Select recipe",
        "country_id" => "the recipe",
        "areas_cities" => "The city's areas",
        "title_en" => "The address is Arabic",
        "title_en" => "The address is English",
        "short_desc_en" => "The short description is Arabic",
        "short_desc_en" => "The short description is in English",
        "delete_modal" => [
            "title" => "Are you about to delete a recipe?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Recipe generated successfully",
            "created_successfully_body" => "Recipe generated successfully",
            "created_error_title" => "Error creating recipe",
            "created_error_body" =>
                "An error occurred while creating the recipe",
            "updated_successfully_title" =>
                "The recipe has been modified successfully",
            "updated_successfully_body" =>
                "The recipe has been modified successfully",
            "updated_error_title" => "Error while modifying the recipe",
            "updated_error_body" =>
                "An error occurred while modifying the recipe",
            "deleted_successfully_title" =>
                "The recipe has been successfully deleted",
            "deleted_successfully_message" =>
                "The recipe has been successfully deleted",
            "deleted_error_title" => "Error while deleting the recipe",
            "deleted_error_message" =>
                "Something went wrong while deleting the recipe",
        ],
        "validations" => [
            "title_ar_required" => "Title in Arabic is required",
            "title_en_required" => "English title is required",
            "title_ar_min" => "Title must be at least 3 characters long",
            "title_en_min" => "Title must be at least 3 characters long",
            "title_ar_max" => "Title must be 600 characters at most",
            "title_en_max" => "Title must be 600 characters at most",
            "body_ar_required" => "Arabic content is required",
            "body_en_required" => "English content is required",
            "short_desc_ar_required" =>
                "Short description in Arabic is required",
            "short_desc_en_required" =>
                "Short description in English is required",
            "short_desc_ar_min" =>
                "Description must be at least 3 characters long",
            "short_desc_en_min" =>
                "Description must be at least 3 characters long",
            "body_ar_max" => "Description must be 1000 characters at most",
            "body_en_max" => "Description must be 1000 characters at most",
        ],
    ],
    "blogPosts" => [
        "body" => "content",
        'short_desc' => 'short description',
        "title" => "blog",
        "single_title" => "Threads",
        "all_recipes" => "All recipes",
        "manage_blogposts" => "Blog management",
        "id" => "Recipe ID",
        "body_ar" => "Arabic content",
        "body_en" => "Content in English",
        "image" => "Choose a description image",
        "most_visited" => "most visited",
        "image_for_show" => "Recipe photo",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new topic",
        "update" => "Modify a theme",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View topic data",
        "edit" => "amendment",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "choose_state" => "Choose a topic case",
        "choose_country" => "Choose a topic",
        "country_id" => "Theme",
        "areas_cities" => "The city's areas",
        "title_ar" => "The address is Arabic",
        "title_en" => "The address is English",
        "short_desc_ar" => "The short description is Arabic",
        "short_desc_en" => "The short description is in English",
        "delete_modal" => [
            "title" => "Are you about to delete a topic?",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Topic created successfully",
            "created_successfully_body" => "Topic created successfully",
            "created_error_title" => "Error creating topic",
            "created_error_body" =>
                "An error occurred while creating the topic",
            "updated_successfully_title" =>
                "Thread has been modified successfully",
            "updated_successfully_body" =>
                "Thread has been modified successfully",
            "updated_error_title" => "Error while editing topic",
            "updated_error_body" => "An error occurred while editing the theme",
            "deleted_successfully_title" =>
                "The topic has been successfully deleted",
            "deleted_successfully_message" =>
                "The topic has been successfully deleted",
            "deleted_error_title" => "Error deleting the topic",
            "deleted_error_message" =>
                "Something went wrong while deleting the topic",
        ],
        "validations" => [
            "title_ar_required" => "Title in Arabic is required",
            "title_en_required" => "English title is required",
            "title_ar_min" => "Title must be at least 3 characters long",
            "title_en_min" => "Title must be at least 3 characters long",
            "body_ar_required" => "Arabic content is required",
            "body_en_required" => "English content is required",
            "short_desc_ar_required" =>
                "Short description in Arabic is required",
            "short_desc_en_required" =>
                "Short description in English is required",
            "short_desc_ar_min" =>
                "Description must be at least 3 characters long",
            "short_desc_en_min" =>
                "Description must be at least 3 characters long",
        ],
    ],
    "productQuantities" => [
        "name" => "name",
        "title" => "Product units of measurement",
        "single_title" => "measruing unit",
        "all_cities" => "All units of measure",
        "manage_productQuantities" => "Manage product units of measurement",
        "id" => "Unit ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new unit",
        "update" => "Modify alone",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "Show unit data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "choose_state" => "Select the state of the unit",
        "delete_modal" => [
            "title" => "You are about to delete alone",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The unit has been created successfully",
            "created_successfully_body" =>
                "The unit has been created successfully",
            "created_error_title" => "Error creating unit",
            "created_error_body" =>
                "An error occurred while creating the module",
            "updated_successfully_title" =>
                "The unit has been modified successfully",
            "updated_successfully_body" =>
                "The unit has been modified successfully",
            "updated_error_title" => "Error while modifying the unit",
            "updated_error_body" =>
                "An error occurred while modifying the module",
            "deleted_successfully_title" =>
                "The unit has been successfully deleted",
            "deleted_successfully_message" =>
                "The unit has been successfully deleted",
            "deleted_error_title" => "Error while deleting the unit",
            "deleted_error_message" =>
                "An error occurred while deleting the module",
        ],
        "validations" => [
            "name_ar_required" => "The name of the unit in Arabic is required",
            "name_ar_string" =>
                "The name of the Arabic module must be of type String",
            "name_ar_min" =>
                "The minimum number of letters in the name of the Arabic unit is at least 3 letters",
            "name_en_required" => "Unit name in English is required",
            "name_en_string" =>
                "The English module name must be of type string",
            "name_en_min" =>
                "The least number of letters in the English unit name is at least 3 letters",
            "country_id_required" => "The state is required",
            "is_active_required" => "Status is required",
        ],
    ],
    "wareHouseRequests" => [
        "title" => "storage requests",
        "single_title" => "Sad request",
        "all_wareHouseRequests" => "All storage requests",
        "manage_wareHouseRequests" => "Manage storage requests",
        "products_count" => "The number of products",
        "id" => "Order ID",
        "next" => "the next",
        "vendor" => "the shop",
        "choose_vendor" => "Select store",
        "choose_product" => "Select the product",
        "name_ar" => "Arabic product name",
        "name_en" => "Product name in English",
        "product" => "the product",
        "status" => "the condition",
        "created_at" => "Date created",
        "created_by" => "by",
        "qnt" => "The number of kernels",
        "mnfg_date" => "Production Date",
        "experience_date" => "Expiry date",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new storage request",
        "update" => "Modify a storage request",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View storage request data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "filter_is_active" => "Filter by status",
        "choose_state" => "Choose the status of the storage request",
        "requestItems" => "products",
        "vendor-no-products" =>
            "This merchant has no products, please choose another merchant",
        "product_count" => "number of products",
        "delete_modal" => [
            "title" => "You are about to delete a storage request",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "A storage request has been created successfully",
            "created_successfully_body" =>
                "A storage request has been created successfully",
            "created_error_title" => "Error creating storage request",
            "created_error_body" =>
                "An error occurred while creating a storage request",
            "updated_successfully_title" =>
                "A storage request has been modified successfully",
            "updated_successfully_body" =>
                "A storage request has been modified successfully",
            "updated_error_title" => "Error while modifying storage request",
            "updated_error_body" =>
                "An error occurred while modifying a storage request",
            "deleted_successfully_title" =>
                "A storage request has been successfully deleted",
            "deleted_successfully_message" =>
                "A storage request has been successfully deleted",
            "deleted_error_title" => "Error while deleting a storage request",
            "deleted_error_message" =>
                "An error occurred while deleting a storage request",
        ],
        "validations" => [
            "vendor_id_required" => "Store name is required",
            "product_id_required" =>
                "Storage request name in Arabic is required",
            "qnt_required" =>
                "The Arabic storage request name must be of type string",
            "mnfg_date_required" =>
                "The minimum number of letters for the name of the Arabic storage request is at least 3 letters",
            "expire_date_required" =>
                "Storage request name in English is required",
            "experience_date_after" =>
                "The expiry date must be later than the production date",
        ],
    ],
    "sliders" => [
        "manage_sliders" => "Slider management",
        "name" => "the name",
        "identityfire" => "Identification name",
        "id" => "ID",
        "type" => "Type",
        "show" => "an offer",
        "edit" => "amendment",
        "image" => "Add image",
        "create" => "Create a slider",
        "remove" => "wit",
        "delete" => "cancellation",
        "identifier" => "ID",
        "delete_modal" => [
            "title" => "You are about to delete a storage request",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Slider has been added",
            "created_successfully_body" => "Slider has been added",
            "updated_successfully_title" => "Slider has been modified",
            "updated_successfully_body" => "Slider has been modified",
            "deleted_successfully_title" =>
                "The image has been deleted successfully",
            "deleted_successfully_message" =>
                "The image has been deleted successfully",
        ],
    ],
    "carts_list" => "Purchase baskets",
    "cart_show" => "View cart",
    "cart_main_details" => "Main basket data",
    "cart_id" => "Cart ID",
    "cart_date" => "The date the basket was created",
    "cart_price" => "the price",
    "cart_products_count" => "number of products",
    "cart_customer_name" => "customer name",
    "cart_last_update" => "The date of the last update",
    "team_title" => "work team",
    "unauthorized_title" => "You do not have validity",
    "unauthorized_body" => "Sorry... You do not have validity",
    "subAdmins" => [
        "title" => "System administrators",
        "single_title" => "System Administrator",
        "manage_subAdmins" => "Managing system administrators",
        "rules" => "Supervisor roles",
        "yes" => "Yes",
        "no" => "no",
        "id" => "Supervisor ID",
        "name" => "the name",
        "email" => "E-mail",
        "phone" => "cell phone",
        "password" => "password",
        "no_rules_found" => "There are currently no roles",
        "avatar" => "user photo",
        "create" => "Create a new supervisor",
        "edit" => "amendment",
        "update" => "Moderator edit",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View admin data",
        "delete" => "delete",
        "delete_modal" => [
            "title" => "You are about to delete an administrator",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Supervisor created successfully",
            "created_successfully_body" => "Supervisor created successfully",
            "created_error_title" => "Error creating admin",
            "created_error_body" => "An error occurred while creating an admin",
            "updated_successfully_title" =>
                "Admin has been modified successfully",
            "updated_successfully_body" =>
                "Admin has been modified successfully",
            "updated_error_title" => "Error while editing admin",
            "updated_error_body" => "An error occurred while editing an admin",
            "deleted_successfully_title" =>
                "Supervisor has been removed successfully",
            "deleted_successfully_message" =>
                "Supervisor has been removed successfully",
            "deleted_error_title" => "Error deleting admin",
            "deleted_error_message" =>
                "An error occurred while deleting an administrator",
        ],
        "validations" => [
            "name_required" => "Name field is required",
            "name_string" => "The Name field must be a string",
            "name_min" =>
                "The minimum number of letters in the name is 3 letters",
            "email_required" => "Email field is required",
            "email_email" => "Incorrect email format",
            "email_unique" => "Postage has already been taken",
            "phone_required" => "Mobile number is required",
            "phone_min" => "The minimum length of a mobile number is 9 digits",
            "password_required" => "Password field is required",
            "password_string" => "The password must be a text string",
            "password_min" =>
                "Minimum password length is 8 characters or numbers",
            "avatar_image" => "Invalid image format",
            "avatar_mimes" => "Allowed image extension is png, jpeg",
        ],
    ],
    "rules" => [
        "title" => "I turn moderators",
        "single_title" => "role",
        "all_rules" => "All roles",
        "manage_rules" => "Role management",
        "id" => "Role ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new role",
        "update" => "Role modification",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View role data",
        "delete" => "delete",
        "sub-admin" => "Administration",
        "vendor" => "the shop",
        "choose_scope" => "Choose a domain",
        "choose_scope_filter" => "Role filter scope",
        "scope" => "the range",
        "permissions" => [
            "title" => "All permits",
            "no_permissions_found" => "There are no permits",
        ],
        "delete_modal" => [
            "title" => "You are about to delete pixelated",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The role has been created successfully",
            "created_successfully_body" =>
                "The role has been created successfully",
            "created_error_title" => "Error creating role",
            "created_error_body" => "An error occurred while creating the role",
            "updated_successfully_title" =>
                "The role has been modified successfully",
            "updated_successfully_body" =>
                "The role has been modified successfully",
            "updated_error_title" => "Error while modifying the role",
            "updated_error_body" =>
                "An error occurred while modifying the role",
            "deleted_successfully_title" =>
                "The role has been successfully deleted",
            "deleted_successfully_message" =>
                "The role has been successfully deleted",
            "deleted_error_title" => "Error while deleting the role",
            "deleted_error_message" =>
                "An error occurred while deleting the role",
        ],
        "validations" => [
            "name_ar_required" => "Role name in Arabic is required",
            "name_ar_string" => "The Arabic role name must be a string type",
            "name_ar_min" =>
                "The minimum number of letters in the Arabic name Dur is at least 3 letters",
            "name_en_required" => "Role name in English is required",
            "name_en_string" => "The English role name must be a string",
            "name_en_min" =>
                "The least number of letters in the English role name is at least 3 letters",
            "scope_required" => "Domain is required",
            "permissions_required" => "At least one permit must be selected",
            "permissions_array" => "The permission field type must be an array",
            "permissions_present" => "Permits must contain at least one",
        ],
    ],
    "certificates" => "Testimonials",
    "certificate_title" => "Certificate name",
    "certificate_image" => "Certificate copy",
    "certificate_requests" => "Certification requests",
    "certificate_edit" => "Modify the certificate",
    "certificate_please_enter_title" =>
        "Please enter the title of the certificate",
    "certificate_please_enter_image" =>
        "Please enter a copy of the certificate",
    "certificate_download" => "Download the certificate",
    "certificate_request_vendor" => "merchant",
    "certificate_request_file" => "Certificate file",
    "certificate_request_expire" => "Certificate expiry date",
    "certificate_approve" => "The certificate has been approved",
    "certificate_reject" => "The certificate was rejected",
    "certificates_number" => "The number of certificates",
    "no_certificates" => "There are no testimonials",
    "certificates_create" => "Create a certificate",
    "certificates_edit" => "certificate edit",
    "vendors_info" => [
        "vendor_name_ar" => "The name of the store is Arabic",
        "vendor_name_en" => "The name of the store is English",
        "validations" => [
            "vendor_name_ar" => "The Arabic name field is required",
            "commission_required" =>
                "Management percentage of the sale price is required",
            "commission_gte" =>
                "The management ratio of the selling price is greater than or equal to ",
            "vendor_name_en" => "English name field is required",
        ],
    ],
    "vendorWallets" => [
        "in._in" => "addition",
        "out" => "rival",
        "all_wallets" => "All accounts",
        "vendor_name" => "Store name",
        "vendor_name_ar" => "The name of the store is Arabic",
        "vendor_name_en" => "The name of the store is English",
        "user_vendor_name" => "Store owner name",
        "show" => "an offer",
        "sub_balance" => "Store credit deduction",
        "id" => "Account ID",
        "manage" => "Store portfolio management",
        "import" => "Import accounts",
        "search" => "Search accounts",
        "title" => "Store accounts",
        "single_title" => "Stores account",
        "customer_name" => "Stores name",
        "attachments" => "attachments",
        "no_attachments" => "There are no attachments",
        "by_admin" => "by",
        "is_active" => "activation status",
        "last_update" => "Last updated",
        "active" => "active",
        "inactive" => "not active",
        "choose_state" => "Choose account status",
        "choose_customer" => "Choose a merchant",
        "amount" => "balance",
        "reason" => "the reason",
        "created_at" => "The date the account was created",
        "created_at_select" => "Choose a date",
        "all" => "everyone",
        "filter" => "filtering",
        "attachemnts" => "Download the attachment",
        "no_result_found" => "No results found",
        "attachment" => "attachments",
        "has_attachment" => "Attachment preview",
        "has_no_attachment" => "There are no attachments",
        "change_status" => "Change account status",
        "manage_wallet_balance" => "Account balance management",
        "current_wallet_balance" => "current account balance",
        "subtract" => "rival",
        "wallet_balance" => "account balance",
        "wallets_transactions" => [
            "title" => "Account transactions",
            "single_title" => "account transaction",
            "customer_name" => "Stores name",
            "wallet_id" => "Account ID",
            "amount" => "The amount of the transaction",
            "transaction_date" => "Transaction date",
        ],
        "messages" => [
            "created_successfully_title" => "New merchant account",
            "created_successfully_body" =>
                "A new merchant account has been created successfully",
            "created_error_title" => "Merchant account creation failed",
            "created_error_body" => "New merchant account creation failed",
            "updated_successfully_title" => "Modify merchant account status",
            "updated_successfully_body" =>
                "Merchant account status modified successfully",
            "updated_error_title" =>
                "Merchant account status modification failed",
            "updated_error_body" => "Merchant account status adjustment failed",
            "customer_has_wallet_title" =>
                "It is not possible to create an account for this store",
            "customer_has_wallet_message" =>
                "It is not possible to create an account for this store because it already has one",
        ],
        "customer_info" => [
            "email" => "Mail",
            "phone" => "cell phone",
        ],
        "transaction" => [
            "title" => "Account balance management",
            "wallet_transactions_log" => "Account transaction history",
            "id" => "Transaction ID",
            "type" => "Type of transaction",
            "receipt_url" => "Operation facility",
            "operation_type" => "Choose the type of transaction",
            "reference" => "Ref",
            "reference_id" => "reference number",
            "admin_by" => "by admin",
            "amount" => "Transaction value",
            "date" => "Transaction date",
            "add" => "Add +",
            "sub" => "rival -",
            "receipt" => "attachments",
            "success_add_title" => "Successful credit adding process",
            "success_add_message" =>
                "The merchant card has been successfully credited",
            "success_sub_title" => "Successful credit deduction",
            "success_sub_message" =>
                "The merchant card balance has been debited successfully",
            "fail_add_title" => "Add credit failed",
            "fail_add_message" => "Merchant card crediting failed",
            "fail_sub_title" => "Balance deduction failed",
            "fail_sub_message" => "Merchants card debit failed",
            "cannot_subtract_message" =>
                "The card balance is less than the discount values",
            "user_id" => "The process was done by",
            "order_code" => "request code",
            "transaction_type" => [
                "title" => "Operation type",
                "choose_transaction_type" => "Choose the type of operation",
                "purchase" => "buy products",
                "gift" => "gift",
                "bank_transfer" => "Bank transfer",
                "compensation" => "compensation",
            ],
            "opening_balance" => "Opening balance",
            "validations" => [
                "amount_required" => "Transaction value field is required",
                "amount_numeric" =>
                    "The transaction value must be a numeric value",
                "receipt_url_required" => "Transaction type field is required",
                "receipt_url_image" =>
                    "You must select the type of transaction",
            ],
        ],
        "vendors_finances" => "Store finances",
    ],
    "select-option" => "Choose",
    "settings" => [
        "main" => "Settings",
        "show" => "an offer",
        "id" => "ID",
        "key" => "the name",
        "value" => "the value",
        "manage_settings" => "Settings management",
        "edit" => "amendment",
        "validations" => [
            "pdf" => "The file must be a PDF",
        ],
        "messages" => [
            "setting-not-editable" => "This setting cannot be modified",
            "updated_successfully_title" => "Modify the value",
            "updated_error_title" => "Value modification failed",
            "updated_successfully_body" =>
                "The value has been modified successfully",
            "updated_error_body" => "The value modification operation failed",
        ],
    ],
    "coupons" => [
        "id" => "Order ID",
        "manage_coupons" => "Coupon management",
        "pending" => "I'm waiting",
        "approved" => "Enabled",
        "rejected" => "disabled",
        "messages" => [
            "created_successfully_title" => "A new coupon has been created",
            "created_successfully_body" => "A new coupon has been created",
            "created_error_title" => "New coupon creation failed",
            "created_error_body" => "New coupon creation failed",
            "updated_successfully_title" => "Coupon modification",
            "updated_successfully_body" =>
                "The coupon has been modified successfully",
            "updated_error_title" => "Coupon modification failed successfully",
            "updated_error_body" => "Coupon modification failed",
            "deleted_successfully_title" =>
                "Coupon has been removed successfully",
            "deleted_successfully_message" =>
                "Coupon has been removed successfully",
            "deleted_error_title" => "Error while deleting coupon",
            "deleted_error_message" =>
                "An error occurred while deleting a coupon",
        ],
        "coupon_type" => "Coupon type",
        "coupon_types" => [
            "vendor" => "Dealer discounts",
            "product" => "Product discounts",
            "global" => "General discounts",
            "free" => "Free delivery",
        ],
        "amount" => "discount value",
        "minimum_order_amount" => "Minimum order amount",
        "maximum_discount_amount" => "The maximum discount",
        "code" => "code",
        "maximum_redemptions_per_user" => "The number of customer usage",
        "maximum_redemptions_per_coupon" =>
            "The number of redemption for the coupon",
        "title_ar" => "The address is Arabic",
        "title_en" => "The address is English",
        "filter" => "search",
        "not_found" => "There are no coupons",
        "create" => "Add coupon",
        "update" => "Coupon adjustment",
        "search" => "research",
        "choose_state" => "Select status",
        "status" => "the condition",
        "percentage" => "rate",
        "fixed" => "amount",
        "discount_type" => "discount type",
        "validations" => [
            "title_ar_required" => "Address must be entered",
            "title_en_required" => "You must enter the English title",
            "title_en_max" => "greater than specified",
            "title_en_min" => "smaller than specified",
            "code_required" => "The code must be entered",
            "code_unique" => "The code is already in use",
            "code_min" =>
                "The minimum number of characters allowed is 4 characters",
            "amount_required" => "The specified quantity must be entered",
            "amount_numeric" => "The quantity value must be a numeric value",
            "amount_min" => "smaller than specified",
            "minimum_amount_required" =>
                "You must enter a minimum order amount",
            "minimum_amount_min" => "smaller than specified",
            "minimum_amount_max" => "greater than specified",
            "minimum_amount_lt" => "The minimum must be less than the maximum",
            "amount_percentage" =>
                "It has exceeded the known percentage and it is 100%",
            "amount_fixed" => "You have exceeded the amount",
            "coupon_type_required" => "Coupon type is required",
            "vendors_required" => "At least one dealer must be selected",
            "products_required" => "At least one product must be selected",
            "status_required" => "Enter coupon status",
            "maximum_amount_required" => "You must enter a maximum discount",
            "maximum_amount_min" => "smaller than specified",
            "maximum_amount_max" => "greater than specified",
            "maximum_amount_gt" =>
                "The maximum must be greater than the minimum",
            "discount_type_required" => "You must enter the discount type",
            "maximum_redemptions_per_coupon_integer" =>
                "It must be a valid number",
            "maximum_redemptions_per_user_integer" =>
                "It must be a valid number",
            "maximum_redemptions_per_coupon_max" => "greater than specified",
            "maximum_redemptions_per_coupon_min" => "less than specified",
            "maximum_redemptions_per_user_max" => "greater than specified",
            "maximum_redemptions_per_user_min" => "less than specified",
            "start_at_date" => "Please enter the value as a date",
            "start_at_before" =>
                "The start date must be less than the end date",
            "expire_at_date" => "Please enter the value as a date",
            "expire_at_after" =>
                "The end date must be greater than the start date",
        ],
        "filter_status" => "filter status",
        "show" => "Coupon details",
        "list" => "Back for all coupons",
        "delete" => "Coupon scan",
        "delete_modal" => [
            "title" => "Do you want to scan the coupon?",
            "description" => "The coupon will be deleted",
        ],
        "start_at" => "starting date",
        "expire_at" => "Expiry date",
        "edit" => "amendment",
    ],
    "cant-delete-related-to-product" =>
        "Data cannot be deleted because it is used in products",
    "permission_vendor_users" => "using stores",
    "permission_vendor_roles" => "Store user roles",
    "permission_vendor_roles_create" => "Add store user roles",
    "permission_vendor_roles_edit" => "Modify the roles of store users",
    "permission_vendor_role_name" => "the name",
    "permission_vendor_role_name_please" =>
        "Please enter the authorization name",
    "permission_vendor_role_permissions" => "powers",
    "permission_vendor_role_permissions_please" =>
        "Please select at least one validity",
    "vendor_users" => "using stores",
    "vendor_users_create" => "Add a user to the store",
    "vendor_users_edit" => "Modify a store user",
    "vendor_user_name" => "user name",
    "vendor_user_email" => "User's email",
    "vendor_user_phone" => "User mobile",
    "vendor_user_password" => "User password",
    "vendor_user_password_confirm" => "Confirm user password",
    "vendor_user_role" => "User role",
    "vendor_user_vendor" => "The user's store",
    "vendor_user_unblocked" => "The ban has been lifted from the user",
    "vendor_user_blocked" => "The user has been banned",
    "warehouses" => [
        "cities" => "Cities",
        "name" => "Repository Name",
        "title" => "stores management",
        "single_title" => "warehouse",
        "manage_warehouses" => "stores management",
        "yes" => "Yes",
        "no" => "no",
        "id" => "Warehouse ID",
        "vendors" => "Vendors",
        "name_ar" => "The name of the warehouse in Arabic",
        "name_en" => "The name of the warehouse in English",
        "torod_warehouse_name" =>
            "The name of the warehouse at the parcel company",
        "integration_key" => "Key link with parcel company",
        "administrator_name" =>
            "The name of the person in charge of the warehouse",
        "administrator_phone" =>
            "The phone of the person in charge of the warehouse",
        "administrator_email" => "Mail in charge of the warehouse",
        "map_url" => "Map link",
        "latitude" => "Latitude",
        "longitude" => "longitude",
        "create" => "Create a new warehouse",
        "edit" => "repository modification",
        "update" => "repository modification",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "map" => "warehouse location",
        "show" => "View warehouse data",
        "delete" => "delete",
        "reset" => "re",
        "delete_modal" => [
            "title" => "You are about to delete a repository",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "is_active" => "Warehouse Status",
        "messages" => [
            "created_successfully_title" => "Repository created successfully",
            "created_successfully_body" => "Repository created successfully",
            "created_error_title" => "Error creating repository",
            "created_error_body" =>
                "An error occurred while creating a repository",
            "updated_successfully_title" =>
                "Repository has been modified successfully",
            "updated_successfully_body" =>
                "Repository has been modified successfully",
            "updated_error_title" => "Error while modifying repository",
            "updated_error_body" =>
                "An error occurred while modifying a repository",
            "deleted_successfully_title" =>
                "Repository has been deleted successfully",
            "deleted_successfully_message" =>
                "Repository has been deleted successfully",
            "deleted_error_title" => "Error while deleting a repository",
            "deleted_error_message" =>
                "An error occurred while deleting a repository",
        ],
        "validations" => [
            "name_ar_required" =>
                "The name of the warehouse in Arabic is required",
            "name_ar_string" =>
                "The Arabic Repository Name field type must be a String",
            "name_ar_min" =>
                "The minimum number of letters for the name of the warehouse in Arabic is three letters",
            "name_en_required" => "Warehouse name in English is required",
            "name_en_string" =>
                "The repository name field type in English must be a string",
            "name_en_min" =>
                "The minimum number of letters for the warehouse name in English is three letters",
            "torod_warehouse_name_string" =>
                "Parcel Company Warehouse Name field type must be String",
            "integration_key_required" =>
                "Link key with parcel company is required",
            "integration_key_unique" =>
                "The key to linking with a parcel company already exists",
            "administrator_name_required" =>
                "The name of the person in charge of the warehouse is required",
            "administrator_phone_required" =>
                "The phone of the person in charge of the warehouse is required",
            "administrator_email_required" =>
                "Warehouse Responsible Email is required",
            "map_url_required" => "Map link required",
            "map_url_url" => "The map link must be a web link",
            "latitude_required" =>
                "You must choose a location for the warehouse",
            "longitude_required" =>
                "location for the warehouse must be selected",
        ],
        "additional_unit_price" => "Incremental packaging price",
        "package_covered_quantity" => "Packaging includes a number of pieces",
        "package_price" => "Packaging price",
        "countries" => "Warehouse countries",
        "empty-countries" =>
            "It is not possible to add a warehouse because all countries in the system have already been linked to warehouses",
        'api-key' => 'API Key',
    ],
    "delivery" => [
        "title" => "Shipping",
        "delete-modal-title" => "Confirm the deletion",
        "domestic-zones" => [
            'name' => 'Region name',
            "title" => "delivery areas",
            "show-title" => "View delivery areas",
            "create-title" => "Add delivery area",
            "edit-title" => "Adjust delivery area",
            "no-zones" => "There are no delivery areas",
            "create" => "Add a delivery area",
            "id" => "Delivery area number",
            "name-ar" => "The name of the region is Arabic",
            "name-en" => "The name of the region is English",
            "cities-count" => "number of cities",
            "delete-body" => "Are you sure to delete the delivery zone:zone",
            "cities" => "Cities of the delivery area",
            "deliver-fees" => "Delivery charges (SAR)",
            "delivery-type" => "Delivery type",
            "countries" => "Countries",
            "delivery_fees" => "Delivery Charge",
            "delivery_fees_covered_kilos" =>
                "Delivery fees cover the number of kilos",
            "additional_kilo_price" => "Extra kilo price",
            "messages" => [
                "success-title" => "operation accomplished successfully",
                "deleted" => "The delivery area has been deleted successfully",
                "created" => "Delivery area has been added successfully",
                "updated" => "The delivery area has been modified successfully",
                "warning-title" => "the operation could not be completed",
                "no-countries" =>
                    "All countries have been connected to delivery zones before",
                "select-country" => "Please select a valid country",
            ],
            "delivery-feeses" => [
                "title" => "Delivery charges by weight",
                "weight-from" => "weight from",
                "weight-to" => "weight to me",
                "delivery-fees" => "Delivery charges",
                "download-desc" =>
                    "Prices can be controlled by attaching a CSV file containing weight from, weight to, price. You can download a copy of the file, delete the first row, and then insert your data",
                "download-validation-desc" =>
                    "The fields must contain (weight in kilos accepts fractions) and (weight in kilos accepts fractions) and (price in riyals accepts fractions)",
                "download-rows-desc" =>
                    "Only the first 500 rows will be included, and in the event that there is a row that does not agree with the conditions, the file will be ignored as a whole",
                "download" => "Download a copy of the price",
                "upload" => "file upload",
                "delivery_fees_sheet" => "Price file",
                "sheet-uploaded" =>
                    "The price file has been downloaded and updated in the database",
            ],
        ],
    ],
    "torodCompanies" => [
        "title" => "Management of parcel shipping companies",
        "single_title" => "Shipping company",
        "manage_torodCompanies" => "Management of parcel shipping companies",
        "yes" => "Yes",
        "no" => "no",
        "id" => "Company ID",
        "name_ar" => "Company name in Arabic",
        "name_en" => "Company name in English",
        "desc_ar" => "Company description in Arabic",
        "desc_en" => "Company description in English",
        "active_status" => "company status",
        "delivery_fees" => "Shipping expenses",
        "domestic_zone_id" => "Delivery area identifier",
        "domestic_zone" => "delivery area",
        "torod_courier_id" => "Company ID at parcels",
        "create" => "Create a new company",
        "edit" => "Company modification",
        "update" => "Company modification",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "map" => "The company's website",
        "show" => "View company data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "choose_state" => "Select company status",
        "choose_domistic_zone" => "Choose the delivery area",
        "logo" => "Company logo",
        "delete_modal" => [
            "title" => "You are about to delete a company",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" => "Company successfully established",
            "created_successfully_body" => "Company successfully established",
            "created_error_title" => "Company creation error",
            "created_error_body" =>
                "Something went wrong while creating a company",
            "updated_successfully_title" =>
                "Company has been modified successfully",
            "updated_successfully_body" =>
                "Company has been modified successfully",
            "updated_error_title" => "Error while modifying company",
            "updated_error_body" => "An error occurred while editing a company",
            "deleted_successfully_title" =>
                "Company has been successfully deleted",
            "deleted_successfully_message" =>
                "Company has been successfully deleted",
            "deleted_error_title" => "Error while deleting a company",
            "deleted_error_message" =>
                "Something went wrong while deleting a company",
        ],
        "validations" => [
            "name_en_required" => "Company name in Arabic is required",
            "name_en_string" =>
                "The Arabic Company Name field type must be a String",
            "name_ar_min" =>
                "The minimum number of letters for the company name in Arabic is three letters",
            "name_en_required" => "Company name in English is required",
            "name_en_string" =>
                "The English Company Name field type must be a String",
            "name_en_min" =>
                "The minimum number of letters for the company name in English is three letters",
            "desc_en_required" => "Company description in Arabic is required",
            "desc_ar_string" =>
                "The Arabic company description field type must be a string",
            "desc_ar_min" =>
                "The minimum number of characters for the company description field in Arabic is three letters",
            "desc_en_required" => "Company description in English is required",
            "desc_en_string" =>
                "The company description field type in English must be a string",
            "desc_en_min" =>
                "The minimum number of characters for the Company Description field in English is three characters",
            "active_status_boolean" =>
                "The state of the company must be a boolean value",
            "delivery_fees_required" => "Shipping charges are required",
            "delivery_fees_numeric" => "Shipping value should be",
            "domestic_zone_id_required" => "Shipping area required",
            "torod_courier_id_required" => "Parcel Company ID is required",
            "torod_courier_id_unique" => "Parcel's company ID already exists",
            "logo_image" => "The uploaded logo must be an image type",
            "logo_mimes" =>
                "The allowed extensions for the logo are jpeg, png, jpg, gif, svg",
            "logo_max" => "The maximum size for a company logo is 2048M",
        ],
    ],
    "integrations" => [
        "national-warehouse" => "Saudi Arabia local warehouse",
    ],
    "statistics" => [
        "admin" => [
            "total_customers" => "Total Customers",
            "total_orders" => "Total Orders",
            "total_sales" => "Total Sales",
            "total_revenues" => "Total Revenues",
            "total_vendors" => "Total Vendors",
            "customer_rating_ratio" => "Customer Rating Ratio",
            "best_selling_vendors" => "Best Selling Vendors",
            "best_selling_products" => "Best Selling Products",
            "total_selling_categories" => "Total Selling Categories",
            "most_requested_customers" => "Most Requested Customers",
            "total_requests_according_to_status" => "The number of requests according to each Status",
            "total_requests_according_to_country" => "The number of applications according to each country",
            "products_count" => "Total Products",
            "product" => "Product",
            "order" => "Order",
            "products_not_found" => "No Products Found",
            "no_orders_found" => "No Orders Found"
        ],
        "vendor" => [
            "total_orders" => "The number of orders",
            "total_sales" => "total sales",
            "total_revenues" => "Total earnings",
            "best_selling_products" => "Best selling products",
            "total_requests_according_to_status" =>
                "The number of requests according to each case",
            "total_requests_according_to_country" =>
                "The number of applications according to each country",
        ],
        "customer" => "client",
        "order" => "to request",
        "vendors" => "merchant",
    ],
    "shipping_type" => "Shipping type",
    "shippingMethods" => [
        "integration_key" => "binding code",
        "choose_key" => "Choose the link code",
        "choose_type" => "Choose the type of shipment",
        "create" => "Set up a shipping company",
        "logo" => "Shipping company's photo",
        "store" => "save",
        "name_ar" => "The name is in Arabic",
        "name_en" => "English name",
        "type" => "Type",
        "cod_collect_fees" => "Home pay collection expenses",
        "id" => "Shipping company ID",
        "manage_shippingMethods" => "Shipping companies management",
        "search" => "research",
        "filter" => "filtering",
        "not_found" => "There are no shipping companies",
        "index" => "shipping companies",
        ShippingMethodType::NATIONAL => "local",
        ShippingMethodType::INTERNATIONAL => "international",
        "show" => "Shipping company offer",
        "edit" => "Modify the shipping company",
        "delete" => "Delete the shipping company",
        "delete_modal" => [
            "title" => "Confirm deletion",
            "description" =>
                "Are you sure you want to delete the shipping company?",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Shipping company established successfully",
            "created_successfully_body" =>
                "Shipping company established successfully",
            "created_error_title" => "Error creating shipping company",
            "created_error_body" =>
                "Something went wrong while creating the shipping company",
            "updated_successfully_title" =>
                "Shipping company has been modified successfully",
            "updated_successfully_body" =>
                "Shipping company has been modified successfully",
            "updated_error_title" => "Error while modifying shipping company",
            "updated_error_body" =>
                "An error occurred while modifying the shipping company",
            "deleted_successfully_title" =>
                "Shipping company has been successfully deleted",
            "deleted_successfully_message" =>
                "Shipping company has been successfully deleted",
            "deleted_error_title" =>
                "Error while deleting the shipping company",
            "deleted_error_message" =>
                "Something went wrong while deleting the carrier",
            "related-domestic-zones-synced" =>
                "The shipping company has been linked to the delivery areas successfully",
        ],
        "related-domestic-zones" => "Shipping company delivery areas",
        "torod" => "Torod",
        "bezz" => "Beez",
        "spl" => "Spl",
        "aramex" => "Aramex"
    ],
    "order_statuses" => [
        OrderStatus::REGISTERD => "Under construction",
        OrderStatus::PAID => "paid",
        OrderStatus::SHIPPING_DONE => "Delivered",
        OrderStatus::IN_DELEVERY => "Delivery is in progress",
        OrderStatus::COMPLETED => "complete",
        OrderStatus::CANCELED => "canceled",
        "refund" => "throwback",
    ],
    "banks" => [
        "title" => "banks",
        "single_title" => "the bank",
        "all_banks" => "All banks",
        "manage_banks" => "Bank management",
        "id" => "Bank ID",
        "name_ar" => "Arabic name",
        "name_en" => "The name is in English",
        "is_active" => "the condition",
        "yes" => "Yes",
        "no" => "no",
        "create" => "Create a new bank",
        "update" => "Bank adjustment",
        "search" => "research",
        "all" => "everyone",
        "filter" => "filtering",
        "not_found" => "nothing",
        "show" => "View bank data",
        "delete" => "delete",
        "active" => "active",
        "inactive" => "not active",
        "choose_status" => "Select the state of the bank",
        "filter_is_active" => "Filter by status",
        "delete_modal" => [
            "title" => "You are about to delete a bank",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "The bank has been created successfully",
            "created_successfully_body" =>
                "The bank has been created successfully",
            "created_error_title" => "Error creating bank",
            "created_error_body" =>
                "Something went wrong while creating the bank",
            "updated_successfully_title" =>
                "The bank has been modified successfully",
            "updated_successfully_body" =>
                "The bank has been modified successfully",
            "updated_error_title" => "Error while modifying the bank",
            "updated_error_body" =>
                "An error occurred while modifying the bank",
            "deleted_successfully_title" =>
                "The bank has been deleted successfully",
            "deleted_successfully_message" =>
                "The bank has been deleted successfully",
            "deleted_error_title" => "Error while deleting the bank",
            "deleted_error_message" =>
                "Something went wrong while deleting the bank",
        ],
        "validations" => [
            "name_ar_required" => "Bank name in Arabic is required",
            "name_ar_string" => "The Arab Bank name must be a string",
            "name_ar_min" =>
                "The minimum number of letters in the name of the Arab Bank is at least 3 letters",
            "name_en_required" => "The name of the bank in English is required",
            "name_en_string" => "The English bank name must be a string",
            "name_en_min" =>
                "The minimum number of letters in the name of the English bank is at least 3 letters",
        ],
    ],
    "general_settings" => "General Settings",
    "warning" => "warning",
    "action-disabled" => "This action is currently disabled",
    "is_visible" => "the condition",
    "bezz" => "Bees Corporation",
    "tracking_id" => "Shipment tracking ID",
    "no_shipment" => "Not shipped yet",
    "shipping_info" => "shipping data",
    "track_shipment" => "order tracking",
    "beez_id" => "Biz Store ID",
    "beez_id_unique" => "The Biz Store ID already exists",
    "paid" => "paid",
    "update" => "to update",
    "delete" => "delete",
    "shipping_type_placeholder" => "Choose the type of connection",
    "shipping_countries_placeholder" => "Select country",
    "country_associated_to_domestic_zone" =>
        "The country is already linked to a delivery area",
    "national" => "local",
    "international" => "international",
    "country" => "Country",
    "country_placeholder" => "Select country",
    "countries_prices" => [
        "id" => "Bank ID",
        "title" => "Product price according to each country",
        "country" => "Country",
        "price" => "English name",
        "price_before" => "the condition",
        "add_edit_alert" =>
            "It will be allowed to modify or add the price of the product for each country in the event that this product is modified",
        "list" => "View product prices according to each country",
        "delete_modal" => [
            "title" => "You are about to delete a country price",
            "description" =>
                "Deleting your application will remove all of your information from our database.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "State rate has been created successfully",
            "created_successfully_body" =>
                "State rate has been created successfully",
            "created_error_title" => "Error creating state price",
            "created_error_body" =>
                "An error occurred while creating the country price",
            "updated_successfully_title" =>
                "The state price has been modified successfully",
            "updated_successfully_body" =>
                "The state price has been modified successfully",
            "updated_error_title" => "Error while adjusting the country price",
            "updated_error_body" =>
                "An error occurred while adjusting the country price",
            "deleted_successfully_title" =>
                "Country price has been deleted successfully",
            "deleted_successfully_message" =>
                "Country price has been deleted successfully",
            "deleted_error_title" => "Error while deleting the country price",
            "deleted_error_message" =>
                "An error occurred while deleting the country price",
        ],
        "validations" => [
            "country_id_required" => "state required",
            "price_with_vat_required" => "You must enter the price with tax",
            "price_before_required" =>
                "The price must be entered before the discount",
            "price_min" => "The lowest price should be ",
            "price_before_offer_min" => "The lowest price should be ",
            "price_max" => "The maximum price should be 1,000,00",
            "price_before_offer_max" => "The maximum price should be 1,000,00",
        ],
    ],
    "transaction_sent_to_bezz_before" => "That request was sent to Biz before",
    "transaction_sent_to_bezz" => "The request was sent to Biz",
    "transaction-send-to-bezz" => "Send the request to Biz",
    "transaction_warnings" => "Alerts for order",
    "stock-decrement-errors" => "An wrong event when updating the quantities with products",
    "stock-country-missed" => "There is no storage for a country: Country in order No.: Transaction",
    "stock-warehouse-missed" => "There is no warehouse store: Warehouse is dedicated to the product: Product",
    "stock-increment-errors" => "An error occurred when returning the quantities of products",
    "transaction-missed-shipping-method" => "Request shipping company does not exist order number: transaction",
    "reports" => [
        "title" => "Reports",
        "select-vendor" => "Choose a store",
        "date-from" => "History from",
        "date-to" => "History to me",
        "print" => "Print the report",
        "excel" => "Excel Export",
        "vendors-orders" => [
            "title" => "Store requests",
            "vendor" => "the shop",
            "order-code" => "Request code",
            "order-id" => "order number",
            "created-at" => "Date of construction of the application",
            "delivered-at" => "Date of delivery of the application",
            "total-without-vat" => "Total request without vat",
            "vat-rate" => "Tax value",
            "total-with-vat" => "Total request with VAT",
            "company-profit-without-vat" => "Platform commission without vat",
            "company-profit-vat-rate" => "The value of the platform commission tax",
            "company-profit-with-vat" => "Platform commission with VAT",
            "vendor-amount" => "Trader's dues",
            "no-orders" => "Please change the search data",
            "sum-total-without-vat" => "Total sales without vat",
            "sum-vat-rate" => "Tax value",
            "sum-total-with-vat" => "Total sales with VAT",
            "sum-company-profit-without-vat" => "Platform commission without vat",
            "sum-company-profit-vat-rate" => "The value of the platform commission tax",
            "sum-company-profit-with-vat" => "Platform commission with VAT",
            "sum-vendor-amount" => "Total merchant dues",
            "print-vendor" => "Trader sales report received charges received",
            "tax-num" => "Tax Number: NUM",
            "date" => "on the date",
        ],
        "center-name" => "المركز الوطني للنخيل و التمور",
        "center-tax-num" => "الرقم الضريبي: 310876568300003",
    ],
    "date-range-invalid" => "يرجي إختيار (التاريخ إلي) أكبر من (التاريخ من)",

    "warehouse_name" => "Warehouse name",
    "warehouse_name_plcaholder" => "Warehouse name",
    'both' => 'Both',
    'deliver' => 'Deliver',
    'receive' => 'Receive',
    'warehouse_type' => 'Warehouse type',
    'vendor-has-deliver-warehouse' => 'Vendor already have delivered warehouse!',
    'order_amount_is_too_high'=>'Order Amount Is Too High' ,
    'reports' => [
        'reports' => 'Reports',
        'no_result_found' => 'There are no data available for reports',
        'filter' => 'Filter'  ,
        'search_id' => 'Search in IDs',
        'search_barcode' => 'Search in Barcode',
        'search_vendor_name' => 'Search in Vendors Name',
        'search_stock' => 'Search in Stock',
        'search_product_name' => 'Search in Products Name',

        'product_quantity' => 'Quantity Reports',
        'mostSellingProducts' => 'Most Selling Products',
        'vendorsSales' => 'Vendors Sales',
        'PaymentMethods' => 'Payment Methods',
        'SatisfactionClientsWallet' => 'SatisFaction Clients Wallet',
        'OrdersShipping' => 'Orders Shipping',
        'ShippingCharges' => 'ShppingCharges',
        'ShippingChargesCompleted' => 'Shipping Charges Completed',
        'ShippingChargesWait' => 'Shipping Charges Wait',

    ]

];
