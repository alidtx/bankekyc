<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormAccountType extends Model {

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function formType() {
        return $this->hasMany('App\Modules\FormBuilder\Models\FormType', 'account_type', 'id')->with(array('form' => function($querySelect) {
                        $querySelect->select('id', 'form_type_code','kyc_type');
                    }));
    }

}
