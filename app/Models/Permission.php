<?php

namespace App\Models;

use App\Models\Rule;
use App\Models\PermissionRule;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends BaseModel
{
    use SoftDeletes,HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "scope",
        "name",
        "module",
        "route",
        "group"
    ];

    protected $casts = [
        "route" => "json"
    ];

    /**
     * The attributes needs to be transelated.
     *
     * @var array
     */
    public $translatable=["name", "module"];

    /**
     * Get All Rules assossiated to this user using custom pivot Model|Table.
     *
     * @return BelongsToMany
     */
    public function rules() : BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'permission_rules', 'permission_id', 'rule_id')
                    ->using(PermissionRule::class)
                    ->withPivot(["permission_id", "rule_id"]);
    }
}
