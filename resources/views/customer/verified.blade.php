@extends('layout.customer.master')
@section('lib-css')
@endsection
@push('custom-css')
    <style type="text/css">

    </style>
@endpush
@section('content')

<div class="page-content services-detail-1  ">
        <div class="container">
            <div class="row">
                
                    <!-- POST SERVICES DERAIL 1-->
                <section class="post-services post-services-detail-1 col-md-7  m-auto">  
                    <div class="card card-custom gutter-b example example-compact ">
                        <div class="card-body">
                            <div class="row m-auto pb-4"   > 
                                <img src="/customer_theme/img/green-tick.png " width="55px" class="m-auto" >  
                            </div> 
                            <h4 class="text-center mb-4">Congratualtions! </h4> 
                                <p  class="text-center mb-2"> Your request has been successfully processed.</p>

                                <p class="text-center mb-4"> You will get another confirmation within next 72 hours</p>
                           
            
                                <div class="example example-basic mb-4">
                                    <div class="example-preview">
                                     
                                        <div class="row d-flex" > 
                                            <div class="col-lg-12 col-sm-12">
                                                <h4 class="font-weight-bold">Basic Info</h4> 
                                             </div> 
                                            <div class="col-lg-12 ">
                                                <div class="col-md-12 col-sm-12 p-0">
                                                    <div class="col-md-6 col-sm-12 p-0"><label>Full Name :</label>
                                                        <span>{{$data['full_name'] ?? '' }} </span> 
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 p-0"> 
                                                        <label>NID:</label>
                                                        <span>{{$data['customer_nid'] ?? '' }} </span>  
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 p-0">
                                                    <div class="col-md-6 col-sm-12 p-0">
                                                        <label>Date of Birth :</label>
                                                        <span>{{$data['dob'] ?? '' }} </span> 
                                                    </div>
                                                          
                                                </div>
                                            </div>   
                                        </div>   
                                            
                                    </div> 
                                       
                                    </div>
                                    <div class="example example-basic mb-4">
                                        <div class="example-preview">
                                            <div class="row d-flex" > 
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h4 class="font-weight-bold">Personal Info:</h4> 
                                                 </div> 
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="col-md-12 col-sm-12 p-0">
                                                        <div class="col-md-6 p-0"><label>Father's Name :</label>
                                                            <span>{{$data['fathers_name'] ?? '' }}</span> 
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 p-0"> 
                                                            <label>Mother's Name :</label>
                                                            <span>{{$data['mothers_name'] ?? '' }}</span>  
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 p-0">
                                                        <div class="col-md-6 col-sm-12 p-0"><label>Mobile :</label>
                                                            <span>{{$data['mobile_no'] ?? '' }}</span> 
                                                        </div>
                                                        <div class="col-md-6 p-0"> 
                                                            <label>Account Type  :</label>
                                                            <span>{{$data['account_type'] ?? '' }}</span>  
                                                        </div>
                                                    </div> 
                                                </div>   
                                            </div>   
                                                
                                        </div> 
                                           
                                        </div>
                                        <div class="example example-basic mb-4">
                                            <div class="example-preview">
                                                <div class="row d-flex" > 
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <h4 class="font-weight-bold">Nominee Info</h4> 
                                                     </div> 
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        @if($data['is_nominee_verified'] == 1)
                                                        <div class="col-md-12 col-sm-12 p-0">
                                                            <div class="col-md-6 p-0"><label>Nominee Name :</label>
                                                                <span>{{$data['nominee_1_name'] ?? '' }}</span> 
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 p-0"> 
                                                                <label>Nominee Relation :</label>
                                                                <span>{{$data['nominee_1_relation'] ?? '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 p-0">
                                                            <div class="col-md-6 p-0">
                                                                <label>Nominee NID :</label>
                                                                <span>{{$data['nominee_1_nid_no'] ?? '' }}</span>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 p-0"> 
                                                                <label>Nominee Date of Birth :</label>
                                                                <span>{{$data['nominee_1_dob'] ?? '' }}</span>
                                                            </div> 
                                                        </div>
                                                        @else
                                                        <p style="color: red;">** Nominee information is not verified</p>
                                                        @endif
                                                    </div>   
                                                </div>   
                                                    
                                            </div> 
                                               
                                        </div>
                             
                        </div>      
                    </div>
                </section> 
            </div>
        </div>
    </div>


@endsection
@section('lib-js')
@endsection