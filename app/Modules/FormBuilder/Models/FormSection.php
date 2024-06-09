<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSection extends Model
{
	use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\Form');
    }

    // public function form_fields()
    // {
    //     return $this->hasMany('App\Modules\FormBuilder\Models\FormField','section_id','id')->orderby('sequence','asc');
    // }
}
