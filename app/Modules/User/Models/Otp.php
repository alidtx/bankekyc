<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model {

    const UPDATED_AT = null;

    protected $guarded = ['id', 'created_at'];

}
