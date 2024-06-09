<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo('App\Modules\FormBuilder\Models\Form');
    }

     // public function sections()
     // {
     //     return $this->hasMany(FormSection::class, 'form_id', 'form_id');
     // }
}
