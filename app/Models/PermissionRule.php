<?php

namespace App\Models;

use App\Models\Rule;
use App\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PermissionRule extends Pivot
{
    use HasFactory,SoftDeletes;

    public $table = "permission_rules";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "permission_id",
        "rule_id"
    ];

    /**
     * Get The permssion assossiated to this pivot record.
     * 
     * @return BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class, "permission_id", "id");
    }

    /**
     * Get The rule assossiated to this pivot record.
     * 
     * @return BelongsTo
     */
    public function rule()
    {
        return $this->belongsTo(Rule::class, "rule_id", "id");
    }
}
