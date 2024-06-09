@extends('layout.admin.master')
@section('lib-css')
@endsection
@push('custom-css')
<style type="text/css">
#message {
    color: red;

}
</style>
@endpush
@section('content')
<main class="c-main">
    <div class="container-fluid p-2">
        <div class="row">
            <div class="col-lg-12">
                <p id="message"></p>
                <div class="card">

                    <div class="card-header">
                        <div class="pull-left">
                            <h3 class="panel-title txt-dark">
                                {{-- Screening List - {{$screeningList->total()}} --}}
                            </h3>
                        </div>
                        <div class="pull-right">

                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#fingerprint">Fingerprint Enrollment </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Account Holder Name</th>
                                    <th>Father Name</th>
                                    <th>Mother Name</th>
                                    <th>Front NID</th>
                                    <th>Back NID</th>
                                    <th>NID Number</th>
                                    <th>DOB</th>
                                    <th>Finger Image</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count()>0)
                                @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>

                                    <td>{{ $item->name ?? '' }}</td>
                                    <td>{{ $item->father_name ?? '' }}</td>
                                    <td>{{ $item->mother_name ?? '' }}</td>

                                    <td>
                                        @if($item->nid_front!='')
                                        <img width="60px" height="60"
                                            src="{{asset('storage/media/nid_front/'.$item->nid_front)}}" />
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->nid_back!='')
                                        <img width="60px" height="60"
                                            src="{{asset('storage/media/nid_back/'.$item->nid_back)}}" />
                                        @endif
                                    </td>
                                    <td>{{ $item->nid_nummber ?? '' }}</td>
                                    <td>{{ $item->dob ?? '' }}</td>
                                      <td> 
                                        
                                        @if($item->images!='')
                                          @foreach ($item->images as $img)
                                          <img width="20px" height="20"
                                        src="{{asset('upload/finger_img/'.$img->fingerprint_images)}}" />
                                          @endforeach
                                        @endif

                                      </td>
                                    <td>
                                        @if ($item->status==1)
                                        <button id="verifyButton{{$item->id}}" type="button"
                                            class="btn btn-sm btn-primary ">Verified</button>
                                        @elseif ($item->status==0)
                                        <button id="verifyButton{{$item->id}}" type="button"
                                            class="btn btn-sm btn-danger "
                                            onclick="varifyNID('{{ $item->nid_nummber }}', '{{ $item->dob }}', '{{ $item->id }}')">Verify</button>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        <div class="text-right">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function varifyNID(nid, dob, id) {

    console.log('verifying' + id);

    document.getElementById('verifyButton' + id).disabled = true;

    document.getElementById('verifyButton' + id).innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';

    event.preventDefault();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var requestData = {
        dob: dob,
        nid: nid,
        id: id
    };
  
    $.ajax({
        type: 'post',
        url: 'https://dev-ekyc.sslwireless.com/nidResponse',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {

            if (response.status == 'fail') {

               
                document.getElementById('verifyButton' + id).innerHTML = 'Verify';

                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    title: response.message,
                    showConfirmButton: true,
                });
                return false;
            } else {
              
                document.getElementById('verifyButton' + id).innerHTML = 'Verified';

                Swal.fire({
                    icon: "success",
                    title: 'Success',
                    text: response.message,
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'finger-print-v';
                    }
                });
            }

        }
    })
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.js"
    integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@include('finger-print.create')
@include('finger-print.import')
@endsection
@section('lib-js')
@endsection