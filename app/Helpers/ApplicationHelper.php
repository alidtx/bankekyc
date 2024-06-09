<?php

namespace App\Helpers;

use App\Modules\FormBuilder\Models\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationHelper
{
    public static function getCount($status, $role)
    {

        try {
            $status = ApplicationHelper::checkRoleWiseStatus($status, $role);
            if (!$status) return '';
            $applicationListCount = FormRequest::where('status', $status)->count();
            return $applicationListCount ? $applicationListCount : '';
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return '';
        }
    }

    private static function checkRoleWiseStatus($status, $role)
    {
        if ($status === 'pending' && $role == 'checker') {
            return 'submitted';
        } else if ($status === 'pending' && $role == 'approver') {
            return 'checked';
        } else if ($status === 'approved' && $role == 'checker') {
            return 'checked';
        } else if ($status === 'approved' && $role == 'approver') {
            return 'approved';
        } else if ($status === 'declined' && $role == 'approver') {
            return 'declined';
        } /*else if ($role == 'admin') {
            return 'all';
        }*/ else {
            return false;
        }
    }
}

