@extends('layouts.app')

@section('title', 'User Calendar')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="pull-right">
                    @if (request('action') == 'edit')
                        {{ link_to_route('users.calendar', __('app.done'), [], ['class' => 'btn btn-default btn-xs']) }}
                    @else
                        {{ link_to_route('users.calendar', __('event.edit'), ['action' => 'edit'], ['class' => 'btn btn-warning btn-xs']) }}
                    @endif
                </div>
                <h3>
                    User Calendar <small>Click to add/edit events</small>
                </h3>
            </div>
            <div class="x_content">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!-- calendar modal -->
<div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
            </div>
            <div class="modal-body">
                <div id="testmodal" style="padding: 5px 20px;">
                    <form id="antoform" class="form-horizontal calender" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User</label>
                            <div class="col-sm-9">
                                <span class="form-control" disabled>{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Project</label>
                            <div class="col-sm-9">
                                {!! FormField::select('project_id', $projects, ['label' => false, 'id' => 'project1']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <label for="is_allday"><input id="is_allday" type="checkbox" name="is_allday"> All Day Event?</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary antosubmit">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel2">Edit Calendar Entry</h4>
            </div>
            <form id="antoform2" class="form-horizontal calender" role="form">
                <div class="modal-body">
                    <div id="testmodal2" style="padding: 5px 20px;">
                        <input type="hidden" name="id2" id="id2">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User</label>
                            <div class="col-sm-9">
                                <span class="form-control" disabled id="user2"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title2" name="title2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" style="height:55px;" id="descr2" name="descr2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Project</label>
                            <div class="col-sm-9">
                                {!! FormField::select('project_id', $projects, ['label' => false, 'id' => 'project2']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <label for="is_allday2"><input id="is_allday2" type="checkbox" name="is_allday2"> All Day Event?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left antodelete2" title="Delete Event"><i class="fa fa-times"></i></button>
                    <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary antosubmit2">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
<div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
<!-- /calendar modal -->
@endsection

@section('ext_css')
{!! Html::style(url('assets/css/plugins/fullcalendar.min.css')) !!}
@endsection

@section('ext_js')
{!! Html::script(url('assets/js/plugins/moment.min.js')) !!}
{!! Html::script(url('assets/js/plugins/fullcalendar.min.js')) !!}
@endsection

@section('script')
<script src="{{ asset('assets/js/plugins/noty.js') }}"></script>
<script>
    (function() {
        var date = new Date(),
        d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear(),
        started,
        categoryClass;
        var selectable = "{{ request('action') }}" == 'edit';

        var calendar = $('#calendar').fullCalendar({
            header: {
                right: 'prev,next today',
                center: 'title',
                left: 'month,agendaWeek,agendaDay,listYear'
            },
            defaultView: 'agendaWeek',
            height: 550,
            selectable: selectable,
            selectHelper: true,
            minTime: '06:00:00',
            // eventLimit: true,
            weekNumbers: true,
            navLinks: true,
            slotLabelFormat: 'HH:mm',
            slotDuration: '01:00:00',
            events: {
                url: "{{ route('api.events.index', request(['action'])) }}",
                type: "GET",
                error: function() {
                    alert('there was an error while fetching events!');
                }
            },
            select: function(start, end, allDay) {
                // $('#fc_create').click();
                $('#CalenderModalNew').modal('show');

                started = start;
                ended = end;

                $(".antosubmit").on("click", function() {
                    var title = $("#title").val();
                    var body = $("#descr").val();
                    var project_id = $('#project1').val();
                    var is_allday = $("#is_allday").is(':checked');

                    if (title) {
                        $.ajax({
                            url: "{{ route('api.events.store') }}",
                            method: "POST",
                            data: { title: title, body: body, project_id: project_id, start: started.format("YYYY-MM-DD HH:mm:ss"), end: ended.format("YYYY-MM-DD HH:mm:ss"), is_allday: is_allday },
                            success: function(response){
                                calendar.fullCalendar('renderEvent', {
                                    id: response.data.id,
                                    title: title,
                                    body: body,
                                    start: started.format("YYYY-MM-DD HH:mm"),
                                    end: ended.format("YYYY-MM-DD HH:mm"),
                                    user: "{{ auth()->user()->name }}",
                                    user_id: "{{ auth()->id() }}",
                                    project_id: project_id,
                                    allDay: is_allday,
                                    editable: true
                                }, true);
                                noty({type: 'success', layout: 'bottomRight', text: response.message, timeout: 3000});
                            },
                            error: function(e){
                                alert('Error processing your request: '+e.responseText);
                            }
                        });

                    }

                    $('#title').val('');
                    $('#descr').val('');

                    calendar.fullCalendar('unselect');

                    $('#CalenderModalNew').modal('hide');

                    return false;
                });
            },
            eventClick: function(calEvent, jsEvent, view) {

                if (calEvent.editable) {
                    $('#user2').text(calEvent.user);
                    $('#title2').val(calEvent.title);
                    $('#descr2').val(calEvent.body);
                    $('#project2').val(calEvent.project_id);
                    $('#is_allday2').prop('checked', calEvent.allDay);
                    $('#CalenderModalEdit').modal();
                }
                else {
                    $('#user3').text(calEvent.user);
                    $('#title3').html(calEvent.title);
                    $('#descr3').html(calEvent.body);
                    $('#CalenderModalView').modal();
                }

                $(".antodelete2").off("click").on("click", function() {
                    var confirmBox = confirm('Delete this event?');

                    if (confirmBox) {
                        $.ajax({
                            url: "{{ route('api.events.destroy') }}",
                            method: "DELETE",
                            beforeSend: function(xhr){
                                xhr.setRequestHeader('Authorization', 'Bearer ' + "{{ auth()->user()->api_token }}");
                            },
                            data: { id: calEvent.id },
                            success: function(response){
                                noty({type: 'warning', layout: 'bottomRight', text: response.message, timeout: 3000});
                                calendar.fullCalendar('removeEvents', calEvent.id);
                            },
                            error: function(e){
                                alert('Error processing your request: '+e.responseText);
                            }
                        });

                    }

                    $('#CalenderModalEdit').modal('hide');
                });

                $("#antoform2").off("submit").on("submit", function() {
                    calEvent.title = $("#title2").val();
                    calEvent.body = $("#descr2").val();
                    calEvent.project_id = $('#project2').val();
                    calEvent.is_allday = $("#is_allday2").is(':checked');

                    $.ajax({
                        url: "{{ route('api.events.update') }}",
                        method: "PATCH",
                        data: { id: calEvent.id, title: calEvent.title, body: calEvent.body, project_id: calEvent.project_id, is_allday: calEvent.is_allday },
                        success: function(response){
                            noty({type: 'success', layout: 'bottomRight', text: response.message, timeout: 3000});
                            $('#calendar').fullCalendar('updateEvent',calEvent);
                        },
                        error: function(e){
                            alert('Error processing your request: '+e.responseText);
                        }
                    });

                    $('#CalenderModalEdit').modal('hide');
                    $('#CalenderModalView').modal('hide');

                    return false;
                });

                calendar.fullCalendar('unselect');
            },
            eventDrop: function(calEvent, delta, revertFunc) {
                var start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
                var end = calEvent.end ? calEvent.end.format('YYYY-MM-DD HH:mm:ss') : null;
                $.ajax({
                    url: "{{ route('api.events.reschedule') }}",
                    method: "PATCH",
                    data: { id: calEvent.id, start: start, end: end, is_allday: calEvent.allDay },
                    success: function(response){
                        noty({type: 'success', layout: 'bottomRight', text: response.message, timeout: 3000});
                    },
                    error: function(e){
                        revertFunc();
                        alert('Error processing your request: '+e.responseText);
                    }
                });
            },
            eventResize: function(calEvent, delta, revertFunc) {
                var start = calEvent.start.format('YYYY-MM-DD HH:mm:ss');
                var end = calEvent.end.format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                    url: "{{ route('api.events.reschedule') }}",
                    method: "PATCH",
                    data: { id: calEvent.id, start: start, end: end, is_allday: 'false' },
                    success: function(response){
                        noty({type: 'success', layout: 'bottomRight', text: response.message, timeout: 3000});
                    },
                    error: function(e){
                        revertFunc();
                        alert('Error processing your request: '+e.responseText);
                    }
                });
            }
        });
    })();
</script>
@endsection
