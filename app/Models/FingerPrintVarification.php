<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FingerPrintVarification extends Model
{
    protected $guarded=['id'];

    public function images()
    {
        return $this->hasMany(FingerprintImage::class, 'user_id', 'id');
    }

}
