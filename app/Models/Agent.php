<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable {

    use SoftDeletes,
        HasApiTokens,
        Notifiable;

    protected $guarded = ['id'];
    protected $guard = 'agent';
    protected $primaryKey = 'agent_id';
    
    public function branchInfo()
    {
        return $this->hasOne(Branch::class,'id','branch');
    }

}
