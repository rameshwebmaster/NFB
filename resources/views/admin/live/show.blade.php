@extends('layouts.admin')

@section('page-title')
    <div class="col-xs-12">
        <h4 class="page-title">
            Live Stream
        </h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <video autoplay id="camera" style="width: 100%; height: auto;" data-token="{{ csrf_token() }}">

            </video>
            <div class="row">
                <div class="col-xs-6">
                    <button type="button" class="btn btn-block btn-info start-stream">Start Stream</button>
                </div>
                <div class="col-xs-6">
                    <button type="button" class="btn btn-block btn-info end-stream">End Stream</button>
                </div>
            </div>
            <div class="row m-t-15">
                <div class="col-xs-12">
                    <div class="bg-white p-10" id="live-stream-status">No active live stream</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="white-box">
                <h3 class="box-title m-b-20">Questions</h3>
                <div class="chat-box">
                    <div class="slimScrollDiv" style="max-height: 150px;
    overflow-y: scroll;">
                        <ul class="chat-list slimscroll" >
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>
    <script src="/js/MediaStreamRecorder.js"></script>
    <script>


        $(function () {
            $('.slimScrollDiv').slimScroll({
                height: '500px'
            });
        });


        var video = document.querySelector('#camera');
        var startStream = document.querySelector('.start-stream');
        var endStream = document.querySelector('.end-stream');
        var chatList = document.querySelector('.chat-list');
        var status = document.getElementById('live-stream-status');
        var token = video.getAttribute('data-token');
        var streamId = 0;
        var firstInterval = true;
        var mediaRecorder;
        var interval = 0;
        var socket = io();

        socket.on('stream_question', function (message) {
            var output = '<div class="chat-body"><div class="chat-text">';
            output += '<p>' + message.user + '</p>';
            output += message.body;
            output += '</div></div>';
            var li = document.createElement('li');
            li.innerHTML = output;
            chatList.appendChild(li);
        });

        startStream.addEventListener('click', function () {
            $("#live-stream-status").html("<i class='fa fa-circle text-success'> Online</i>");
            console.log('clicked started');
            var data = new FormData();
            data.append('_token', token);
            $.ajax({
                type: 'POST',
                url: '/nfb-admin/live/start',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    streamId = data.id;
                    mediaRecorder.start(5000);
                    status.innerText = 'Live stream is being recorded';
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        function onDataAvailable(blob) {
            console.log('data available');
            if (firstInterval) {
                firstInterval = false;
                return;
            }

            getDataURI(blob, function (dataURI) {
                var data = {
                    stream: dataURI,
                    interval: interval
                };
                interval++;

                postStream(data);
            });
        }

        function getDataURI(blob, cb) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onload = function (event) {
                cb(event.target.result);
            };
        }

        function postStream(data) {
            socket.emit('stream', data);
        }

        endStream.addEventListener('click', function () {
            console.log('clicked ended');
            $("#live-stream-status").html("<i class='fa fa-circle text-error'> Offline</i>");
            if (streamId == 0) {
                console.log('something went wrong');
                return;
            }
            var data = new FormData();
            data.append('_token', token);
            $.ajax({
                type: 'POST',
                url: '/nfb-admin/live/' + streamId + '/end',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log('done');
                    mediaRecorder.stop();
                    status.innerText = 'Live stream is finished';
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        var constraints = {
            audio: true,
            video: IsEdge ? true : {
                    mandatory: {
                        maxWidth: 400,
                        maxHeight: 300,
                        minFrameRate: 9,
                        maxFrameRate: 11,
                        //minAspectRatio: 1.77
                    }
                }
        };

        captureUserMedia();
        function captureUserMedia() {
            navigator.mediaDevices.getUserMedia(constraints).then(webcamSuccess).catch(webcamFail);
        }

        function webcamSuccess(stream) {
            console.log('Webcam successfully acquired!');
            video = mergeProps(video, {
                controls: false,
                muted: true,
                src: URL.createObjectURL(stream)
            });
            video.width = 400;
            video.height = 300;
            video.play();
            mediaRecorder = new MultiStreamRecorder(stream);
            mediaRecorder.ondataavailable = function (blobs) {
                onDataAvailable(blobs.video);
            };
        }
        function webcamFail() {
            console.log('You did not grant permissions to use your webcam');
        }

    </script>
@endsection