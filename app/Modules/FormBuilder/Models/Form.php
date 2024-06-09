<?php

namespace App\Modules\FormBuilder\Models;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    

    public function form_section()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormSection')->orderby('sequence', 'asc');
    }

    public function form_fields()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormField');
    }

    public function form_types()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\FormType', 'form_type_code', 'type_code');
    }

    public function child_form()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\Form', 'id', 'parent_form_id');
    }

    public function form_request()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormRequest');
    }

    public function form_audit_log()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormAuditLog');
    }

    public function form_input()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormInput');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_uid', 'partner_uid');
    }
}
