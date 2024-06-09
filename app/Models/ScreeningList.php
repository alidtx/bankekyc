<?php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\ Model as Eloquent;

// class ScreeningList extends Eloquent
// {
//     protected $connection = 'mongodb';
//     protected $collection = 'screening_lists';
   
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningList extends Model
{
    protected $guarded=['id'];
}
