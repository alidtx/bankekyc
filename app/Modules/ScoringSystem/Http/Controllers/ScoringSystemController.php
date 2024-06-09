<?php

namespace App\Modules\ScoringSystem\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScoringSystemController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ScoringSystem::welcome");
    }
}
