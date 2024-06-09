<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormAuditLog extends Model
{
	protected $table = 'ekyc_form_audit_logs';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\Form');
    }
}
