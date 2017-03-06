<form enctype="multipart/form-data" method="post" id="external-upload-form" class="upload-form"
      action="{{ route('media.external') }}">
    {{ csrf_field() }}
    <input type="hidden" name="media_type" value="external-youtube">
    <div class="form-group">
        <label for="youtube-link">Enter valid youtube link</label>
        <input type="text" name="link" id="youtube-link" class="form-control"
               placeholder="https://www.youtube.com/watch?v=PCwL3-hkKrg">
    </div>
    @include('admin.media._poster_field')
    <button type="submit" class="btn btn-primary btn-md">Upload</button>
</form>