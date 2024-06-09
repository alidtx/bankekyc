<?php

namespace App\Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldQuestionnaires extends Model {

    protected $table = 'form_field_questionnaires';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function formFieldQuestionOption() {
        return $this->hasMany(FormFieldQuestionnairesOption::class, 'form_field_questionnaires_uid', 'form_field_questionnaires_uid')->with('questionOptionInfo');
    }

    public function formField() {
        return $this->hasOne(FormField::class, 'id', 'form_field_id');
    }

    public function question() {
        return $this->hasOne(\App\Modules\ScoringSystem\Models\ScoreQuestionnaire::class, 'questionnaire_uid', 'questionnaire_uid');
    }

}
