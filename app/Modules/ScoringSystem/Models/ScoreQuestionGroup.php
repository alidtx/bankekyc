<?php

namespace App\Modules\ScoringSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreQuestionGroup extends Model
{
    protected $table = 'score_questionnaire_groups';
    protected $guarded = ['id'];

    public function questionnaire()
    {
        return $this->hasMany(ScoreQuestionnaire::class, 'group_id', 'group_id')->orderBy('questionnaire_sequence','ASC');
    }
    
    public function scoreType(){
        return $this->hasOne(ScoreType::class, 'score_type_uid', 'score_type_uid');  //  'foreign_key', 'local_key'
    }
}
