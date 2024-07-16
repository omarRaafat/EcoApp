<?php

namespace App\Models;

use App\Enums\RuleEnum;
use App\Models\User;
use App\Models\RuleUser;
use App\Models\Permission;
use App\Models\PermissionRule;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends BaseModel
{
    use  HasTranslations, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "name",
        "scope"
    ];

    /**
     * Columns need to be translated.
     * @var array
     */
    public $translatable = ['name'];

    /**
     * Get All Users assossiated to this rule using custom pivot Model|Table.
     *
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rule_users', 'user_id', 'rule_id')
                    ->withPivot(["user_id", "admin_id"]);;
    }

    /**
     * Get All Permssions assossiated to this rule using custom pivot Model|Table.
     *
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_rules', 'rule_id', 'permission_id')
                    ->withPivot(["permission_id", "rule_id"]);;
    }

    public function scopeSubAdmin(Builder $query) : Builder {
        return $query->where("scope", RuleEnum::SUB_ADMIN);
    }
}
