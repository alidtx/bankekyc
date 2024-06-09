@extends('layout.admin.master')
@section('lib-css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection
@push('custom-css')
    <style type="text/css">
        .card.card-custom > .card-body {
            padding: 2.5rem 2.25rem !important;
        }

        .btn-custom {
            background-color: #11a5134a;
            color: green;
        }

        .form-group label {
            font-weight: 600 !important;
        }

        .post-services .post-services-detail-1 {
            margin-bottom: 30px !important;
        }
    </style>
@endpush
@section('content')
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row" id="approved-application">
                    <div class="col-lg-12 text-right mb-5">
                        <button @click="cib_verify=true" type="" class="btn btn-primary mr-2">Verify CIB</button>
                        <img v-if="cib_verify" src="/img/green-tick.png" width="30px">

                    </div>
                    <div class="col-lg-12">

                        <!-- POST SERVICES DERAIL 1-->
                        <section class="post-services post-services-detail-1 mb-4">

                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact ">
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block  ">Personal Information</h4>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <div class="col-lg-3 mb-3">
                                                    <label>Full Name</label>
                                                    <p>Tahsin Ul Abrar</p>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label>Father's Name* </label>
                                                    <p>Shirajul Islam</p>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label>Mother's Name*:</label>
                                                    <p>Nazneen Akter</p>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label>Spouse name  </label>
                                                    <p>--</p>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mb-3">
                                                <label>Mobile Number * </label>
                                                <p>+880 17581166</p>
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Email Address</label>
                                                <p>abrar@gmail.com</p>
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Date of Birth*</label>
                                                <p>10-11-1990</p>
                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>NID/Passport/Driving License*</label>
                                                <p>1993017581166</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <div class="col-lg-3 mb-3">
                                                    <label>Account Type*</label>
                                                    <p>Personal</p>
                                                </div>
                                                <div class="col-lg-9 mb-3">
                                                    <label>Preferred Branch *</label>
                                                    <p>Dhanmondi</p>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 mb-3">
                                                <label>Present Address*</label>
                                                <p>82/4 East Tejturi Bazar </p>
                                                <!-- <input type="textarea" class="form-control" placeholder=" "> -->

                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Permanent address*</label>
                                                <p>82/4 East Tejturi Bazar, Tejgaon </p>

                                            </div>
                                            <div class="col-lg-3 mb-3">
                                                <label>Mailing Address**</label>
                                                <p>82/4 East Tejturi Bazar, Tejgaon </p>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3">
                                                <label>Personal Image:</label>
                                                <p><img class="img-fluid" src="/img/user.png" width="120px"></p>
                                            </div>
                                            <div class="col-lg-9">
                                                <label>NID :</label>
                                                <p><img class="img-fluid" src="/img/nid.png">
                                                </p>
                                            </div>
                                        </div>

                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </section>
                        <section class="post-services post-services-detail-1 mb-4">
                            <div class="card card-custom gutter-b example example-compact ">
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block ">Employment/Business Details</h4>

                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-lg-4 mb-3">
                                                <label>Profession*</label>
                                                <p>Service Holder</p>

                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <label>Name of the Organization*</label>
                                                <p>SSL Wireless</p>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <label>Designation*</label>
                                                <p>Sr. Software SPecialist</p>

                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label>Organization Address*</label>
                                                <p>Eskaton Garden</p>

                                            </div>
                                        </div>


                                </form>
                                <!--end::Form-->
                            </div>
                        </section>
                        <section class="post-services post-services-detail-1 mb-4">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block">Other Bank information </h4>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4 mb-3">
                                                <label>Account no.</label>
                                                <p>1234456</p>
                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <label>Bank Name</label>
                                                <p>Al-Arafah</p>

                                            </div>
                                            <div class="col-lg-4 mb-3">
                                                <label>Branch Name</label>
                                                <p>Dhanmondi</p>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                        </section>

                        <section class="post-services post-services-detail-1 mb-4">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block text-center">Introducer's information</h4>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6 mb-3">
                                                <label>Account no.</label>
                                                <p>12345678</p>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label> Name</label>
                                                <p>Nushan Ashfaq</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                        </section>
                        <section class="post-services post-services-detail-1 mb-4">
                            <div class="card card-custom gutter-b example example-compact">
                                <!--begin::Form-->
                                <form class="form">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <h4 class="d-block">Nominee information</h4>

                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-lg-6 mb-3">
                                                <label>Name*</label>
                                                <p>Iftekhar Alam</p>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>NID *</label>
                                                <p>4973397342</p>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Relations * </label>
                                                <p>Brother</p>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>Percentage * </label>
                                                <p>80%</p>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label>
                                                    Nominee Photograph *:</label>
                                                <p><img class="img-fluid" src="/img/user.png" width="120px"></p>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label>
                                                    NID/Passport/Driving License/Birth Certificate* :</label>
                                                <p><img class="img-fluid" src="/img/nominee_nid.jpg" width="350px"></p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
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
                                            <label>

                                                Utility Bill :</label>

                                            <p><img class="img-fluid" src="/img/utility.jpg" width="350px"></p>


                                        </div>
                                        <div class="checkbox-list">
                                            <label class="checkbox">
                                                <input type="checkbox" name="Checkboxes1">
                                                <span></span>
                                                I have read and accept the terms and conditions
                                            </label>

                                        </div>

                                    </div>


                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button id="btn-success" type=""
                                                        class="btn btn-primary mr-2">Approve
                                                </button>
                                                <button id="btn-error" type="reset"
                                                        class="btn btn-secondary">Decline
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>
                        </section>
                        <!-- END POST SERVICES DERAIL 1-->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('lib-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
@endsection

@push('custom-js')
    <script>
        const form_builder = new Vue({
            el: "#approved-application",
            data: {
                cib_verify: false,
                dataTableData: [],
                dataTable: {},
                selectedIndex: undefined,
            },
            methods: {},
            mounted() {
                $(document).ready(function () {

                    $("#btn-error").click(function (e) {
                        Swal.fire({
                            title: 'Declined',
                            html: 'Form submission <strong style="color:red;" id="#decline">Declined</strong>!',
                            icon: 'error',
                        }).then((result) => {
                            if (window.location.href.indexOf('checker') !== -1)
                                window.location.href = "../checker/declined-application";
                            else
                                window.location.href = "../approver/declined-application";
                        })
                    });
                    $("#btn-success").click(function (e) {
                        Swal.fire({
                            title: 'Approved',
                            html: 'Your Form has been submitted <strong style="color:green;"  id="#approve">Successfully </strong> !',
                            icon: 'success',
                        }).then((result) => {
                            if (window.location.href.indexOf('checker') !== -1)
                                window.location.href = "../checker/declined-application";
                            else
                                window.location.href = "../approver/declined-application";
                        })
                    });
                });
            },
        });
    </script>
@endpush
