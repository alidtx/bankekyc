<?php

namespace App\Http\Controllers;
use App\Models\FingerPrintVarification;
use App\Models\FingerprintImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;  
use Illuminate\Support\Facades\DB;
class FingerPrintVarificationController extends Controller
{
   
    public function index()
    {
        
        $fingerPrintData['data']=FingerPrintVarification::with('images')->orderBy('id', 'DESC')->paginate(10);
        return view('finger-print.index', $fingerPrintData);
    }
    
 
    public function storeData(Request $request) {
      foreach ($request->Images as $imageData) {
        $image = $imageData['Image'];
        $decodedImageData = base64_decode($image);
        $filename = uniqid() . '.bmp';
        $storagePath = public_path('upload/finger_img/');
       if (!file_exists($storagePath)) {
          mkdir($storagePath, 0755, true);
      }
      $imagePath = $storagePath . $filename;
      file_put_contents($imagePath, $decodedImageData);
      $lastedId=FingerPrintVarification:: latest()->first();
        $model=new FingerprintImage(); 
        $model->user_id = $lastedId ? $lastedId->id +1 : 1;
        $model->fingerprint_images= $filename;
        $model->save();
      } 
      
      }

    public function store(Request $request)
    {    
       
        $model=new FingerPrintVarification();  
        $image=$request->file('nid_front');
        $ext=$image->extension();
        $image_name=time().'.'.$ext;
        $image->storeAs('/public/media/nid_front/',$image_name);
        $model->nid_front=$image_name;
        $image=$request->file('nid_back');
        $ext=$image->extension();
        $image_name=time().'.'.$ext;
        $image->storeAs('/public/media/nid_back/',$image_name);
        $model->nid_back=$image_name;
        $model->nid_nummber=$request->nid;	  
        $model->dob= $request->date;	
        $model->status= 0;   
        $model->fingerprint= 'null';
        $model->name= 'N/A'; 
        $model->father_name= 'N/A'; 
        $model->mother_name= 'N/A'; 
         if($model->save())
         {
          return response()->json(['message' =>'NID Data successfully Stored!', 'status'=>'success']);
         }else{
          return response()->json(['message' =>'Failed to store data', 'status'=>'fail']);
         }    
    }


    public function nidResponse(Request $request) 
     {
         $dob = $request->input('dob');
         $nid = $request->input('nid');
         $id = $request->input('id');
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://uat-ecnid-api.sslwireless.com/api/NID/GetDetails',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "dob": "'.$dob.'",
            "nid": "'.$nid.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'x-api-key: tnnP68rXayMZfkKbU6CjajPRi1HvNHg0aUKRtVLGQGyxwnq4lVRNTH5MtfY8QUsk'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $result=json_decode($response, true);
        
        if ($result['code'] == 200) {
          $data=FingerPrintVarification::where('id', $id)->first();
           if ($data) {
            Log::info($result['data']);
            $data->name = $result['data']['name_en'] ?? '';
            $data->father_name=$result['data']['father_name_en'] ?? '';
            $data->mother_name=$result['data']['mother_name_en'] ?? '';
            $data->status= 1;
            $data->save(); 
            return response()->json(['message' =>'NID Data successfully verified!', 'status'=>'success']);
           } 
        }
        // Log::info($result['data']);
        return response()->json(['message' =>'Unable to verify data !', 'status'=>'fail']);  
     }

    public function status(Request $request) {
      $status = $request->input('status');   
      $id = $request->input('id');   
      $model=FingerPrintVarification::find($id);
      $model->status=$status;
      $model->save();
    }  
  
    public function runExe() 
    {     
         
         $executablePath = base_path('Debug/ReadFingerprintDemo.exe');
         Log::info($executablePath);
         $output = exec($executablePath);       
         return response()->json(['output' => $output, 'status'=>'success']);
    }

   
    public function test(FingerPrintVarification $fingerPrintVarification)
    {
       dd("test");
    }

  
    public function edit(FingerPrintVarification $fingerPrintVarification)
    {
        //
    }


    public function update(Request $request, FingerPrintVarification $fingerPrintVarification)
    {
        //
    }


    public function destroy(FingerPrintVarification $fingerPrintVarification)
    {
        //
    }
}