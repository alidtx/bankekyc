<?php


namespace App\Modules\FormBuilder\Services\Api\V1;


use App\Modules\FormBuilder\Models\Form;
use App\Modules\FormBuilder\Models\FormSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FormSectionService
{
    public function storeFormSection(Request $request)
    {
        $formSection = FormSection::create([
            'form_id' => $request->form_id,
            'name' => $request->name,
            'form_platform_type' => $request->form_platform_type,

            'verification_type' => $request->verification_type,
            'section_type' => $request->section_type,
            'is_preview_on' => !!$request->is_preview_on,
            'can_go_previous_step' => !!$request->can_go_previous_step,

            'section_id' => $request->section_id,
            'section_class' => $request->section_class,
            'api_endpoint' => $request->api_endpoint,
            'should_validated' => !!$request->should_validated,
            'validation_api_url' => $request->validation_api_url,
            'field_mapper_data' => $request->field_mapper_data,
            'sequence' => $request->sequence,
            'carry_forward_data' => $request->carry_forward_data,
            'is_show_on_tab' => $request->is_show_on_tab
        ]);
        return $formSection ? $formSection : 'Something went wrong! please try again later';
    }

    public function updateFormSection(Request $request, $id)
    {
        $formSection = FormSection::findOrFail($id);
        $formSection = $formSection->update([
            'form_id' => $request->form_id,
            'name' => $request->name,
            'form_platform_type' => $request->form_platform_type,

            'verification_type' => $request->verification_type,
            'section_type' => $request->section_type,
            'is_preview_on' =>  isset($request->is_preview_on) ? !!$request->is_preview_on : false, // $request->section_preview_on,
            'can_go_previous_step' =>  isset($request->can_go_previous_step) ? !!$request->can_go_previous_step : false, //$request->can_go_previous_step,

            'section_id' => $request->section_id,
            'section_class' => $request->section_class,
            'api_endpoint' => $request->api_endpoint,
            'should_validated' => isset($request->should_validated) ? !!$request->should_validated : false,
            'validation_api_url' => $request->validation_api_url,
            'field_mapper_data' => $request->field_mapper_data,
            'sequence' => $request->sequence,
            'carry_forward_data' => $request->carry_forward_data,
            'is_show_on_tab' => $request->is_show_on_tab
        ]);
        if ($formSection) return FormSection::find($id);
        return 'Something went wrong! please try again later';
    }

    public function deleteFormSection(int $id)
    {
        $delete = FormSection::find($id)->delete();
        return $delete ? $delete : 'Something went wrong! please Try again later';
    }
}

//$data = [];
//foreach ($request->data as $formSection) {
//    $formSection = json_decode(json_encode($formSection));
//    $data[] = [
//        'form_id' => $formSection->form_id,
//        'name' => $formSection->name,
//        'form_platform_type' => $formSection->form_platform_type,
//        'section_id' => $formSection->section_id,
//        'section_class' => $formSection->section_class,
//        'api_endpoint' => $formSection->api_endpoint,
//        'should_validated' => isset($formSection->should_validated) ? !!$formSection->should_validated : false,
//        'validation_api_url' => $formSection->validation_api_url,
//        'sequence' => $formSection->sequence,
//        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
//    ];
//}
//$formSection = FormSection::insert($data);
//$formSections = FormSection::where('from_id',$data[0]['form_id'])->get();
