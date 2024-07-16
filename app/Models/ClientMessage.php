<?php

namespace App\Models;

use App\Traits\DbOrderScope;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

class ClientMessage extends BaseModel
{
    use DbOrderScope, HasTranslations;

    protected $fillable = [
        "message", "deletable", "message_for",
    ];

    public $translatable = ['message'];

    public function scopeDeletable(Builder $query) : Builder {
        return $query->where("deletable", false);
    }

    public function scopeMessageFor(Builder $query, string $messageFor) : Builder {
        return $query->where("message_for", $messageFor);
    }

    public function getTransMessage(string $lang) : string {
        if (!in_array($lang, config("app.locales"))) $lang = "ar";
        $msg = "";

        try {
            $msg = $this->getTranslation('message', $lang);
            if (!$msg) {
                $msg = $this->getTranslation('message', "ar");
            }
        } catch (Exception | Error $e) {
            $msg = "";
        }

        return $msg;
    }
}
