<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $city_id
 * @property int    $city_to_id
 * @property float  $dyna
 * @property float  $lorry
 * @property float  $truck
 *
 */
class LineShippingPrice extends Model
{
    use HasFactory;

    protected $table = 'line_shipping_prices';

    protected  $fillable = [
        'city_id', 'city_to_id', 'dyna' , 'lorry' , 'truck'
    ];

    /**
     * @return BelongsTo
     */
    public function relatedCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return BelongsTo
     */
    public function relatedCityTo(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_to_id');
    }

    /**
     * @param  $clm
     * @return mixed
     */
    public function city($clm)
    {
        return $this->relatedCity->name;
    }

    /**
     * @param $clm
     * @return mixed
     */
    public function city_to($clm)
    {
        return $this->relatedCityTo->name;
    }


}
