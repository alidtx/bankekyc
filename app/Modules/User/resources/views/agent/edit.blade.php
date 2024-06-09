<div class="modal fade" id="edit_{{$agent->agent_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Edit Agent - {{$agent->name}}</h5>
            </div>

            <form method="post" action="{{route('agents.update',$agent->agent_id)}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Name : <span style="color:red">*</span></label>
                        <input type="text" name="name" value="{{$agent->name}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Mobile No : <span style="color:red">*</span></label>
                        <input type="text" name="mobile_no" value="{{$agent->mobile_no}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Email :</label>
                        <input type="email" name="email" value="{{$agent->email}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Branch : <span style="color:red">*</span></label>
                        <select class="form-control" name="branch" required>
                            <option value="{{$agent->branch}}">{{$agent->branchInfo->name}}</option>
                            <option value=""></option>
                            <?php
                            foreach ($branches as $branch) {
                                ?>
                                <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label mb-10">Address :</label>
                        <input type="text" name="address" class="form-control" value="{{$agent->address}}">
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