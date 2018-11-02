$(function () {
  display_calendar();
});

function display_calendar() {
  var events;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/api/reserve',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: JSON.stringify()
  }).done(function (data) {
    events = data;
    /* initialize the external events
    -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));
    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    var $selected;
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'agendaWeek'
      },
      buttonText: {
        today: '今日',
        week: '週間',
      },
      allDaySlot: false,
      slotDuration: '00:10:00',
      defaultEventMinutes: 10,
      // 最小時間
      minTime: "13:00:00",
      // 最大時間
      maxTime: "21:00:00",
      locale: 'ja',
      defaultView: 'agendaWeek',
      //Random default events
      events: events,
      editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        // drop時に自動的に終日にselectされるかどうか
        //copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }
      },
      timezone: 'Asia/Tokyo',
      selectable: false,
      /*
      selectHelper: true,
      select: function (start, end, jsEvent, view) {
        console.log('select');
        console.log(start.toISOString());
        console.log(end.toISOString());
        $selected = $(this);
        $('#calendar').fullCalendar('renderEvent',
          {
            id: 111,
            title: 'hoge',
            start: start,
            end: end
          },
          true
        );
        $('#calendar').fullCalendar('unselect');
        $( "#dialog" ).dialog({
          modal: true,
        　buttons: {
          　"OK": function(){
              $('#calendar').fullCalendar('removeEvent', 111);
            　$(this).dialog('close');
            }
          }
        });
      },
      //*/
      eventClick: function (event, jsEvent, view) {
        //console.log('eventClick');
        //console.log(event.start.toISOString());
        //console.log(event.end.toISOString());
        var $start_time =
          event.start.toISOString().match(/(.+)T(.+)/);
        // 時間を24時間計に変換
        var $start_time_tokyo = $start_time[2].match(/(.+):(.+):(.+)/);
        var $hour = $start_time_tokyo[1];
        var $minute = $start_time_tokyo[2];
        var $second = $start_time_tokyo[3];
        if (event.userFlag) {
          // キャンセル時は変数を変えられないようにする
          $("#modal-success").text("予約キャンセル");
          document.getElementById("reserve-date").readOnly = true;
          document.getElementById("reserve-time").readOnly = true;
          $('select[name="reserve-minute"]').attr('disabled', true);
        } else {
          $("#modal-success").text("予約");
          document.getElementById("reserve-date").readOnly = false;
          document.getElementById("reserve-time").readOnly = false;
          $('select[name="reserve-minute"]').attr('disabled', false);
        }
        $("#myModal #reserve-date").val($start_time[1]);
        $("#myModal #reserve-time").val($hour + ":"+ $minute);
        $("#myModal #reserve-minute").val(30);
        $('<div hidden id="reserve-user"></div>').appendTo("#myModal .modal-body");
        $("#myModal #reserve-user").attr({'data-user': event.userFlag});
        $("#myModal #reserve-user").attr({'data-id': event.id});
        $('#myModal').modal('show');
        $('#calendar').fullCalendar('unselect');
      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  }).fail(function (data) {
  });
}
