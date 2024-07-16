<?php

    namespace App\Services;

    use App\Models\Log;
    use Illuminate\Support\Facades\Auth;

    class LogService
    {
        /**
         * Add Log Record to System
         *
         * @param array $logData['user_id','action','model_type','model_id','object_before','object_after']
         * @return void
         */
        static public function InLog(array $logData) : void
        {
            $logData["user_id"] = ($logData["user_id"])?$logData["user_id"]:((Auth::check())?Auth::user()->id:null);

            if($logData["user_id"] && $logData["action"])
            {
                $newLog = Log::create($logData);
            }
        }
    }
