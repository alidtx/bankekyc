<?php


namespace App\Modules\DocumentValidatorMiddleTier\Services;


use App\Modules\DocumentValidatorMiddleTier\Models\IdCardDetailLog;
use Carbon\Carbon;

class IDCardService
{
    public static function Store($data)
    {
        return IdCardDetailLog::create($data);
    }

    public static function Get($nid, $type, $dob, $full_name, $upto = null)
    {
        return IdCardDetailLog::where(['dob' => $dob, 'full_name' => $full_name, 'id_card_type' => $type, 'id_card_no' => $nid, 'status' => 'success'])
            ->where('details', '!=', null)
            ->when($upto, function ($q) use ($upto) {
                $q->whereDate('created_at', '>=', Carbon::now()->subDays($upto));
            })
            ->first();
    }
}
