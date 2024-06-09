<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<style>
.step {
    display: none;
}

.step.active {
    display: block;
}

.fingerprintdiv {}

.container {
    width: 80%;
    max-width: 600px;
    padding: 20px;

}

.headline {
    background: #321fdb;
    padding: 10px;
    color: white;
    text-align: center;
}

.nid {
    width: 100%;
    border: none;
    border-bottom: 1px solid gray;
}

#date {
    width: 100%;
    border: none;
    border-bottom: 1px solid gray;
}

input:focus {
    outline: none;
}

.btnclass {
    text-align: center;

}

.btnclass button {
    background: #321fdb;
    border-radius: 10px 10px 10px 10px;
    border: none;
    padding: 6px 32px;
    color: white;
}

.content-box {
    text-align: center;
}

.content-box h3 {

    box-shadow: -1px 9px 13px 0px rgba(0, 0, 0, 0.75);
    font-size: 22px;
    padding: 8px 0px;
}

.img-section {
    display: flex;
}

.img-section input[type="file"] {
    flex: 1;
    margin-right: 10px;
}

.requiredID {
    color: red;
    display: inline-block;
    padding: 0;
    margin: 0;
}

#dob_validation {
    color: red;
}

#num_validation {
    color: red;
}

.text-box {
    text-align: center;
    color: blue;
}

#message {
    text-align: center;
     color: red;
}
 .preview{
    display: flex;
    justify-content: space-between;
    margin-top:10px ;
    height: 15px;

 }
 .preview-img img {
    max-width: 100%;
    max-height: 100%;
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet"
    href="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<div class="modal fade" id="fingerprint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Fingerprint Enrollment</h5>
            </div>

            {{-- start Body --}}
            <div class="container">
                <div class="fingerprintdiv">
                      <p id="message"></p>
                    <h3 class="headline">Fingerprint Verification <i class="fa-solid fa-circle-check"></i></h3>

                    <br>

                    <form id="formData" enctype="multipart/form-data">  
                         
                        <div class="img-section">
                             NID Front:&nbsp; <input type="File" name="nid_front" id="nid_front">
                            NID Back: &nbsp;<input type="File" name="nid_back" id="nid_back">
                        </div>
                         
                         <div class="preview">  
                               <div style="height: 100px; width:60px" id="img1" class="preview-img"></div>
                               <div style="height: 100px; width:60px" id="img2" class="preview-img"></div>
                         </div>

                        <br><br>
                        <span class="requiredID">*</span>
                        <input class="nid" type="text" id="nid_number" name="nid" placeholder="NID Number" >
                        <span id="num_validation"></span>
                        <br><br>
                        <span class="requiredID">*</span>
                        <br>
                        <input type="date" id="dob" name="date" >
                        <span id="dob_validation"></span>
                        <br><br>
                        <div class="content-box">
                            <img src="{{asset('assets/img/avatars/fingerprint.png')}}" alt="alt">
                            <br> <br>
                            <h3>Enroll Fingerprint</h3>
                            <br>
                        </div>
                        <div class="btnclass">
                            <button id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- End Body --}}

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

function validation() {
    var nid_number = document.getElementById('nid_number').value;
    var dob = document.getElementById('dob').value;

    if (nid_number.trim() === '') {
        number_validation = document.getElementById('num_validation');
        number_validation.innerText = 'Please enter nid number!!';
        return false;
    }

    if (!/^\d+$/.test(nid_number)) {
        number_validation = document.getElementById('num_validation');
        number_validation.innerText = 'NID number must contain only numeric values!!';
        return false;
    }

    if (nid_number.length < 10) {
        number_validation = document.getElementById('num_validation');
        number_validation.innerText = 'NID number must be more than 10 digits!!';
        return false;
    }

    if (dob.trim() === '') {
        dob_validation = document.getElementById('dob_validation');
        dob_validation.innerText = 'Please enter date of birth!!';
        return false;
    }
    return true;
}


document.getElementById('formData').addEventListener('submit', function(event) {
  event.preventDefault();
  if(validation()){
   var formData=document.getElementById('formData')  
   var ExtratedFrmData = new FormData(formData)
   const nidFront = document.getElementById('nid_front').files[0]; 
   const nidBack = document.getElementById('nid_back').files[0];
   ExtratedFrmData.append('nid_front', nidFront)
   ExtratedFrmData.append('nid_back', nidBack);
   sendDataToController(ExtratedFrmData);

 }
});

function sendDataToController(getFrmData) { 
     document.getElementById('submit').disabled = true;
      document.getElementById('submit').innerHTML =
    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';
    $.ajax({
        type: 'POST',
        url: "{{ route('finger-print-v-store')}}",
        data: getFrmData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {     
          console.log(response);
            if (response.status=='fail') {
                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    title: response.message,
                    showConfirmButton: true,
                });
                return false;
            }else{
                Swal.fire({
                    icon: "success",
                    title: 'Success',
                    text: response.message,
                    showConfirmButton: true,
                })
                window.location.href = 'finger-print-v';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


document.getElementById('nid_front').addEventListener('change', function() {
 const nidFront = document.getElementById('nid_front').files[0];  
 var img1= document.getElementById('img1');
 const imgElement = document.createElement('img');
    imgElement.src = URL.createObjectURL(nidFront);
    img1.innerHTML = ''; 
    img1.appendChild(imgElement)
});

document.getElementById('nid_back').addEventListener('change', function() {
const nidBack = document.getElementById('nid_back').files[0]; 
 var img2= document.getElementById('img2');
 const imgElement = document.createElement('img');
    imgElement.src = URL.createObjectURL(nidBack);
    img2.innerHTML = ''; 
    img2.appendChild(imgElement)
});

showStep(currentStep);

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.js"
    integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>