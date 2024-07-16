<?php

namespace App\Providers;

use App\Events\Transaction as TransactionEvents;
use App\Listeners\Transaction as TransactionListeners;

use App\Events\ServiceTransaction as ServiceTransactionEvents;
use App\Listeners\ServiceTransaction as ServiceTransactionListeners;

use App\Events\Admin\Vendor as AdminVendorEvents;
use App\Events\Admin\Product as AdminProductEvents;
use App\Events\Admin\Service as AdminServiceEvents;
use App\Events\Warehouse\CreateBezzShippingApiCall;
use App\Listeners\Notifications\Vendor as NotificationsVendorListeners;
use App\Listeners\Notifications\Product as NotificationsProductListeners;
use App\Listeners\Notifications\Service as NotificationsServiceListeners;

use App\Events\Warehouse\CreateVendorWarehouseRequest;
use App\Listeners\Warehouse\BeezSotrageRequestListener;
use App\Models\Order;
use App\Listeners\Warehouse\CreateBezzShippingApiCallListener;
use App\Models\OrderService;
use App\Models\Transaction;
use App\Observers\OrderObserver;
use App\Observers\TransactionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Observers\OrderVendorShippingObserver;
use App\Models\OrderVendorShipping;
use App\Observers\OrderServiceObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateVendorWarehouseRequest::class => [
            BeezSotrageRequestListener::class,
        ],

        // check this task to validate the needed business from Client
        // https://hub.tasksa.dev/bapplite/#app/todos/project-7238331330/list-262852053359/task-292466220055
        TransactionEvents\Created::class => [
            TransactionListeners\Created\AdminListener::class,
            TransactionListeners\Created\VendorListener::class,
            TransactionListeners\Created\InvoiceListener::class,
            TransactionListeners\Created\CustomerListener::class,
            TransactionListeners\Created\WebEngageListener::class,
        ],
        TransactionEvents\Cancelled::class => [
            TransactionListeners\Cancelled\VendorWalletListener::class,
            TransactionListeners\Cancelled\CustomerListener::class,
            TransactionListeners\Cancelled\WebEngageListener::class,
        ],
        ServiceTransactionEvents\Cancelled::class => [
            ServiceTransactionListeners\Cancelled\VendorWalletListener::class,
            ServiceTransactionListeners\Cancelled\CustomerListener::class,
            ServiceTransactionListeners\Cancelled\WebEngageListener::class,
        ],
        TransactionEvents\Refund::class => [
            TransactionListeners\Refund\VendorWalletListener::class,
            TransactionListeners\Refund\WebEngageListener::class,
            TransactionListeners\Refund\CustomerListener::class,
        ],
        TransactionEvents\OnDelivery::class => [
            TransactionListeners\OnDelivery\CustomerListener::class,
        ],
        TransactionEvents\Delivered::class => [
            TransactionListeners\Delivered\CustomerListener::class,
            TransactionListeners\Delivered\VendorWalletListener::class,
            TransactionListeners\Delivered\WebEngageListener::class,
            TransactionListeners\Delivered\InvoiceListener::class,
        ],
        TransactionEvents\Completed::class => [
            TransactionListeners\Completed\VendorWalletListener::class,
            TransactionListeners\Completed\CustomerListener::class,
            TransactionListeners\Completed\InvoiceListener::class,
        ],
        AdminVendorEvents\Modify::class => [
            NotificationsVendorListeners\VendorModify::class,
        ],
        AdminVendorEvents\Warning::class => [
            NotificationsVendorListeners\VendorWarning::class,
        ],
        AdminProductEvents\Approve::class =>[
            NotificationsVendorListeners\ProductApprove::class,
        ],
        AdminProductEvents\Reject::class =>[
            NotificationsVendorListeners\ProductReject::class,
        ],
        AdminProductEvents\Modify::class =>[
            NotificationsVendorListeners\ProductModify::class,
        ],
        AdminServiceEvents\Approve::class =>[
            NotificationsVendorListeners\ServiceApprove::class,
        ],
        AdminServiceEvents\Reject::class =>[
            NotificationsVendorListeners\ServiceReject::class,
        ],
        AdminServiceEvents\Modify::class =>[
            NotificationsVendorListeners\ServiceModify::class,
        ],
        AdminProductEvents\Created::class =>[
            NotificationsProductListeners\CreatedListener::class,
        ],
        AdminServiceEvents\Created::class =>[
            NotificationsServiceListeners\CreatedListener::class,
        ],
        CreateBezzShippingApiCall::class => [
            CreateBezzShippingApiCallListener::class,
        ],
    ];

    protected $observers = [
        Transaction::class => [TransactionObserver::class],
        Order::class => [OrderObserver::class],
        OrderService::class => [OrderServiceObserver::class],
        OrderVendorShipping::class => [OrderVendorShippingObserver::class],
        \App\Models\City::class => [\App\Observers\CityObserver::class],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
