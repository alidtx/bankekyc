<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Change Password</h5>
            </div>
            <form method="post" action="route('change-password')">
            {{ csrf_field() }}
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Current Password : <span style="color:red">*</span></label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">New Password : <span style="color:red">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Confirm Password : <span style="color:red">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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