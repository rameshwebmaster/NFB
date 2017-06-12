<div class="row">
    <div class="col-md-7 col-md-offset-1 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Nutrition Guide Information</h3>
            <p class="text-muted m-b-30 font-13">Enter Guide Information</p>
            <div class="row">
                <div class="col-xs-12">
                    <!-- <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label" for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title"
                               value="{{ $guide->title or '' }}">
                        @if($errors->has('title'))
                            <div class="help-block with-errors">
                                <div class="help-block with-errors">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </div>
                            </div>
                        @endif

                    </div> -->

                    <div class="form-group">
                    <label class="control-label" for="description">Description</label>
                    <textarea name="description" id="body" placeholder="Enter the post body"
                              class="form-control">{{ isset($guide) ? $guide->description : old('description') }}</textarea>
                    </div>

                  <!--   <div class="form-group {{ $errors->has('arabic_title') ? 'has-error' : '' }}">
                        <label class="control-label" for="arabic_title">Arabic Title</label>
                        <input type="text" name="arabic_title" class="form-control input-rtl" placeholder="Arabic Title"
                               value="{{ isset($guide) ? $guide->arabic_title : old('arabic_title') }}">
                        @if($errors->has('arabic_title'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_title') }}</strong>
                            </div>
                        @endif
                    </div> -->
                    
                     <div class="form-group">
                    <label class="control-label" for="arabic_description">Arabic Description</label>
                    <textarea name="arabic_description" id="arabic_body" placeholder="Enter the post body"
                              class="form-control">{{ isset($guide) ? $guide->arabic_description : old('arabic_description') }}</textarea>
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