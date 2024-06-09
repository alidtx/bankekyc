<div class="modal fade" id="edit_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Edit User - {{$user->name}}</h5>
            </div>

            <form method="post" action="{{route('system-users.update',$user->id)}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
            <div class="modal-body">

                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Mobile No : <span style="color:red">*</span></label>
                    <input type="text" name="mobile_no" value="{{$user->mobile_no}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Email :</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Branch : </label>
                    <select name="branch" class="form-control" data-placeholder="Select Branch">
                        <option value="Dilkhusha" {{$user->branch == 'Dilkhusha' ? 'selected' : ''}}>Dilkhusha</option>
                        <option value="Gulshan" {{$user->branch == 'Gulshan' ? 'selected' : ''}}>Gulshan</option>
                        <option value="Dhanmondi" {{$user->branch == 'Dhanmondi' ? 'selected' : ''}}>Dhanmondi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label mb-10">Role : <span style="color:red">*</span></label>
                    <select name="role" class="form-control" data-placeholder="Select Role" required>
                        @foreach($roles as $role)
                        @php
                        $getUserRoles = $user->getRoleNames()->toArray();
                        if(in_array($role, $getUserRoles)){
                            $selectAttr = 'selected="selected"';
                        }
                        @endphp
                        <option value="{{$role}}" {{ $selectAttr ?? ''}}>{{$role}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

            </form>
        </div>
    </div>
</div>