@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Create a CV 
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

    <form action="{{ route('createCV') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        @include('admin.cvs._form')


    </form>

@endsection

@section('scripts')
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        $(function () {
            tinymce.init({
                selector: '#body,#arabic_body',
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace code fullscreen',
                    'media contextmenu paste code directionality'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | ltr rtl',
                content_css: '//www.tinymce.com/css/codepen.min.css'
            });

            var select_thumb = $('#select-thumb');

            var dialogTrigger = $('#attachment-dialog-trigger');
            var attachmentModal = $('#thumb-modal');
            var selected = 0;
            var src = '';
            var format = 'standard';
            dialogTrigger.click(function () {
                var type = (format == 'standard' ? 'thumbnail' : format);
                attachmentModal.find('.modal-title').text(('choose ' + type).toUpperCase());
                attachmentModal.modal();
                var link = '/nfb-admin/media/' + type;
                $.ajax({
                    type: 'get',
                    url: link,
                    success: function (data) {
                        console.log(data);
                        var info;
                        var result = '';
                        var medium = data.data;
                        for (var mediaKey in medium) {
                            var media = medium[mediaKey];
                            info = '<div class="col-sm-2 col-xs-4">';
                            info += '<div class="image-holder m-t-5 m-b-5" data-attachment="' + media.id + '" style="cursor: pointer;">';
                            info += '<img src="/uploads/' + media.square_small.path + '" alt="thumb" class="img img-responsive">';
                            info += '<div class="chosen btn-success" style="position: absolute; top: 5px; left: 15px; padding: 1px 3px;">';
                            info += '<i class="ti-check"></i>';
                            info += '</div></div></div>';
                            result += info;
                        }
                        $('.modal-media').html(result);

                        var image_holder = $('.image-holder');

                        image_holder.click(function (e) {
                            console.log('sdsfg');
                            selected = $(this).data('attachment');
                            image_holder.removeClass('selected');
                            $(this).addClass('selected');
                            src = $(this).children('img').attr('src');
                        });

                    },
                    error: function (data) {
                        console.log('There was an error!');
                    }
                });
            });

            select_thumb.click(function (e) {
                if (selected == 0) {
                    return;
                }
                $('#attachment').val(selected);
                $('#thumb-modal').modal('hide');
                $('.thumb-image').attr('src', src);
            });

            var standardFormat = $('.standard-format'),
                    videoFormat = $('.video-format');
            $('.format-btn-group button').click(function (event) {
                function changeAttachmentBox() {
                    var type = (format == 'standard' ? 'thumbnail' : format);
                    $('.attachment-box h4').text(type);
                    $('.attachment-box p.attachment-desc').text('Choose ' + type);
                }

                var btn = $(this);
                btn.removeClass('btn-outline');
                format = btn.data('format');
                changeAttachmentBox();
                if (btn.hasClass('standard-format')) {
                    videoFormat.addClass('btn-outline');
                } else if (btn.hasClass('video-format')) {
                    standardFormat.addClass('btn-outline');
                }
                $('.format-input').val(format);
                var type = (format == 'standard' ? 'thumbnail' : format);
                $('#attachment_type').val(type);
            });


        });
    </script>
@endsection