<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\ScreeningList;
// use MongoDB\Client as Mongo;
use Illuminate\Http\Request;

class ScreeningController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $screeningList = ScreeningList::orderby('created_at', 'desc')->paginate(25);
        // dd($screeningList);
        return view('screening.index', compact('screeningList'));
    }

    public function test() {
        // $data = array('name' => 'shakil');
        // $insertData = DB::connection('mongodb')->collection('laraC')->insert($data);
        // echo "done";
        // exit;
        $mongo = new Mongo;
        // $connection = $mongo->laravel->laraC;
        $connection = DB::connection('mongodb')->collection('laraC');
        return $connection->where('name', 'shakil')->delete();
        // return $connection->find()->toArray();
    }

    public function store(Request $request) {
        // get previous data and delete
        $screeningList = ScreeningList::where('source_type', 'external')->count();
        if ($screeningList > 0) {
            ScreeningList::where('source_type', 'external')->delete();
        }

        $fileContents = file_get_contents($request->xml_url);
        // $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        // $fileContents = trim(str_replace('"', "'", $fileContents));
        // $simpleXml = simplexml_load_string($fileContents);

        $xml = simplexml_load_string($fileContents);
        $json = json_encode($xml);

        $getAllData = $xml->children();
        $requiredData = $getAllData->INDIVIDUALS->INDIVIDUAL;

        $i = 0;
        foreach ($requiredData as $screen) {
            $screenData[$i]['data_id'] = (string) $screen->DATAID ?? '';
            $screenData[$i]['name'] = $screen->FIRST_NAME . ' ' . $screen->SECOND_NAME . ' ' . $screen->THIRD_NAME ?? '';
            $screenData[$i]['un_list_type'] = (string) $screen->UN_LIST_TYPE ?? '';
            $screenData[$i]['listed_on'] = (string) $screen->LISTED_ON ?? '';
            $screenData[$i]['reference_number'] = (string) $screen->REFERENCE_NUMBER ?? '';
            $screenData[$i]['designation'] = (string) $screen->DESIGNATION->VALUE ?? '';
            $screenData[$i]['nationality'] = (string) $screen->NATIONALITY->VALUE ?? '';
            $screenData[$i]['country'] = (string) $screen->INDIVIDUAL_ADDRESS->VALUE ?? '';
            $screenData[$i]['dob'] = (string) $screen->INDIVIDUAL_DATE_OF_BIRTH->DATE ?? '';
            $screenData[$i]['type_of_document'] = (string) $screen->INDIVIDUAL_DOCUMENT->TYPE_OF_DOCUMENT ?? '';
            $screenData[$i]['document_number'] = (string) $screen->INDIVIDUAL_DOCUMENT->NUMBER ?? '';
            $screenData[$i]['source_type'] = 'external'; // so that external dhore data remove kore perr month e insert kora jay
            $screenData[$i]['created_at'] = date('Y-m-d h:i:s');
            $screenData[$i]['updated_at'] = date('Y-m-d h:i:s');
            $i++;
        }


        // echo "<pre>";
        //     print_r($screenData); 
        //     echo "</pre>";
        // echo json_encode($screenData);

        $screening = new ScreeningList();
        $screening->insert($screenData);

        // echo "insert successfully";
        // exit;
        // exit;
        // dd($screenData);
        // return $json;

        return redirect()->back()->with("success", "Item Create Successfully");
    }

    public function addItem(Request $request) {
        
        unset($request['_token']); // only for mysql. disable it for mongo
        $request->merge(['source_type' => 'internal', 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
        // dd($request->all());
        $screening = new ScreeningList();
        $screening->insert($request->all());
        return redirect()->back()->with("success", "Item Create Successfully");
    }

    public function search() {
        return view('screening.search');
    }

    public function doSearch(Request $request) {
        $name = $request->name;
        $document_number = $request->document_number;
        $documentReturnStr = "";
        if ($document_number) {
            $searchData = ScreeningList::where('name', 'LIKE', '%' . $name . '%')->where('document_number', $document_number)->first();
            $documentReturnStr = ", ".$document_number;
        } else {
            $searchData = ScreeningList::where('name', 'LIKE', '%' . $name . '%')->first();
        }
        if ($searchData) {
            return redirect()->back()->with("success", "Data Found. Search value : " . $name . " " . $documentReturnStr);
        }
        return redirect()->back()->with("error", "Data Not Found. Search value : " . $name . " " . $documentReturnStr);
    }

}
