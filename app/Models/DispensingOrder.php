<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Yajra\DataTables\Html\Editor\Fields\BelongsTo;

class DispensingOrder extends Model
{
    use HasFactory;

    protected $table = 'dispensing_orders';

    protected $fillable = ['vendor_id' , 'order_id' , 'amount' , 'initial_admin_id' , 'final_admin_id' , 'type' , 'status'];

    /**
     * @return BelongsTo
     */
    public function orders(): BelongsTo
    {
        return $this->belongsTo('App\Models\Order' , 'order_id');
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
