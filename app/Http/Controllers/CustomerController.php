<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Modules\FormBuilder\Models\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Contracts\DataTable;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customer.form');
    }

    public function customerVerfied()
    {
        return view('customer.verified');
    }

    public function customerNotVerfied()
    {
        return view('customer.not_verified');
    }

    public function submitForm(Request $request)
    {     
        try {
            if ($file = $request->file('personal_image')) {
                $filename = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path('images/customer_images/'), $filename);
                $filepath1 = 'images/customer_images/' . $filename;
            }
            if ($file = $request->file('customer_nid')) {
                $filename1 = str_replace(' ', '', $file->getClientOriginalName());
                $file->move(public_path('images/customer_images/'), $filename1);
                $filepath2 = 'images/customer_images/' . $filename1;
            }

            $response = $this->guzzlePostGaze('https://kyc.gazetech.ml/v1/', 'compare_faces', $filepath1, $filepath2);
            $result = \GuzzleHttp\json_decode($response->getBody());
            Log::debug('get gaze response for compare faces: ' . print_r($result, true));

            if ($result->success == 1 && $result->matched == 1) {
                $callNidOcr = $this->guzzlePostGaze('https://kyc.gazetech.ml/v1/', 'BD/read_nid', $filepath2);
                $getOcr = \GuzzleHttp\json_decode($callNidOcr->getBody());
                Log::debug('get gaze response for nid ocr: ' . print_r($getOcr, true));

                $data['full_name'] = $getOcr->results[0]->name ?? '--';
                $data['dob'] = $getOcr->results[0]->dob ?? '--';
                $data['mobile_no'] = $request->mobile_no ?? '--';
                $data['customer_nid'] = $getOcr->results[0]->nid ?? '--';

                $data['fathers_name'] = $request->fathers_name ?? '--';
                $data['mothers_name'] = $request->mothers_name ?? '--';
                $data['account_type'] = $request->account_type ?? '--';

                // connectivity with porichoy

                // $user_full_name = $getOcr->results[0]->name ?? '';
                // $user_dob = $getOcr->results[0]->dob ?? '';
                // $user_nid = $getOcr->results[0]->nid ?? '';
                // if($user_full_name != '' && $user_dob != '' && $user_nid != ''){
                //     $callPorichoy = $this->guzzlePostPorichoy('https://porichoy.azurewebsites.net/api/kyc/', 'test-nid-person', ['person_fullname' => $user_full_name, 'person_dob' => $user_dob, 'national_id' => str_replace(" ","",$user_nid)]);
                //     $getNidConfirmation = \GuzzleHttp\json_decode($callPorichoy->getBody());
                //     Log::debug('get porichoy response: ' . print_r($getNidConfirmation, true));
                //     if($getNidConfirmation->passKyc == 'yes' && $getNidConfirmation->errorCode == null){
                //         Log::info('NID verified');
                //     }
                // }
                
                // porichoy connectivity ends

                $data['is_nominee_verified'] = 0;
                // verify nominee
                if ($request->file('nominee_1_selfie') && $request->file('nominee_1_nid')) {
                    $nominee_photo = $request->file('nominee_1_selfie');
                    $nominee_nid = $request->file('nominee_1_nid');

                    $nominee_face_match = $this->guzzlePostGaze('https://kyc.gazetech.ml/v1/', 'compare_faces', $nominee_photo, $nominee_nid);
                    $faceResult = \GuzzleHttp\json_decode($nominee_face_match->getBody());
                    Log::debug('get gaze response for nominee faces: ' . print_r($faceResult, true));
                    if ($faceResult->success == 1 && $faceResult->matched == 1) {
                        $data['is_nominee_verified'] = 1;
                        $callNomineeNidOcr = $this->guzzlePostGaze('https://kyc.gazetech.ml/v1/', 'BD/read_nid', $nominee_nid);
                        $getNomineeOcr = \GuzzleHttp\json_decode($callNomineeNidOcr->getBody());
                        Log::debug('get gaze response for nominee nid ocr: ' . print_r($getNomineeOcr, true));

                        $data['nominee_1_name'] = $getNomineeOcr->results[0]->name ?? '--';
                        $data['nominee_1_relation'] = $request->nominee_1_relation ?? '--';
                        $data['nominee_1_dob'] = $getNomineeOcr->results[0]->dob ?? '--';
                        $data['nominee_1_nid_no'] = $getNomineeOcr->results[0]->nid ?? '--';
                    }
                }
                
                return view('customer.verified', compact('data'));
            } else {
                return view('customer.not_verified');
            }
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return view('customer.not_verified');
        }
    }

    public function agentLoginForm()
    {
        return view('al-arafah.agent_login');
    }

    public function agentLoginSubmit(Request $request)
    {
        return redirect('kyc-form');
    }

    public function getApplications(Request $request)
    {
        try {
            $applicationType = ['Deposit', 'Loan Account', 'FDR'];
            if (preg_match('/approved/i', $request->url()) === 1)
                return
                    [
                        'data' => [
                            [
                                'Shahriar Monzoor',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/1' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Monirul Hasan',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/2' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Iftekhar Alam Ishaque',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/3' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Tahsin Ul Abrar',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for ' . $request->type,
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/4' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ], [
                                'Nazmul Hossain',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/5' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ]
                        ]
                    ];
            else if (preg_match('/decliend/i', $request->url()) === 1)
                return
                    [
                        'data' => [
                            [
                                'Md Rana Hossain',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/1' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Sharif Hossain',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/2' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Md Junayed Bin Rafiq',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/3' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'MD Sohel Anam Khan Shohel',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for ' . $request->type,
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/4' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ], [
                                'Mukta Mahbub',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/5' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ]
                        ]
                    ];
            else
                return
                    [
                        'data' => [
                            [
                                'Shahriar Shihab',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/1' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Jasim Jewel',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/2' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'SD Bappi',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/3' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ],
                            [
                                'Ferdous Rahman',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for ' . $request->type,
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/4' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ], [
                                'Suman Chndraw Das',
                                rand(1000000000, 9999999999),
                                date("Y-m-d", rand(1262055681, 987877878)),
                                '2020-05-17',
                                'Pending for checker',
                                rand(40, 100) . '%',
                                $applicationType[rand(0, 2)] . ' Account',
                                "<a href='/{$request->type}/{$request->application}/5' class='badge badge-info view_form'> <i class='fa fa-street-view'></i> View Application</a>"
                            ]
                        ]
                    ];
        } catch (\Exception $ex) {
            Log::error('[Class => ' . __CLASS__ . ", function => " . __FUNCTION__ . " ]" . " @ " . $ex->getFile() . " " . $ex->getLine() . " " . $ex->getMessage());
            return $this->exceptionResponse('Something went wrong!');
        }
    }
}
