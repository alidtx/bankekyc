<?php

namespace App\Modules\FormBuilder\Services\Api\V1;

use App\Modules\FormBuilder\Models\FormAccountType;
use App\Modules\FormBuilder\Models\FormType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormSettingsService {

    public function storeAccountType(Request $request) {
        if (FormAccountType::where('account_type_title', trim($request->accountTitle))->count() > 0) {
            return "Account Type Title is duplicate";
        }

        $formAccountType = new FormAccountType;
        $formAccountType->account_type_title = $request->accountTitle;
        $formAccountType->account_type_sub_title = ($request->accountSubTitle) ? $request->accountSubTitle : NULL;
        $formAccountType->color = ($request->color) ? $request->color : NULL;
        $formAccountType->icon = NULL;
        $formAccountType->created_by = 1; //Auth::user()->id;
        $formAccountType->updated_by = 1; //Auth::user()->id;
        if ($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $image = $request->file('icon');
            $iconName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/formSettings/icon');
            $image->move($destinationPath, $iconName);
            $formAccountType->icon = 'images/formSettings/icon/' . $iconName;
        }

        $formAccountType->save();
        return $formAccountType ? $formAccountType : 'Something went wrong! please try again later';
    }

    public function updateAccountType(Request $request) {
        $formAccountType = FormAccountType::where('id', $request->id)->first();
        if (!$formAccountType) {
            return "No record found";
        }

        if (FormAccountType::whereNotIn('id', [$request->id])->where('account_type_title', trim($request->accountTitle))->count() > 0) {
            return "Account Type Title is duplicate";
        }

        $formAccountType->account_type_title = $request->accountTitle;
        $formAccountType->account_type_sub_title = ($request->accountSubTitle) ? $request->accountSubTitle : NULL;
        $formAccountType->color = ($request->color) ? $request->color : NULL;
        $formAccountType->updated_by = 1; //Auth::user()->id;
        if ($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $image = $request->file('icon');
            $iconName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/formSettings/icon');
            $image->move($destinationPath, $iconName);
            $formAccountType->icon = 'images/formSettings/icon/' . $iconName;
        }

        $formAccountType->save();
        //$formAccountType = FormAccountType::where('id', $request->id)->first();
        return $formAccountType ? $formAccountType : 'Something went wrong! please try again later';
    }

    public function changeStatusAccountType(Request $request) {
        $formAccountType = FormAccountType::where('id', $request->id)->first();
        if (!$formAccountType) {
            return "No record found";
        }
        if ($formAccountType->is_active == 1) {
            $formAccountType->is_active = 0;
        } elseif ($formAccountType->is_active == 0) {
            $formAccountType->is_active = 1;
        }
        $formAccountType->updated_by = 1; //Auth::user()->id;
        $formAccountType->save();
        return $formAccountType ? $formAccountType : 'Something went wrong! please try again later';
    }
    
     public function storeFormType(Request $request) {
        if (FormType::where('type_code', trim($request->type_code))->count() > 0) {
            return "Form type code is duplicate";
        }

        $formType = new FormType;
        $formType->account_type = $request->account_type;
        $formType->type_code = $request->type_code;
        $formType->title = $request->title ;        
        $formType->description = ($request->description) ? $request->description : NULL;
        $formType->color = ($request->color) ? $request->color : NULL;
        $formType->icon = NULL;
        if ($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $image = $request->file('icon');
            $iconName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/formSettings/icon');
            $image->move($destinationPath, $iconName);
            $formType->icon = 'images/formSettings/icon/' . $iconName;
        }

        $formType->save();
        return $formType ? $formType : 'Something went wrong! please try again later';
    }
    
     public function updateFormType(Request $request) {
        $formType = FormType::where('id', $request->id)->first();
        if (!$formType) {
            return "No record found";
        }

        if (FormType::whereNotIn('id', [$request->id])->where('type_code', trim($request->type_code))->count() > 0) {
            return "Form type code is duplicate";
        }
       
        $formType->account_type = $request->account_type;
        $formType->type_code = $request->type_code;
        $formType->title = $request->title ;        
        $formType->description = ($request->description) ? $request->description : NULL;
        $formType->color = ($request->color) ? $request->color : NULL;
        
        if ($request->hasFile('icon')) {
            $request->validate([
                'icon' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $image = $request->file('icon');
            $iconName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/formSettings/icon');
            $image->move($destinationPath, $iconName);
            $formType->icon = 'images/formSettings/icon/' . $iconName;
        }

        $formType->save();
        return $formType ? $formType : 'Something went wrong! please try again later';
    }

}
