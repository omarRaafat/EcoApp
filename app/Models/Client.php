<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject, Auditable
{
    use HasApiTokens, HasFactory, AuditableTrait;

    protected $fillable  = ['name','identity','phone','birthDate','token'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeFilterBySearch($query,$term){
        $query->when($term,function ($query, $term){
            $query->where('name','like',$term.'%')->orWhere('phone','like',$term)->orWhere('identity','like',$term.'%');
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'product_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function ownWallet() : HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id');
    }

    public function authorizationWallet() : HasOne
    {
        return $this->hasOne(AuthorizationWallet::class, 'client_id')->withDefault();
    }
    
    
    /**
     * Get Wallets Transactions Records assossiated to wallet and customer.
     *
     * @return HasMany
     */
    public function walletTrunsaction() : HasMany
    {
        return $this->hasMany(WalletTransactionHistory::class);
    }

    /**
     * Get Wallets Managed By Admin.
     *
     * @return HasMany
     */
    public function managedWallets() : HasMany
    {
        return $this->hasMany(Wallet::class);
    }

     /**
     * Get user order Transactions Managed By Admin.
     *
     * @return HasMany
     */
    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class,'customer_id');
    }

    public function favorite_products()
    {
        return $this->belongsToMany(Product::class, 'favorite_products');
    }

    #الاسم الاول و الاخير فقط
    public function getFirstAndLastName(){
        $names = explode(" ", $this->name);
        $firstName = isset($names[0]) ? $names[0] : "";
        if($firstName == "عبد")  $firstName .= isset($names[1]) ? $names[1] : "";
        $lastName = isset($names[count($names) - 1]) ? $names[count($names) - 1] : "";

        return $firstName.' '. $lastName; 
    }
}
