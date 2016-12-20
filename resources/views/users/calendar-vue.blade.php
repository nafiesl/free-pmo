@extends('layouts.app')

@section('title', 'Safety Calendar')

@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title"><h3>Safety Calendar <small>Click to add/edit events</small></h3></div>
                <div class="x_content">
                    <div id='calendar'>
                        <div id="app" class="wrapper">
                            <calendar :events="events" :editable="true"></calendar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ext_css')
{!! Html::style(url('assets/css/plugins/fullcalendar.min.css')) !!}
@endsection

@section('ext_js')
{!! Html::script(url('assets/js/plugins/moment.min.js')) !!}
{!! Html::script(url('assets/js/plugins/fullcalendar.min.js')) !!}
{!! Html::script(url('assets/js/plugins/vue.min.js')) !!}
{!! Html::script(url('assets/js/plugins/vue-resource.min.js')) !!}
@endsection

@section('script')
<script>
    Vue.component('calendar', {
        template: '<div></div>',

        props: {
            events: {
                type: Array,
                required: true
            },

            editable: {
                type: Boolean,
                required: false,
                default: false
            },

            droppable: {
                type: Boolean,
                required: false,
                default: false
            },
        },

        data: function()
        {
            return {
                cal: null
            }
        },

        ready: function()
        {
            var self = this;
            self.cal = $(self.$el);

            var args = {
                lang: 'en',
                header: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'month,agendaWeek,agendaDay'
                },
                height: "auto",
                // allDaySlot: false,
                slotEventOverlap: false,
                timeFormat: 'HH:mm',

                // events: self.events,

                dayClick: function(date, data)
                {
                    self.$dispatch('day::clicked', date, data);
                },

                eventClick: function(event)
                {
                    self.$dispatch('event::clicked', event);
                }
            }

            if (self.editable)
            {
                args.editable = true;
                args.eventResize = function(event)
                {
                    self.$dispatch('event::resized', event);
                }

                args.eventDrop = function(event)
                {
                    self.$dispatch('event::dropped', event);
                }
            }

            if (self.droppable)
            {
                args.droppable = true;
                args.eventReceive = function(event)
                {
                    self.$dispatch('event::received', event);
                }
            }

            this.cal.fullCalendar(args);

        }

    })

new Vue({
    el: '#calendar',

    data: {
        events: {
                url: "{{ route('api.events.index') }}",
                type: "GET",
                error: function() {
                    alert('there was an error while fetching events!');
                }
            }
    },

    events: {
        'day::clicked': function(date, data)
        {
            // var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
            console.log(data);

            var title = event.title;
            // var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
            var start = event.start;
            // $.ajax({
            //     url: 'process.php',
            //     data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
            //     type: 'POST',
            //     dataType: 'json',
            //     success: function(response){
            //         event.id = response.eventid;
            //         $('#calendar').fullCalendar('updateEvent',event);
            //     },
            //     error: function(e){
            //         console.log(e.responseText);

            //     }
            // });
            $('#calendar').fullCalendar('updateEvent',event);
            // console.log(event);
            console.log(date);
        }
    },

    methods: {
        fetchEvents: function() {
            Vue.http.headers.common['Authorization'] = 'Bearer ' + "{{ auth()->user()->api_token }}";
            // this.$http.get("{{ route('api.events.index') }}", function(data) {
                // console.log(data);
                // console.log([
                // {
                //     title: 'Event1',
                //     start: '2016-11-10',
                // },
                // {
                //     title: 'Event2',
                //     start: '2016-11-07',
                // }
                // ]);
                // this.$set('events', data);
                // this.events = data;
            // });
        }
    },

    ready: function() {
        this.fetchEvents();
    }
})


</script>
@endsection