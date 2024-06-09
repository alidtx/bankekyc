<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldQuestionnairesOption extends Model {

    protected $table = 'form_field_questionnaire_options';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function questionOptionInfo() {
        return $this->hasOne(\App\Modules\ScoringSystem\Models\ScoreQuestionnaireOption::class, 'option_id', 'questionnaire_option_id');
    }

}
