<div class="row">
    <div class="col-md-7 col-md-offset-1 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">CV Guide Information</h3>
            <p class="text-muted m-b-30 font-13">Enter CV Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="control-label" for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="name"
                               value="{{ $guide->name or '' }}">
                        @if($errors->has('name'))
                            <div class="help-block with-errors">
                                <div class="help-block with-errors">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="form-group">
                    <label class="control-label" for="description">Description</label>
                    <textarea name="description" id="body" placeholder="Enter the post body"
                              class="form-control">{{ isset($guide) ? $guide->description : old('description') }}</textarea>
                    </div>

                   <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}" >
                    <label class="control-label" >Profile picture</label>
                       
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select File</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="avatar" accept="image/*">
                                        </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                   data-dismiss="fileinput">Remove</a>
                                 
                        </div>
                        @if($errors->has('avatar'))
                                <div class="help-block with-errors">
                                <div class="help-block with-errors">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </div>
                                </div>
                                @endif  
                    </div>

                    <div class="form-group">
                        <label class="control-label">Role <span class="text-danger">*</span></label>
                        <select class="form-control" name="role">
                           
                            @foreach(\App\CV::$roles as $roleSlug )
                                <option value="{{ $roleSlug }}" {{ isset($guide) ? ($guide->role == $roleSlug ? 'selected' : '') : '' }}>{{ $roleSlug }}</option>
                            @endforeach
                        </select>
                    </div>

                   <!--  <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="control-label" for="description">Description</label>
                        <textarea name="description" id="description"
                                  rows="10" class="form-control">{{ $guide->description or '' }}</textarea>
                        @if($errors->has('description'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('description') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('arabic_description') ? 'has-error' : '' }}">
                        <label class="control-label" for="arabic_description">Arabic Description</label>
                        <textarea name="arabic_description" id="arabic_description"
                                  rows="10"
                                  class="form-control">{{ isset($guide) ? $guide->arabic_description : old('arabic_description') }}</textarea>
                        @if($errors->has('arabic_description'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_description') }}</strong>
                            </div>
                        @endif
                    </div> -->

                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>