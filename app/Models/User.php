<?php

namespace App\Models;

use App\Models\Wallet;
use App\Enums\UserTypes;
use App\Traits\AdminHasRole;
use App\Models\UserVendorRate;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use App\Models\VendorWarehouseRequest;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\WalletTransactionHistory;
use App\Traits\VendorHasRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, AdminHasRole,VendorHasRole, VendorHasRole, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'type',
        'verification_code',
        'verification_code_expiration_date',
        'token_code',
        'vendor_id',
        'image',
        'country_id',
        'priority',
        'is_banned',
        'lang',
        'is_active',
        'ip',
        'fcm_token',
        'country_code',
        'type_of_employee_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public array $customer_priorities = ['perfect','important','regular','parasite','caution','noDeal'];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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

    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function setAvatarAttribute($avatar)
    {
        if(isset($avatar) && is_file($avatar))
        {
            $avatar_name = uploadFile($avatar, 'images/customers/');
            File::delete($this->avatar);
            $this->attributes['avatar'] = 'images/customers/' . $avatar_name;
        }
    }

    public function setImageAttribute($image)
    {
        if(isset($image) && is_file($image))
        {
            $image_name = uploadFile($image, 'images/customers/');
            File::delete($this->image);
            $this->attributes['image'] = 'images/customers/' . $image_name;
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'product_id');
    }
    public function typeOfEmployee()
    {
        return $this->belongsTo(TypeOfEmployee::class,'type_of_employee_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get list of user(customer) rates that against vendors.
     *
     * @return HasMany
     */
    public function userVendorRates() : HasMany
    {
        return $this->hasMany(UserVendorRate::class);
    }

    /**
     * Get Customer Wallet.
     *
     * @return HasOne
     */
    public function ownWallet() : HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id');
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function my_vendor()
    {
        return $this->hasOne(Vendor::class,'user_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function favorite_products()
    {
        return $this->belongsToMany(Product::class, 'favorite_products');
    }

    /**
     * Get All Vendor Warehouse Requests.
     *
     * @return HasMany
     */
    public function vendorWareHouseRequests() : HasMany
    {
        return $this->hasMany(VendorWarehouseRequest::class ,'created_by_id');
    }

    /**
     * Witch Admin Create This Request.
     *
     * @return HasMany
     */
    public function adminCreatedRequests(): HasMany
    {
        return $this->hasMany(VendorWarehouseRequest::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_role');
    }

    public function hasPermissionTo($permission)
    {
        if($role=$this->roles()->first())
        {
            return (in_array($permission, $role->permissions)) ?true:false;
        }
        return false;
    }

    public function scopeVendorUser(Builder $query) : Builder {
        return $query->where(
            fn($q) => $q->where('type', UserTypes::VENDOR)->orWhere('type', UserTypes::SUBVENDOR)
        );
    }

    public function scopeAdminUser(Builder $query) : Builder {
        return $query->where(
            fn($q) => $q->where('type', UserTypes::ADMIN)->orWhere('type', UserTypes::SUBADMIN)
        );
    }

    public function scopeAdminGroupPermitted(Builder $query, string $group) : Builder {
        return $query->where(
            function($whereQuery) use ($group) {
                $whereQuery->whereHas(
                    'rules',
                    fn($rule) => $rule->whereHas(
                        'permissions', fn($q) => $q->where('group', $group)
                    )
                )
                ->orWhere('type', UserTypes::ADMIN);
            }
        );
    }

    public function scopeCustomerUser(Builder $query) : Builder {
        return $query->where('type', UserTypes::CUSTOMER);
    }

    public function scopePhone(Builder $query, string $phone) : Builder {
        return $query->where('phone', $phone);
    }

    public function scopeFilterBySearch($query,$term){
        $query->when($term,function ($query, $term){
            $query->where('name','like',$term.'%')->orWhere('phone','like',$term)->orWhere('identity','like',$term.'%');
        });
    }
}

