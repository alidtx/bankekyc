<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Create New User</h5>
            </div>
            <form method="post" action="{{route('system-users.store')}}">
                {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Mobile No : <span style="color:red">*</span></label>
                    <input type="text" name="mobile_no" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Email :</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Branch : </label>
                    <select name="branch" class="form-control" data-placeholder="Select Branch">
                        <option value="Dilkhusha">Dilkhusha</option>
                        <option value="Gulshan">Gulshan</option>
                        <option value="Dhanmondi">Dhanmondi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Role : <span style="color:red">*</span></label>
                    <select name="role" class="form-control" data-placeholder="Select Role" required>
                        @foreach($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Password : <span style="color:red">*</span></label>
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