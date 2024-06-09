@extends('layout.customer.master')
@section('lib-css')
@endsection
@push('custom-css')
    <style type="text/css">

    </style>
@endpush
@section('content')
    <div class="page-content services-detail-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  
                    <!-- POST SERVICES DERAIL 1-->
                    <section class="post-services post-services-detail-1 mb-4"> 
                        <form method="post" action="customer/form/submit" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!--begin::Card-->
                        <div class="card card-custom gutter-b example example-compact ">
                                <!--begin::Form-->
                                
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block text-center">Personal Information</h4>
                                                
                                             </div> 
                                        </div> 
                                        <div class="form-group row mb-3">
                                            <div class="col-lg-3 mb-3">
                                                <label>Full Name*</label>
                                                <input type="text" name="full_name" class="form-control" placeholder="Enter full name">
                                             
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Father's Name*</label>
                                                <input type="text" name="fathers_name" class="form-control" placeholder=" ">
                                             
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Mother's Name*</label>
                                                <input type="text" name="mothers_name" class="form-control" placeholder=" ">
                                             
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Spouse name (if applicable)</label>
                                                <input type="text" name="spouse_name" class="form-control" placeholder=" ">
                                             
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-lg-3 mb-3">
                                                <label>Mobile Number (Ex: 01*********)*</label>
                                                <input type="number" name="mobile_no" class="form-control" placeholder=" ">
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" name="email" placeholder=" ">
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Date of Birth*</label>
                                                <!-- <div class="input-group date">
                                                    <input type="date" name="dob" class="form-control" value="05/20/2017">
                                                </div> -->
                                                <input class="form-control" placeholder="" name="dob" type="date" id="payment_due_at" value="">
                                                <!-- <div class="input-group date">
                                                    <input type="text" name="dob" class="form-control" readonly="readonly" value="05/20/2017" id="kt_datepicker_3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div> -->
                                                
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>NID/Passport/Driving License*</label>
                                                <input type="number" name="nid_number" class="form-control" placeholder=" ">
                                             
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">       
                                                <div class="col-lg-3 mb-3">
                                                    <label>Account Type*</label>
                                                    <select class="form-control" name="account_type">
                                                        <option value="">Select</option>
                                                        <option value="01">SAVINGS</option>
                                                        <option value="02">Personal</option>
                                                        <option value="03">Dps</option> 
                                                    </select> 
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label>Preferred Branch *</label>
                                                    <select class="form-control" name="preferred_branch">
                                                        <option value="">Select</option>
                                                        <option value="01">Aminbazar</option>
                                                        <option value="02">Dhaka</option>
                                                        <option value="03">Chittagong</option> 
                                                    </select> 
                                                </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-lg-3 mb-3">
                                                <label>Personal Image*</label>
                                                <div class="">
                                                    <input type="file" name="personal_image" alt="personal_image" required>
                                                    
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>
                                            <div class="col-lg-9 mb-3">
                                                <label>Upload NID/Passport/Driving License/Birth Certificate*</label>
                                                <div class="">
                                                   <input type="file" name="customer_nid" alt="personal_image" required>
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-lg-3 mb-3">
                                                <label>Present Address*</label>
                                                <textarea class="form-control" name="present_address"></textarea>
                                                <!-- <input type="textarea" class="form-control" placeholder=" "> -->
                                             
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Permanent address*</label>
                                                <textarea class="form-control" name="permanent_address"></textarea>
                                                <!-- <input type="textarea" class="form-control" placeholder=" "> -->
                                             
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Mailing Address*</label>
                                                <textarea class="form-control" name="mailing_address"></textarea>
                                                <!-- <input type="textarea" class="form-control" placeholder=" "> -->
                                             
                                            </div>
                                        </div> 
                                    </div> 
                                
                                <!--end::Form-->
                        </div>
                            <!--end::Card-->
                 </section>
                <section class="post-services post-services-detail-1 mb-4"> 
                    <div class="card card-custom gutter-b example example-compact "> 

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h4 class="d-block text-center">Employment/Business Details</h4>
                                    
                                 </div> 
                            </div> 
                            <div class="form-group row">
                               
                                <div class="col-lg-4 mb-3">
                                    <label>Profession*</label>
                                    <select class="form-control" name="profession">
                                        <option value="">Select</option>
                                        <option value="01">Servicce</option>
                                        <option value="02">Business</option>
                                        <option value="03">Govt job</option> 
                                    </select> 
                                </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Name of the Organization*</label>
                                        <input type="text" name="organization" class="form-control" placeholder=" "> 
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Designation*</label>
                                        <input type="text" name="designation" class="form-control" placeholder=" ">
                                     
                                    </div>  
                                    <div class="col-lg-6 mb-3">
                                        <label>Organization Address*</label>
                                        <textarea class="form-control" name="org_address"></textarea>
                                        <!-- <input type="textarea" class="form-control" placeholder=" "> -->
                                    </div> 
                            </div>
                                     
                         </div>
                    </div>
                </section>
                <section class="post-services post-services-detail-1 mb-4"> 
                        <div class="card card-custom gutter-b example example-compact"> 
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <h4 class="d-block text-center">Other Bank information (if any)</h4>
                                        
                                     </div> 
                                </div> 
                                <div class="form-group row"> 
                                    <div class="col-lg-4 mb-3">
                                        <label>Account no.</label>
                                        <input type="number" class="form-control" placeholder=" " name="account_no"> 
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control" placeholder=" " name="bank_name">
                                     
                                    </div>  
                                    <div class="col-lg-4 mb-3">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" placeholder=" " name="branch_name">
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </section>
                   
                    <section class="post-services post-services-detail-1 mb-4"> 
                        <div class="card card-custom gutter-b example example-compact"> 
                            <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <h4 class="d-block text-center">Introducer's information</h4>
                                            
                                         </div> 
                                    </div> 
                                    <div class="form-group row"> 
                                        <div class="col-lg-6 mb-3">
                                            <label>Account no.</label>
                                            <input type="number" class="form-control" placeholder=" " name="introducer_account_no"> 
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label> Name</label>
                                            <input type="text" class="form-control" placeholder=" " name="introducer_name">
                                        </div>   
                                    </div> 
                                </div> 
                                 
                            <!--end::Form-->
                        </div>
                    </section> 
                    <section class="post-services post-services-detail-1 mb-4"> 
                        <div class="card card-custom gutter-b example example-compact"> 

                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <h4 class="d-block text-center">Nominee information</h4>
                                           
                                         </div> 
                                    </div> 
                                    <div class="form-group row">  
                                            <div class="col-lg-6 mb-3">
                                                <label>Name*</label>
                                                <input type="text" class="form-control" placeholder=" " name="nominee_1_name"> 
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label>NID/Passport/Driving License/Birth Certificate *</label>
                                                <input type="number" class="form-control" placeholder=" " name="nominee_1_nid_no"> 
                                            </div>  

                                            <div class="col-lg-6 mb-3">
                                                <label>Relations * </label>
                                                <input type="text" class="form-control" placeholder=" " name="nominee_1_relation"> 
                                            </div> 
                                            <div class="col-lg-6 mb-3">
                                                <label>Percentage * </label>
                                                <input type="text" class="form-control" placeholder=" " name="nominee_1_percentage"> 
                                            </div> 
                                            <div class="col-lg-6 mb-3">
                                                <label>

                                                    Upload Nominee Photograph *:</label>
                                                <div class="">
                                                    <input type="file" name="nominee_1_selfie">
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label> 
                                                    NID/Passport/Driving License/Birth Certificate* :</label>
                                                <div class="">
                                                   <input type="file" name="nominee_1_nid">
                                                </div>
                                                <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                                            </div>
                                    </div> 

                        </div>
                    </section> 
                    <section class="post-services post-services-detail-1 mb-4"> 
                        <div class="card card-custom gutter-b example example-compact"> 
                            <!--begin::Form-->
                            
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <h4 class="d-block text-center">Other Required Documents</h4>
                                           
                                         </div> 
                                    </div> 

                                    <div class="form-group row"> 
                                            <div class="col-lg-12 mb-3">
                                                <label> Upload Utility Bill :</label> <input type="file" name="utility_image"/> 
                                            </div>
                                            <div class="checkbox-list">
                                                <label class="checkbox">
                                                    <input type="checkbox" name="Checkboxes1" required>
                                                    <span>
                                                    I have read and accept the terms and conditions
                                                </span>
                                                </label> 
                                            </div> 
                                    </div>
                                    
                                
                                <div class="card-footer">
                                    <div class="row"> 
                                        <div class="col-lg-12 text-right"> 
                                           <a href="verified-view.html"> <button  type="" class="btn btn-primary mr-2">Submit</button></a>
                                            <button id="btn-error" type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            <!--end::Form-->
                        </div>

                    </form>
                    </section> 
                    <!-- END POST SERVICES DERAIL 1-->
                </div>
              
            </div>
        </div>
    </div>
@endsection
@section('lib-js')
@endsection
