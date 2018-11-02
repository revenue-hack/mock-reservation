@extends ('layouts.base')
@section ('script')
<script src="{{asset("/jquery-ui-1.12.1.custom/jquery-ui.min.js")}}"></script>
<script src="{{asset("/vendor/fullcalendar-3.2.0/fullcalendar.min.js")}}"></script>
<script src="{{asset("/vendor/fullcalendar-3.2.0/locale-all.js")}}"></script>
<script src="{{asset("/js/reserve_frame_calendar.min.js")}}"></script>
<script src="{{asset("/js/reserve_frame_ajax.min.js")}}"></script>
<script src="{{asset("/vendor/toast/jquery.toast.js")}}"></script>
<script src="/jquery-timepicker-master/jquery.timepicker.min.js"></script>
<script type="text/javascript">
setTimepicker();
function setTimepicker() {
    var options = {step:30, timeFormat:'H:i', minTime:'9:00am', maxTime:'8:00pm'};
    $('#reserve-time').timepicker(options);

}
</script>
@endsection
@section ('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset("/jquery-ui-1.12.1.custom/jquery-ui.min.css")}}">
<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="{{asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.min.css")}}">
<link rel="stylesheet" href="{{asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.print.css")}}" media="print">
<link rel="stylesheet" href="/vendor/toast/jquery.toast.css">
<link rel="stylesheet" href="/jquery-timepicker-master/jquery.timepicker.css">
@endsection
@section ('content')
@include ('modules.admin_status')
@include ('modules.save_status')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        授業スケジュール
        <small>Control panel</small>
      </h1>
    </section>
    <!-- modal -->
    @include ("modules.reservation_frame_modal")
    <!-- Main content -->
    <section class="content" id="reservation-frames-index">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body no-padding" id="calendar-body">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
