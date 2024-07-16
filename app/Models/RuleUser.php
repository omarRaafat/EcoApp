<?php

namespace App\Models;

use App\Models\Rule;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuleUser extends Pivot
{
    use HasFactory, SoftDeletes;

    public $table = "rule_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "user_id",
        "rule_id"
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class, "rule_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
