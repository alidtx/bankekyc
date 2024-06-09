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
                <section class="post-services post-services-detail-1 col-md-6  m-auto">   
                    <div class="card card-custom gutter-b example example-compact ">
                        <div class="card-body "> 
                            <div class="row m-auto pb-4"   > 
                                <img src="/customer_theme/img/cross.png " width="55px" class="m-auto" >  
                        </div>   
                            <h4 class="text-center mb-4">Sorry! Verfication Failed.</h4>
                            <p class="text-center mb-4">Invalid data or Communication failed with NID server</p>
                        </div>
                    </div>
                </section> 
                
              
            </div>
        </div>
    </div>

@endsection
@section('lib-js')
@endsection