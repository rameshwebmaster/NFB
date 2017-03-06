<form enctype="multipart/form-data" method="post" id="thumbnail-upload-form" class="upload-form"
      action="{{ route('media.thumbnail') }}">
    {{ csrf_field() }}
    <input type="hidden" name="media_type" value="thumbnail">
    <div class="form-group">
        <label for="image">Choose image:</label>
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput">
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image[]" id="image" accept="image/*" multiple>
                                        </span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists"
               data-dismiss="fileinput">Remove</a>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-md">Upload</button>
</form>