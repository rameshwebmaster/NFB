<form enctype="multipart/form-data" method="post" id="video-upload-form" class="upload-form"
      action="{{ route('media.video') }}">
    {{ csrf_field() }}
    <input type="hidden" name="media_type" value="video">

    <div class="form-group">
        <label for="poster">Choose video:</label>
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput">
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select Video</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="video" id="video" accept="video/*">
                                        </span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists"
               data-dismiss="fileinput">Remove</a>
        </div>
    </div>

    @include('admin.media._poster_field')

    <button type="submit" class="btn btn-primary btn-md">Upload</button>
</form>