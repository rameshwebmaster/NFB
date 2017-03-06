@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Upload Media
        </h4>
    </div>
@endsection

@section('content')

    <div class="alert alert-dismissible upload-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <div class="sttabs tabs-style-bar">
                    <nav>
                        <ul>
                            <li class="tab-current"><a href="#thumbnail-upload-form" class="sticon ti-image"><span>Thumbnail</span></a>
                            </li>
                            <li><a href="#video-upload-form" class="sticon ti-video-clapper"><span>Video</span></a></li>
                            <li><a href="#youtube-link-form" class="sticon ti-youtube"><span>Youtube</span></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="thumbnail-upload-form" class="content-current">
                            @include('admin.media._thumbnail')
                        </section>
                        <section id="video-upload-form">
                            @include('admin.media._upload_video')
                        </section>
                        <section id="youtube-link-form">
                            @include('admin.media._external_video')
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row upload-progress">
        <div class="col-xs-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Upload Progress</h3>
                <p class="text-muted m-b-25">Details of upload progress</p>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .upload-alert, .upload-progress {
            display: none;
        }
    </style>
@endsection


@section('scripts')
    <script src="/js/stylishTabs.js"></script>
    <script>
        $(document).ready(function () {
            new CBPFWTabs(document.querySelector('.sttabs'));
            var mycurrent = $('.progress-bar');
            var uploadProgress = $('.upload-progress');
            var uploadAlert = $('.upload-alert');
            $('.upload-form').submit(function (e) {
                e.preventDefault();
                uploadProgress.css({'display': 'block'});
                var formdata = new FormData(this);
                var url = this.getAttribute('action');
                console.log('submitted to : ' + url);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formdata,
                    xhr: function () {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            myXhr.upload.addEventListener('progress', progress, false);
                        }
                        return myXhr;
                    },
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (data) {
                        //console.log(data);
                        var errors = '';
                        for (var message in data) {
                            if (message != 'success') {
                                errors += '<p>' + data[message][0] + '</p>';
                            }
                        }
                        if (errors != '') {
                            uploadAlert
                                .addClass('alert-danger')
                                .append(errors)
                                .show();
                        } else if (data.success) {
                            uploadAlert
                                .addClass('alert-success')
                                .append('<strong>Success!</strong> ' + data.success)
                                .show();
                        }
                    },

                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            function progress(e) {
                if (e.lengthComputable) {
                    var max = e.total;
                    var current = e.loaded;
                    var Percentage = (current * 100) / max;
                    console.log(Percentage);
                    mycurrent.css({'width': Percentage + '%'});
                }
            }
        });
    </script>
@endsection