<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function form()
    {
        return $this->hasMany('App\Modules\FormBuilder\Models\Form','form_type_code','type_code');
    }
    public function accountType()
    {
        return $this->hasOne('App\Modules\FormBuilder\Models\FormAccountType','id','account_type');
    }
}
