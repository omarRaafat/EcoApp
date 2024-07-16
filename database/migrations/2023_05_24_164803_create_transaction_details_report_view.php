<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::statement(<<<SQL
//            CREATE OR REPLACE VIEW transaction_details_report AS
//                select
//                    transactions.created_at as transaction_created_at,
//                    transactions.id as transaction_id,
//                    transactions.code as transaction_code,
//                    order_ships.gateway_order_id as ship_tracking_id,
//                    (transactions.sub_total + transactions.total_vat + transactions.delivery_fees - transactions.discount) / 100 as transaction_total_sar,
//                    transactions.payment_method as payment_method,
//                    users.name as customer_name,
//                    users.phone as customer_phone,
//                    countries.name->>"$.ar" as country_name,
//                    cities.name->>"$.ar" as city_name,
//                    shipping_methods.name->>"$.ar" as shipping_method,
//                    transactions.delivery_fees / 100 as transaction_total_delivery_fees_sar,
//                    transactions.base_delivery_fees / 100 as transaction_base_delivery_fees_sar,
//                    transactions.packaging_fees / 100 as transaction_packaging_fees_sar,
//                    transactions.cod_collect_fees / 100 as transaction_collect_cod_fees_sar,
//                    case transactions.status
//                        when 'registered' then "قيد التجهيز"
//                        when 'paid' then "قيد التجهيز"
//                        when 'in_delivery' then "قيد التجهيز"
//                        when 'in_shipping' then "جاري الشحن"
//                        when 'shipping_done' then "تم التسليم"
//                        when 'in_delivery' then "جاري التوصيل"
//                        when 'completed' then "تم التسليم"
//                        when 'canceled' then "ملغي"
//                        when 'refund' then "مرتجع"
//                    end as transaction_status,
//                    (
//                        select sum(order_products.quantity)
//                        from orders
//                        join order_products on orders.id = order_products.order_id
//                        where orders.transaction_id = transactions.id
//                    ) as transaction_quantities,
//                    (
//                        select sum(products.net_weight * order_products.quantity)
//                        from products
//                        join order_products on products.id = order_products.product_id
//                        join orders on orders.id = order_products.order_id
//                        where orders.transaction_id = transactions.id
//                    ) as transaction_net_wieght_gram
//                from transactions
//                left join order_ships on order_ships.reference_model_id = transactions.id
//                left join users on users.id = transactions.customer_id
//                left join addresses on addresses.id = transactions.address_id
//                left join countries on countries.id = addresses.country_id
//                left join cities on cities.id = addresses.city_id
//                left join shipping_methods on transactions.shipping_method_id = shipping_methods.id;
//        SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW transaction_details_report");
    }
};
