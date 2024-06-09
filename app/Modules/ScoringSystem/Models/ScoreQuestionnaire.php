<?php

namespace App\Modules\ScoringSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreQuestionnaire extends Model
{
    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(ScoreQuestionnaireOption::class, 'questionnaire_uid', 'questionnaire_uid')->orderBy('option_sequence', 'ASC');
    }
    public function questionGroup()
    {
        return $this->hasOne(ScoreQuestionGroup::class, 'group_id', 'group_id');
    }
    public function scoreType()
    {
        return $this->hasOne(ScoreType::class, 'score_type_uid', 'score_type_uid');
    }
}
