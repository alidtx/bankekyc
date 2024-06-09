<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Create New Item </h5>
            </div>
            <form method="post" action="{{route('add-sanction-screening')}}">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Desgination : <span style="color:red">*</span></label>
                    <input type="text" name="designation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Country : <span style="color:red">*</span></label>
                    <input type="text" name="country" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Nationality : <span style="color:red">*</span></label>
                    <input type="text" name="nationality" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">DOB : <span style="color:red">*</span></label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Document Type : <span style="color:red">*</span></label>
                    <select class="form-control" name="type_of_document">
                        <option value="Passport">Passport</option>
                        <option value="National Identification Number">National Identification Number</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Document Number : <span style="color:red">*</span></label>
                    <input type="text" name="document_number" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            </form>
        </div>
    </div>
</div>