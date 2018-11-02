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
    url: '/api/reserve_frame',
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
        right: 'listWeek'
      },
      buttonText: {
        today: '今日',
        week: '週間',
      },
      allDaySlot: false,
      slotDuration: '00:10:00',
      defaultEventMinutes: 10,
      // 最小時間
      minTime: "10:00:00",
      // 最大時間
      maxTime: "24:00:00",
      locale: 'ja',
      defaultView: 'listWeek',
      //Random default events
      events: events,
      eventRender: function(event, element, view) {
        element.find(".fc-list-item-marker")[0].innerHTML =
          event.description;

      },
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
      eventClick: function (event, jsEvent, view) {
        var $start_time =
          event.start.toISOString().match(/(.+)T(.+)/);
        // 時間を24時間計に変換
        var $start_time_tokyo = $start_time[2].match(/(.+):(.+):(.+)/);
        var $hour = $start_time_tokyo[1];
        var $minute = $start_time_tokyo[2];
        var $second = $start_time_tokyo[3];
        $("#myFrameModal #reserve-date").val($start_time[1]);
        $("#myFrameModal #reserve-time").val($hour + ":"+ $minute);
        $("#myFrameModal #reserve-frame").val(event.reserves);
        $('<div hidden id="reserve-user"></div>').appendTo("#myFrameModal .modal-body");
        $("#myFrameModal #reserve-user").attr({'data-id': event.id});
        $('#myFrameModal').modal('show');
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
