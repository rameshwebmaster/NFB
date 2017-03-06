@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Translate Post
        </h4>
    </div>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('translatePost', ['postType' => $postType, 'post' => $post->id]) }}" method="post">

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Translate Post</h3>
                    <p class="text-muted m-b-30 font-13">Enter translation Information</p>
                    <div class="row">
                        <div class="col-xs-12">
                            {{--Title Field--}}
                            <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                                <label for="post_title" class="control-label">Title</label>
                                <input type="text" name="post_title" class="form-control" placeholder="title"
                                       value="{{ $translationValues['post_title']->translation_value or '' }}">
                                @if($errors->has('post_title'))
                                    <div class="help-block with-errors">
                                        <strong>{{ $errors->first('post_title') }}</strong>
                                    </div>
                                @endif
                            </div>
                            {{--End of Title Field--}}


                            {{--Body Field--}}
                            <div class="form-group">
                                <label for="post_body">Body</label>
                                <textarea name="post_body" id="post_body" placeholder="Enter the post body"
                                          class="form-control">{{ $translationValues['post_body']->translation_value or '' }}</textarea>
                            </div>
                            {{--End of Body Field--}}


                            {{--Excerpt Field--}}
                            <div class="form-group">
                                <label for="post_excerpt">Excerpt</label>
                                <textarea name="post_excerpt" placeholder="Enter the post excerpt"
                                          class="form-control">{{ $translationValues['post_excerpt']->translation_value or '' }}</textarea>
                            </div>
                            {{--End of Excerpt Field--}}

                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection


@section('scripts')
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        $(function () {
            tinymce.init({
                selector: '#post_body',
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace code fullscreen',
                    'media contextmenu paste code directionality'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | ltr rtl',
                content_css: '//www.tinymce.com/css/codepen.min.css'
            });
        });
    </script>

@endsection