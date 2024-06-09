<?php

namespace App\Modules\ScoringSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreType extends Model
{
    protected $guarded = ['id'];

    public function questionnaireGroups()
    {
        return $this->hasMany(ScoreQuestionGroup::class, 'score_type_uid', 'score_type_uid')->orderBy('group_sequence','ASC');
    }
}
