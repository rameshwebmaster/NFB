<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Program Type Information</h3>
            <p class="text-muted m-b-30 font-13">Enter Program Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="control-label" for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="name" value="{{ $program->name or '' }}">
                        @if($errors->has('name'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="control-label" for="description">Description</label>
                        <input name="description" class="form-control" placeholder="description" value = "{{ $program->description or '' }}" 
                        >    
                        @if($errors->has('description'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('description') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label class="control-label" for="status">Status </label>
                        <select name="status" class="form-control">
                            <option {{ (isset($program) && $program->status == 'Active') ? 'selected' : '' }} value="Active">Active</option>
                            <option {{ (isset($program) && $program->status == 'Inactive') ? 'selected' : '' }} value="Inactive">Inactive</option>
                        </select>
                        @if($errors->has('status'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('status') }}</strong>
                            </div>
                        @endif
                    </div>
                     
                    <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>