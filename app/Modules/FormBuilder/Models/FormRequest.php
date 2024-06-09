<?php

namespace App\Modules\FormBuilder\Models;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Model;

class FormRequest extends Model
{
    protected $table = 'ekyc_form_requests';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\Form');
    }

    public function form_input()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormInput');
    }
    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','agent_uid');
    }
}
