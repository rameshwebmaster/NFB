<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Program Section Information</h3>
            <p class="text-muted m-b-30 font-13">Enter program section information</p>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label" for="title">Section Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title" value="{{ $program->title or '' }}">
                        @if($errors->has('title'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('arabic_title') ? 'has-error' : '' }}">
                        <label class="control-label" for="arabic_title">Section Title (Arabic)</label>
                        <input type="text" name="arabic_title" class="form-control" placeholder="Arabic Title" value="{{ $translations->translation_value or '' }}" style="direction: rtl;">
                        @if($errors->has('arabic_title'))
                            <div class="help-block with-errors">
                                <strong>{{ $errors->first('arabic_title') }}</strong>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success btn-block">{{ $isEdit ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>