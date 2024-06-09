<?php

namespace App\Modules\DocumentValidatorMiddleTier\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentValidatorMiddleTierController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("DocumentValidatorMiddleTier::welcome");
    }
}
