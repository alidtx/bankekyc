<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormInput extends Model
{
    protected $table = 'ekyc_form_inputs';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\Form');
    }

    public function form_request()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\FormRequest');
    }

    public function form_field()
    {
        return $this->belongsTo(FormField::class, 'field_id', 'id');
    }
}
