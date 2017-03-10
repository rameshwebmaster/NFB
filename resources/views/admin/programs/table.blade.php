@extends('layouts.admin')

@section('page-title')
    <div class="col-sm-12">
        <h4 class="page-title">
            Program Table
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

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-4">
                        <form action="">
                            <select name="w" id="week">
                                <option value="1">Week 1</option>
                                <option value="2">Week 2</option>
                            </select>
                            <button type="submit" class="btn-primary btn">Go</button>
                        </form>
                    </div>
                    <div class="col-sm-2 col-sm-offset-6">
                        {{--<button type="button" class="btn btn-primary btn-block" data-toggle="modal"--}}
                        {{--data-target="#section-modal">Add Section--}}
                        {{--</button>--}}
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#entry-modal">Add Entry
                        </button>
                    </div>
                </div>
            </div>
            <div class="white-box">
                <h3 class="box-title m-b-0">Program Table</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Section Title</th>
                            <th>Day 1</th>
                            <th>Day 2</th>
                            <th>Day 3</th>
                            <th>Day 4</th>
                            <th>Day 5</th>
                            <th>Day 6</th>
                            <th>Day 7</th>
                        </tr>
                        </thead>
                        <tbody class="table-body">
                        @foreach($program->sections as $section)
                            <tr>
                                <td>{{ $section->title }}</td>
                                @foreach(['1', '2', '3', '4', '5', '6', '7'] as $day)
                                @php $count = 0 @endphp
                                    <td>
                                        @foreach($section->entries as $entry)
                                            @if($entry->day == $day)
                                                <p><a id="editable-{{ $entry->id }}" href="javascript:void(0);" class="editable" data-type="text" data-name="editable-{{ $entry->id }}" data-section="{{ $section->id }}" data-week="{{ $week }}" data-day="{{ $day }}" data-pk="{{ $entry->id }}" data-title="Enter meal">{{ $entry->title }}</a>
                                                <a href="javascript:void(0);" title="Delete" 
                                                   data-form="{{ 'deleteProgramEntry' . $entry->id }}"
                                                   class="btn-delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="deleteProgramEntry{{ $entry->id }}"
                                                      action="{{ route('deleteProgramEntry', ['entry' => $entry->id]) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                                </p>
                                                @php $count++ @endphp
                                            @endif
                                        @endforeach
                                        <p><a id="editable-{{ $section->id }}-{{ $week }}-{{ $day }}-{{ $count }}" href="javascript:void(0);" class="editable editable-empty" data-type="text" data-name="editable-{{ $section->id }}-{{ $week }}-{{ $day }}" data-section="{{ $section->id }}" data-week="{{ $week }}" data-day="{{ $day }}" data-pk="" data-title="Enter title"></a></p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="entry-modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <form action="{{ route('createProgramEntry', ['program' => $program->id]) }}" id="entry-form"
                  method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4 class="modal-title">Add Entry to Table</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="title" class="control-label">Entry Title</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title">
                                    {{--<div class="input-group">--}}
                                    {{--<input type="text" class="form-control" placeholder="Title" name="title">--}}
                                    {{--<span class="input-group-btn">--}}
                                    {{--<button class="btn btn-default" type="button"><i--}}
                                    {{--class="fa fa-search"></i></button>--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="form-group">
                                    <label for="arabic_title" class="control-label">Entry Arabic Title</label>
                                    <input type="text" class="form-control" name="arabic_title" id="arabic_title"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">Entry quantity</label>
                                            <input type="text" class="form-control" name="quantity" id="quantity"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity_arabic" class="control-label">Entry quantity in
                                                arabic</label>
                                            <input type="text" class="form-control" name="quantity_arabic"
                                                   id="quantity_arabic"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="section" class="control-label">Section</label>
                                    <select name="section" id="section" class="form-control">
                                        @foreach($program->sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="day" class="control-label">Day</label>
                                    <select name="day" id="day" class="form-control">
                                        @foreach(range(1,7) as $day)
                                            <option value="{{ $day }}">Day {{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="week" class="control-label">Week</label>
                                    <select name="week" id="week" class="form-control">
                                        <option value="1">Week 1</option>
                                        <option value="2">Week 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="add-section">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>








    {{--<div class="modal fade" id="section-modal" role="dialog">--}}
    {{--<div class="modal-dialog modal-md" role="document">--}}
    {{--<form action="{{ route('createProgramSection', ['program' => $program->id]) }}" id="section-form"--}}
    {{--method="post">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" data-dismiss="modal" class="close">×</button>--}}
    {{--<h4 class="modal-title">Add Section to Table</h4>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--<div class="row">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="form-group">--}}
    {{--<label for="title" class="control-label">Section Title</label>--}}
    {{--<input type="text" class="form-control" name="title" id="section-title" required>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label for="arabic_title" class="control-label">Section Arabic Title</label>--}}
    {{--<input type="text" class="form-control" name="arabic_title" id="section-arabic-title"--}}
    {{--required>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
    {{--<button type="submit" class="btn btn-success" id="add-section">Add</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}


@endsection

@section('styles')
<link href="{{ asset('css/bootstrap-editable.css') }}" rel="stylesheet"/>
<style type="text/css">
        a.btn-delete {
        color: #fb9678;
    }
</style>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-editable.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            
            function addEditable(editable) {

                editable.editable({
                        emptytext : 'Click to Add Meal',
                        url: '{{url("nfb-admin/programs")}}'+'/{{$program->id."/entry"}}',
                        params: { _token: $('meta[name="csrf-token"]').attr('content'),section: editable.data('section'), week: editable.data('week'),day: editable.data('day'),title: editable.val(), quantity: 1},
                        success : function(response) {
                            // var response= JSON.parse(response);   
                            if(response.success == true) {          
                                if(response.value != "" && response.value != null)
                                {
                                    editable.editable('destroy');
                                    editable.html(response.value);
                                    editable.data('pk',response.entry.id);
                                    editable.attr('id','editable-'+response.entry.id);
                                    addEditable(editable);

                                    if (isNaN(response.id)) {

                                        // Add delete action button
                                        editable.parents('p').append(response.delete);

                                        $('#editable-'+response.entry.id).parents('td').append('<p><a id="editable-'+response.entry.section_id+'-'+response.entry.week+'-'+response.entry.day+'-'+response.count+'" href="javascript:void(0);" class="editable editable-empty" data-type="text" data-name="editable-'+response.entry.section_id+'-'+response.entry.week+'-'+response.entry.day+'-'+response.count+'" data-section="'+response.entry.section_id+'" data-week="'+response.entry.week+'" data-day="'+response.entry.day+'" data-pk="" data-title="Enter title"></a></p>');
                                        addEditable($('#editable-'+response.entry.section_id+'-'+response.entry.week+'-'+response.entry.day+'-'+response.count));
                                    }
                                }
                            }else{          
                                alert(response.msg);
                            } 
                        },
                        error : function(response) {
                            if (response.status === 422) {
                                var responseText = JSON.parse(response.responseText);
                                return responseText.title;
                            }

                        }  
                });
            }

            $('.editable').each(function(){
                var editable = $(this);
                addEditable(editable);
            });
        });

        var tableBody = $('.table-body');
        //        $('#section-form').submit(function (event) {
        //            event.preventDefault();
        //            var data = new FormData(this);
        //            var days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        //            $.ajax({
        //                type: 'POST',
        //                url: '/nfb-admin/programs/sections/',
        //                data: data,
        //                success: function (data) {
        //                    console.log(data);
        //                    var html = '<tr><td>' + data.title + '</td>';
        //                    for (var day in days) {
        //                        html += '<td><button type="button" class="btn btn-success" data-day="' + days[day] + '" data-section="' + data.id + '">Add</button></td>';
        //                    }
        //                    tableBody.append(html);
        //                },
        //                cache: false,
        //                contentType: false,
        //                processData: false,
        //
        //                error: function () {
        //                    console.log('There was an error!');
        //                }
        //            });
        //        });
        //        sectionSearchButton.click(function () {
        ////            console.log(sectionSearchButton.val)
        //            $.ajax({
        //                type: 'get',
        //                url: '/programs/sections/search',
        //                data: {term: sectionSearchTerm.val()},
        //                success: function (data) {
        //                    console.log(data);
        //                },
        //                error: function () {
        //                    console.log('There was an error!');
        //                }
        //            });
        //        });
    </script>

@endsection