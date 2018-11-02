@extends ('layouts.base')
@section ('script')
<script src="{{asset("/vendor/fullcalendar-3.2.0/fullcalendar.min.js")}}"></script>
<script src="{{asset("/vendor/fullcalendar-3.2.0/locale-all.js")}}"></script>
<script src="{{asset("/js/calendar.min.js")}}"></script>
@endsection
@section ('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="{{asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.min.css")}}">
<link rel="stylesheet" href="{{asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.print.css")}}" media="print">
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

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title">イベント</h4>
            </div>
            <div class="box-body">
              <!-- the events -->
              <div id="external-events">
                <div class="external-event bg-login-user-color text-c-white">あなたの担当授業</div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
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
